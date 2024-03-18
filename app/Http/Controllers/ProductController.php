<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::with(['category:id,name'])->get();
        $categories = Category::select(['id', 'name'])->get();

        return view('products', ['data' => $data, 'categories' => $categories]);
    }

    public function store(ProductRequest $request)
    {
        try {
            $validated = $request->validated();

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

    public function update(ProductRequest $request, Product $product)
    {
        try {
            $validated = $request->validated();

            unset($validated['thumbnail']);

            // Handle file upload
            if ($request->hasFile('image')) {
                // Remove old img
                old_img_remove($product->thumbnail);

                // Generate a unique file name
                $fileNameToStore = img_filename($request);

                // Upload and optimized image
                img_optimzer(file: $request->file('image'), pathToSave: storage_path('app/public/uploads/' . $fileNameToStore));

                // Merge the validated thumbnail key
                $validated['thumbnail'] = $fileNameToStore;
            }

            $product->updateOrCreate(['id' => $product->id], $validated);

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
