<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories', ['data' => $categories]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'desc' => 'nullable',
                'image' => 'nullable|image|max:2048',
                'thumbnail' => 'nullable'
            ]);

            // Handle file upload
            if ($request->hasFile('image')) {
                // Get just the file extension
                $extension = $request->file('image')->getClientOriginalExtension();

                // Generate a unique file name
                $fileNameToStore = time() . '.' . $extension;

                // Upload file
                $request->file('image')->storeAs('public/uploads', $fileNameToStore);

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

    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'desc' => 'nullable',
                'image' => 'nullable|image|max:2048',
                'thumbnail' => 'nullable'
            ]);

            unset($validated['thumbnail']);

            // Handle file upload
            if ($request->hasFile('image')) {
                // Check for the previous thumbnail, once found delete
                $path = 'app/public/uploads/';

                if ($category->thumbnail && File::exists(storage_path($path . $category->thumbnail))) {
                    unlink(storage_path($path . $category->thumbnail));
                }

                // Get just the file extension
                $extension = $request->file('image')->getClientOriginalExtension();

                // Generate a unique file name
                $fileNameToStore = time() . '.' . $extension;

                // Upload file
                $request->file('image')->storeAs('public/uploads', $fileNameToStore);

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
            $category->delete();
            return response()->json(1, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
