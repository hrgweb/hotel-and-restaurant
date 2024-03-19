<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Staff;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StaffRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Database\Eloquent\Builder;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::with([
            'user' => fn (Builder $query) => $query->selectRaw("id, (first_name || ' ' || last_name) as name, first_name, last_name, email, username"),
            'user_role:id,role'
        ])
            ->select(['id', 'user_role_id', 'user_id'])
            ->get();
        $roles = UserRole::select(['id', 'role'])->get();

        return view('staffs', ['data' => $staffs, 'roles' => $roles]);
    }

    public function store(StaffRequest $request)
    {
        $user = null;

        DB::beginTransaction();
        try {
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'gender' => $request->input('gender'),
                'dob' => $request->input('dob'),
            ]);
            $user['name'] = $user?->first_name . ' ' . $user?->last_name;

            $roleId = $request->input('role_id');
            Staff::create([
                'user_role_id' => $roleId,
                'user_id' => $user?->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
        DB::commit();

        return response()->json([
            'user' => $user->toArray(),
            'user_role' => UserRole::findOrFail($roleId)
        ], 201);
    }

    public function update(StaffRequest $request, Staff $staff)
    {
        try {
            $validated = $request->validated();

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
            $staff->delete();
            return response()->json(1, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
