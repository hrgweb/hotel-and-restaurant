<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('products', ['data' => [], 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_id' => 'required|not_in:0,undefined,null',
                'barcode' => 'nullable',
                'name' => 'required',
                'desc' => 'nullable',
                'image' => 'nullable|image',
                'price' => 'required',
                'available' => 'nullable',
                'thumbnail' => 'nullable'
            ]);

            // Find or create uploads directory
            find_or_create_directory();

            // Handle file upload
            if ($request->hasFile('image')) {
                $fileNameToStore = img_filename($request);

                // Upload and optimized image
                img_optimzer(file: $request->file('image'), pathToSave: storage_path('app/public/uploads/' . $fileNameToStore));

                // Merge the validated thumbnail key
                $validated['thumbnail'] = $fileNameToStore;
            }

            $category = Product::create($validated);

            return response()->json($category, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'desc' => 'nullable',
                'image' => 'nullable|image',
                'thumbnail' => 'nullable'
            ]);

            unset($validated['thumbnail']);

            // Handle file upload
            if ($request->hasFile('image')) {
                // Remove old img
                old_img_remove($category->thumbnail);

                // Generate a unique file name
                $fileNameToStore = img_filename($request);

                // Upload and optimized image
                img_optimzer(file: $request->file('image'), pathToSave: storage_path('app/public/uploads/' . $fileNameToStore));

                // Merge the validated thumbnail key
                $validated['thumbnail'] = $fileNameToStore;
            }

            $category->updateOrCreate(['id' => $category->id], $validated);

            return response()->json($validated, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(Category $category)
    {
        try {
            // Remove old img
            old_img_remove($category->thumbnail);

            $category->delete();
            return response()->json(1, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
