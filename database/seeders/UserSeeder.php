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
        // Gunakan firstOrCreate: Parameter 1 untuk Cek, Parameter 2 untuk Isi Data
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'], 
            [
                'name' => 'admin123',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Customer Account
        User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'customer123',
                'password' => Hash::make('customer'),
                'role' => 'customer',
            ]
        );
    }
}