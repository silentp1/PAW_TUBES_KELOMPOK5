<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@cinetix.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Customer Account
        User::create([
            'name' => 'John Doe',
            'email' => 'user@cinetix.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $this->command->info('Admin & Customer accounts created!');
    }
}
