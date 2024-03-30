<?php

namespace Database\Factories;

use Exception;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = null;
        $user = null;

        DB::beginTransaction();
        try {
            // Create admin user
            $user = User::create([
                'first_name' => 'admin-fn',
                'last_name' => 'admin-ln',
                'username' => 'admin',
                'password' => bcrypt('admin')
            ]);

            // Create admin role
            $role = UserRole::create(['role' => 'admin']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $e->getMessage();
        }
        DB::commit();

        return [
            'user_role_id' => $role->id,
            'user_id' => $user->id,
        ];
    }
}
