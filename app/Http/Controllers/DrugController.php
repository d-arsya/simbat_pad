<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Warehouse;
use App\Models\Master\Category;
use App\Models\Master\Drug;
use App\Models\Master\Manufacture;
use App\Models\Master\Repack;
use App\Models\Master\Variant;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    // DrugController.php
    public function getSuggestions(Request $request)
    {
        $query = $request->input('query');
        $drugs = Drug::where('name', 'like', "%{$query}%")->with('warehouse')->get();

        return response()->json($drugs);
    }
    public function getRepacks(Request $request)
    {
        $query = $request->input('query');
        $drugs = Repack::where('name', 'like', "%{$query}%")->get();
        $drugs = $drugs->map(function ($drug) {
            $drug->stock = $drug->stock();
            $drug->drug = $drug->drug();
            return $drug;
        });

        return response()->json($drugs);
    }

    public function index(): View
    {
        $drugs = Drug::paginate(5);
        $judul = "Nama Obat";
        return view('pages.master.drug', compact('drugs', 'judul'));
    }
    public function create()
    {
        $categories = Category::all();
        $variants = Variant::all();
        $manufactures = Manufacture::all();
        $judul = "Input Obat";
        return view('pages.master.createDrug', compact('categories', 'variants', 'manufactures', 'judul'));
    }
    public function store(Request $request)
    {
        $category = Category::find($request->category_id);
        $request["code"] = $this->generateCode($category);
        $drug = Drug::create($request->all());
        $drug->default_repacks();
        $drug->default_stock();
        return redirect()->route('master.drug.edit', $drug->id)->with('success', 'Obat berhasil dibuat');
        try {
        } catch (\Throwable $th) {
            return redirect()->route('master.drug.index')->with('error', 'Obat gagal dibuat');
        }
    }
    public function edit(Drug $drug)
    {
        $categories = Category::all();
        $variants = Variant::all();
        $manufactures = Manufacture::all();
        $judul = "Edit Obat ". $drug->name;
        $repacks = $drug->repacks();
        return view('pages.master.editDrug', compact('categories', 'variants', 'manufactures', 'drug', 'judul', 'repacks'));
    }
    public function update(Request $request, Drug $drug)
    {
        $drug->update($request->all());
        $repacks = $drug->repacks();
        foreach ($repacks as $item) {
            $item->update_price();
        }
        return redirect()->back()->with('success','Berhasil mengubah data obat');
    }
    public function repack(Request $request, Drug $drug, Repack $repack)
    {
        if ($request->isMethod('DELETE')) {
            if ($repack->quantity != $drug->piece_quantity * $drug->piece_netto && $repack->quantity != $drug->piece_netto) {
                $repack->delete();
                return back()->with('success','Berhasil menghapus repack');
            }
            return back()->with('error','Gagal menghapus repack');
        } else {
            $quantity = $request->quantity;
            if ($request->piece_unit == "pcs") {
                $quantity = $request->quantity * $drug->piece_netto;
            }
            // dd($quantity);
            Repack::create([
                "drug_id" => $drug->id,
                "name" => $drug->name." ".$request->quantity." ".$request->piece_unit,
                "quantity" => $quantity,
                "margin" => $request->margin,
                "price" => $drug->calculate_price($quantity, $request->margin)
            ]);
            return back()->with('success','Berhasil membuat repack');
        }
    }
    public function destroy(Drug $drug)
    {
        try {
            if ($drug->warehouse->quantity > 0 || $drug->clinic->quantity > 0) {
                throw new Exception('Division by zero.');
            }
            $drug->delete();
            return redirect()->back()->with('success', 'Obat berhasil dihapus');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Obat gagal dihapus');
        }
    }
    function generateCode(Category $category): string
    {
        $lastDrug = $category->drugs()->last();
        if (!$lastDrug) {
            $nextNumber = 1;
        } else {
            $lastNumber = (int) substr($lastDrug->code, -4);
            $nextNumber = $lastNumber + 1;
        }
        $paddedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        return $category->code . $paddedNumber;
    }
}
