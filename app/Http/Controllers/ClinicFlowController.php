<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Clinic;
use App\Models\Inventory\Warehouse;
use App\Models\Master\Drug;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicFlowController extends Controller
{
    public function index()
    {
        $judul = "Barang Masuk";
        $transactions = Transaction::where('variant', 'LPK')->paginate(5);
        return view("pages.clinic.inflow",compact('judul','transactions'));
    }
    public function create()
    {
        $judul = "Tambah Obat Klinik";
        return view('pages.clinic.addStuff',compact('judul'));
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
        //data yang dikirimkan FE berupa JSON
        $datas = json_decode($request->transaction);
            
            if (!$datas || !is_array($datas)) {
                throw new \Exception('Invalid transaction data');
            }

        $transaction = Transaction::create([
                "destination" => "clinic",
                "variant" => "LPK",
        ]);
            
            if (!$transaction) {
                throw new \Exception('Failed to create transaction');
            }
            
        $transaction->generate_code();

        foreach ($datas as $item) {
                if (!isset($item->name) || !isset($item->quantity)) {
                    throw new \Exception('Invalid item data');
                }

                $drugAdd = Drug::where('name', $item->name)->first();
                if (!$drugAdd) {
                    throw new \Exception("Drug {$item->name} not found");
                }

                $quantity = $drugAdd->piece_netto * $item->quantity;
                $warehouse = Warehouse::where('drug_id', $drugAdd->id)->first();
                
                if (!$warehouse) {
                    throw new \Exception("Warehouse stock not found for {$drugAdd->name}");
                }

                if ($warehouse->quantity < $quantity) {
                    throw new \Exception("Insufficient stock in warehouse for {$drugAdd->name}");
                }

            $warehouse->quantity = $warehouse->quantity - $quantity;
            $warehouse->save();

                $clinic = Clinic::where('drug_id', $drugAdd->id)->first();
                if (!$clinic) {
                    $clinic = new Clinic();
                    $clinic->drug_id = $drugAdd->id;
                    $clinic->quantity = 0;
                }

            $clinic->quantity = $clinic->quantity + $quantity;
                
            //pengondisian untuk memastikan data expire
            if ($clinic->oldest == null) {
                $clinic->oldest = $warehouse->oldest;
                $clinic->latest = $warehouse->latest;
                } else {
                if ($clinic->oldest > $warehouse->oldest) {
                    $clinic->oldest = $warehouse->oldest;
                }
                if ($clinic->latest < $warehouse->latest) {
                    $clinic->latest = $warehouse->latest;
                }
            }
            $clinic->save();

            $require = $quantity;
            //mengambil obat dari inventory menggunakan fungsi pada model
                $drugAdd->clinicUseWarehouse($transaction, $require, $item->quantity);
            }

            DB::commit();
            return redirect()->route('clinic.inflows.show', $transaction->id)->with('success', 'Berhasil menambahkan obat');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan obat: ' . $e->getMessage());
        }
    }
    public function show(string $inflows)
    {
        $transaction = Transaction::find($inflows);
        $judul = "Transaksi Obat Masuk";
        $details = $transaction->details();
        // dd($transaction);
        return view("pages.clinic.inflowDetail",compact('transaction','judul','details'));
    }

}
