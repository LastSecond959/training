<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Initial users
        User::factory()->create([
            'name' => 'Test Admin',
            'department' => 'IT',
            'role' => 'admin',
            'email' => 'admin@mail.com',
        ]);
        
        User::factory()->create([
            'name' => 'Test User',
            'department' => 'Others',
            'role' => 'user',
            'email' => 'user@mail.com',
        ]);

        // 2 dummy admins
        User::factory()->count(2)->create([
            'department' => 'IT',
            'role' => 'admin',
        ]);

        // 3 dummy users
        User::factory()->count(3)->create();
    }
}
