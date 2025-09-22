<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed default users for authentication/login testing
     */
    public function run(): void
    {
        // Admin account
        User::updateOrCreate(
            ['email' => 'admin@akar.test'],
            [
                'full_name' => 'Administrator',
                'username' => 'admin',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Regular user account
        User::updateOrCreate(
            ['email' => 'user@akar.test'],
            [
                'full_name' => 'Demo User',
                'username' => 'user',
                'role' => 'user',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}