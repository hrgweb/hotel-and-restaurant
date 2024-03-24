<?php

namespace App\Http\Controllers;

use App\OrderStatus;
use App\Models\Table;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Contracts\Database\Query\Builder;

class PosController extends Controller
{
    public function index()
    {
        $tables = Table::with([
            'order' => function (Builder $query) {
                $query->where('status', '<>', OrderStatus::PAID);
            },
            'order.items'
        ])->get();
        $categories = Category::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('pos', [
            'tables' => $tables,
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
