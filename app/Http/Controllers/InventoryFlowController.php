<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Warehouse;
use App\Models\Master\Drug;
use App\Models\Master\Vendor;
use App\Models\Transaction\Bill;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use Illuminate\Http\Request;
// menambahkan untuk mendonwload excel
use App\Exports\InventoryExport;
use App\Models\Profile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Models\Inventory\Clinic;

class InventoryFlowController extends Controller
{
    public function index()
    {
        $judul = "Barang Masuk";
        $transactions = Transaction::where('variant','LPB')->paginate(5);
        return view("pages.inventory.inflow",compact('judul','transactions'));
    }
    public function create()
    {
        $vendors = Vendor::all();
        $drugs = Drug::all();
        $judul = "Tambah Barang";
        return view("pages.inventory.addStuff",compact('vendors','drugs','judul'));
    }
    public function store(Request $request)
    {
        //data yang dikirimkan FE berupa JSON
        $datas = json_decode($request->transaction);
        $transaction = Transaction::create([
            "vendor_id"=>$request->vendor_id,
            "destination"=>$request->destination ?? 'warehouse',
            "method"=>$request->method,
            "variant" => $request->destination === 'clinic' ? 'LPK' : 'LPB',
            "outcome"=>$request->total
        ]);
        // dd($transaction, $datas);

        $transaction->generate_code();
        //melakukan pembuatan tagihan
        if($transaction->method=="credit"){
            Bill::create([
                "transaction_id"=>$transaction->id,
                "total"=>$transaction->outcome,
                "status"=>"Belum Bayar",
                "due"=>$request->due
            ]);
        };
        // dd($datas);

        foreach ($datas as $item) {
            // dd($item);
            $drug = Drug::where('name',$item->name)->first();
            // dd($drug);
            $detail = TransactionDetail::create([
                "transaction_id"=>$transaction->id,
                "drug_id"=>$drug->id,
                "name"=>$drug->name." 1 ". $item->unit,
                "quantity"=>$item->quantity." " . $item->unit,
                "stock"=>$item->quantity,
                "expired"=>$item->expired,
                "piece_price"=>$item->piece_price,
                "total_price"=>$item->price,
                "used"=>false

            ]);



            //kalkulasi harga satuan dari barang
            if($item->unit=="pcs"){
                $newPrice = $item->piece_price;
            }elseif($item->unit=="pack"){
                $newPrice = $item->piece_price/$drug->piece_quantity;
            }elseif($item->unit=="box"){
                $newPrice = $item->piece_price/($drug->piece_quantity*$drug->pack_quantity);
            }
            //menentukan apakah harga perlu diubah dengan yang terbaru(jika lebih tinggi)
            if($drug->last_price < $newPrice){
                $drug->last_price = $newPrice;
                $drug->save();
            }
            //melakukan update semua harga repack
            foreach ($drug->repacks() as $repack) {
                $repack->update_price();
            }
            //kalkulasi jumlah pcs berdasarkan master data
            match ($item->unit) {
                "pcs" => $quantity= $item->quantity*$drug->piece_netto,
                "pack" => $quantity= $item->quantity*($drug->piece_netto*$drug->piece_quantity),
                "box" => $quantity= $item->quantity*($drug->piece_netto*$drug->piece_quantity*$drug->pack_quantity),
            };

            // Update inventori klinik/gudang
            if ($request->destination === 'clinic') {
                $stock = Clinic::where('drug_id', $drug->id)->first();
            } else {
                $stock = Warehouse::where('drug_id', $drug->id)->first();
            }

            $stock->quantity = $stock->quantity + $quantity;
            $detail->stock = $quantity;
            $detail->flow = $quantity;
            $detail->save();
            //mengubah nilai expired terakhir
            if ($stock->oldest == null) {
                $stock->oldest = $item->expired;
                $stock->latest = $item->expired;
                $drug->used = $detail->id;
                $detail->used = true;
                $detail->save();
                $drug->save();
            }else{
                if ($stock->oldest > $item->expired) {
                    $old = TransactionDetail::find($drug->used);
                    $old->used = false;
                    $old->save();
                    $drug->used = $detail->id;
                    $detail->used = true;
                    $detail->save();
                    $drug->save();
                    $stock->oldest = $item->expired;
                }
                if ($stock->latest < $item->expired) {
                    $stock->latest = $item->expired;
                }
            }
            $stock->save();
        };
        return redirect()->route('inventory.inflows.show',$transaction->id)->with('success','Berhasil memasukkan obat');
    }
    public function show(string $inflows)
    {
        $transaction = Transaction::find($inflows);
        $judul = "Transaksi Obat Masuk";
        $details = $transaction->details();
        $profile = Profile::first();
        // dd($profile);
        return view("pages.inventory.inflowDetail",compact('transaction','judul','details', 'profile'));
    }

    public function print()
    {

    }

    // menambahkan untuk mendonwload excel

    public function export($id)
    {
        Log::info("Export function called with ID: " . $id); // Debugging Log
        return Excel::download(new InventoryExport($id), 'inventory-'.$id.'.xlsx');
    }
}
