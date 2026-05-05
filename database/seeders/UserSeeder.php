<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::query()->firstOrCreate(['name' => 'admin']);

        User::create([
            'last_name' => 'admin',
            'first_name' => 'admin',
            'email' => 'admin@tydelice.fr',
            'is_active' => now(),
            'password' => bcrypt('Tydelice2026'),
            'role_id' => $adminRole->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
