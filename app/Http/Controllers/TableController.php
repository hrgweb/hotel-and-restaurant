<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Table;
use App\Http\Requests\TableRequest;
use Illuminate\Support\Facades\Log;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::selectRaw('id, prefix, name, (prefix || " " || name) as table_name')->get();

        return view('tables', ['data' => $tables]);
    }

    public function store(TableRequest $request)
    {
        try {
            $category = Table::create($request->validated());

            return response()->json($category, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(TableRequest $request, Table $table)
    {
        try {
            $table->updateOrCreate(['id' => $table->id], $request->validated());

            return response()->json($request->validated(), 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(Table $table)
    {
        try {
            $table->delete();
            return response()->json(1, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
