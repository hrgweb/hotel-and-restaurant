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
        $roles = UserRole::select(['id', 'role'])->get();

        return view('roles', ['data' => $roles]);
    }

    public function store(UserRoleRequest $request)
    {
        try {
            $role = UserRole::create($request->validated());

            return response()->json($role, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(UserRoleRequest $request, UserRole $user_role)
    {
        try {
            $validated = $request->validated();

            $user_role->updateOrCreate(['id' => $user_role->id], $validated);

            return response()->json($validated, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(UserRole $user_role)
    {
        try {
            $user_role->delete();
            return response()->json(1, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
