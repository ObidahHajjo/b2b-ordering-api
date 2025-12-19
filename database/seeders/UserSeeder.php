<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'last_name' => 'admin',
            'first_name' => 'admin',
            'email' => 'admin@tydelice.fr',
            'password' => bcrypt('Tydelice2026'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
