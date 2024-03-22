<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Table;
use App\Http\Requests\TableRequest;
use App\TableStatus;
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
            $request->merge(['status' => TableStatus::AVAILABLE->value]);

            // Check if bulk
            if ($request->input('isBulk')) {
                $result = [];
                $i = 1;
                $prefix = ucwords($request->input('prefix'));
                while ($i <= $request->input('bulkOfTable')) {
                    $category = Table::create([
                        'prefix' => $prefix,
                        'name' => $i,
                        'table_name' =>  $prefix . ' ' . $i,
                        'capacity' => $request->input('capacity'),
                        'status' => $request->input('status')
                    ]);
                    array_push($result, $category);
                    $i++;
                }

                return response()->json(collect($result), 201);
            }

            $category = Table::create($request->all());

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
