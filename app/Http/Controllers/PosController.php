<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Product;
use App\Models\Category;

class PosController extends Controller
{
    public function index()
    {
        $tables = Table::with(['order' => [
            'items'
        ]])->get();
        $categories = Category::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('pos', [
            'tables' => $tables,
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
