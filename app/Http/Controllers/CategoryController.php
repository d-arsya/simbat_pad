<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('pages.master.category');
    }
    public function store(Request $request)
    {
    }
    public function edit(string $id)
    {
        return view('pages.master.editCategory');
    }
    public function update(Request $request, string $id)
    {
    }
    public function destroy(string $id)
    {
    }
}
