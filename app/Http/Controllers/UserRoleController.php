<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\UserRole;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UserRoleRequest;

class UserRoleController extends Controller
{
    public function index()
    {
        // $roles = UserRole::select(['id', 'name', 'desc', 'thumbnail'])->get();

        return view('roles', ['data' => []]);
    }

    public function store(UserRoleRequest $request)
    {
        try {
            $validated = $request->validated();

            $role = UserRole::create($validated);

            return response()->json($role, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(UserRoleRequest $request, UserRole $role)
    {
        try {
            $validated = $request->validated();

            $role->updateOrCreate(['id' => $role->id], $validated);

            return response()->json($validated, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(UserRole $role)
    {
        try {
            $role->delete();
            return response()->json(1, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
