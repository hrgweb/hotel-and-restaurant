<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Staff;
use App\Http\Requests\StaffRequest;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::select(['id', 'role'])->get();

        return view('staffs', ['data' => $staffs]);
    }

    public function store(StaffRequest $request)
    {
        try {
            $staff = Staff::create($request->validated());

            return response()->json($staff, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(StaffRequest $request, Staff $staff)
    {
        try {
            $validated = $request->validated();

            unset($validated['thumbnail']);

            // Handle file upload
            if ($request->hasFile('image')) {
                // Remove old img
                old_img_remove($staff->thumbnail);

                // Generate a unique file name
                $fileNameToStore = img_filename($request);

                // Upload and optimized image
                img_optimzer(file: $request->file('image'), pathToSave: storage_path('app/public/uploads/' . $fileNameToStore));

                // Merge the validated thumbnail key
                $validated['thumbnail'] = $fileNameToStore;
            }

            $staff->updateOrCreate(['id' => $staff->id], $validated);

            return response()->json($validated, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(Staff $staff)
    {
        try {
            // Remove old img
            old_img_remove($staff->thumbnail);

            $staff->delete();
            return response()->json(1, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
