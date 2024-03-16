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
                'thumbnail' => 'nullable|image|max:2048'
            ]);

            // Handle file upload
            if ($request->hasFile('thumbnail')) {
                // Get just the file extension
                $extension = $request->file('thumbnail')->getClientOriginalExtension();

                // Generate a unique file name
                $fileNameToStore = time() . '.' . $extension;

                // Merge the validated thumbnail key
                $validated['thumbnail'] = $fileNameToStore;

                // Upload file
                $request->file('thumbnail')->storeAs('public/uploads', $fileNameToStore);
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
                'thumbnail' => 'nullable|image|max:2048'
            ]);


            // Handle file upload
            if ($request->hasFile('thumbnail')) {
                // Check for the previous thumbnail, once found delete
                $path = 'app/public/uploads/';

                if ($category->thumbnail && File::exists(storage_path($path . $category->thumbnail))) {
                    unlink(storage_path($path . $category->thumbnail));
                }

                // Get file name with extension
                $fileNameWithExtension = $request->file('thumbnail')->getClientOriginalName();

                // Get just the file extension
                $extension = $request->file('thumbnail')->getClientOriginalExtension();

                // Generate a unique file name
                $fileNameToStore = time() . '.' . $extension;

                // Merge the validated thumbnail key
                $validated['thumbnail'] = $fileNameToStore;

                // Upload file
                $request->file('thumbnail')->storeAs('public/uploads', $fileNameToStore);
            }

            $category->updateOrCreate(['id' => $category->id], $validated);

            return response()->json($category, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
