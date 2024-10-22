<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DrugController extends Controller
{
    public function index()
    {
        return view('pages.master.drug');
    }
    public function create()
    {
        return view('pages.master.createDrug');
    }
    public function store(Request $request)
    {
    }
    public function edit(string $id)
    {
        return view('pages.master.editDrug');
    }
    public function update(Request $request, string $id)
    {
    }
    public function destroy(string $id)
    {
    }
}
