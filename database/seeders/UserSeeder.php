<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@school.com',
            'login_id' => 'ADMIN001',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // Create Teacher User
        User::create([
            'name' => 'John Teacher',
            'email' => 'teacher@school.com',
            'login_id' => 'TCH' . strtoupper(Str::random(8)),
            'role' => 'teacher',
            'password' => Hash::make('teacher123'),
        ]);

        // Create Student User
        User::create([
            'name' => 'Alice Student',
            'email' => 'student@school.com',
            'login_id' => 'STU' . strtoupper(Str::random(8)),
            'role' => 'student',
            'password' => Hash::make('student123'),
        ]);
    }
} 