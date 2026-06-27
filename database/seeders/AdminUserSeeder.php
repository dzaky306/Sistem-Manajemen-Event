<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@event.com')->exists()) {
            User::create([
                'name' => 'Admin Event',
                'email' => 'admin@event.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]);
        }

        if (!User::where('email', 'user@event.com')->exists()) {
            User::create([
                'name' => 'User Biasa',
                'email' => 'user@event.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]);
        }

        $this->command->info('Admin and user seeded successfully!');
    }
}