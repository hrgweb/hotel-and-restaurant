<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'desc' => 'nullable'
            ]);

            $category = Category::create($validated);

            return response()->json($category, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }
}
