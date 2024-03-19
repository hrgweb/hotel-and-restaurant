<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        // $tables = Table::select(['id', 'name', 'desc', 'thumbnail'])->get();

        return view('tables', ['data' => []]);
    }

    public function store(CategoryRequest $request)
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

            $category = Category::create($validated);

            return response()->json($category, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $validated = $request->validated();

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
