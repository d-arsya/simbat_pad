<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManufactureController extends Controller
{
    public function index()
    {
        return view('pages.master.manufacture');
    }
    public function store(Request $request)
    {
    }
    public function edit(string $id)
    {
        return view('pages.master.editManufacture');
    }
    public function update(Request $request, string $id)
    {
    }
    public function destroy(string $id)
    {
    }
}