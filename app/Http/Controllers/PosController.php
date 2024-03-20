<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;

class PosController extends Controller
{
    public function index()
    {
        $tables = Table::all();

        return view('pos', ['tables' => $tables]);
    }
}
