<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NormalUserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if normal user exists before creating
        if (!User::where('email', 'user@example.com')->exists()) {
            User::create([
                'name' => 'Normal User',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
                'is_admin' => 0
            ]);
        }
    }
} 