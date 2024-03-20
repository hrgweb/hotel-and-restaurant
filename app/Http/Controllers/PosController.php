<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Table;

class PosController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        $categories = Category::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('pos', [
            'tables' => $tables,
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
