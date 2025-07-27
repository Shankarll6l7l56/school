<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TestUserCreationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Test creating a student with user record
        $studentId = 'STU' . strtoupper(uniqid());
        $studentUser = User::create([
            'name' => 'Test Student',
            'email' => 'teststudent@school.com',
            'login_id' => $studentId,
            'role' => 'student',
            'password' => Hash::make('password123'),
        ]);

        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => $studentId,
            'first_name' => 'Test',
            'last_name' => 'Student',
            'email' => 'teststudent@school.com',
            'phone' => '1234567890',
            'date_of_birth' => '2005-01-01',
            'gender' => 'male',
            'address' => 'Test Address',
            'parent_name' => 'Test Parent',
            'parent_phone' => '0987654321',
            'parent_email' => 'parent@test.com',
            'admission_date' => '2024-01-01',
            'status' => 'active'
        ]);

        // Test creating a teacher with user record
        $teacherId = 'TCH' . strtoupper(uniqid());
        $teacherUser = User::create([
            'name' => 'Test Teacher',
            'email' => 'testteacher@school.com',
            'login_id' => $teacherId,
            'role' => 'teacher',
            'password' => Hash::make('password123'),
        ]);

        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => $teacherId,
            'first_name' => 'Test',
            'last_name' => 'Teacher',
            'email' => 'testteacher@school.com',
            'phone' => '1234567890',
            'date_of_birth' => '1980-01-01',
            'gender' => 'female',
            'address' => 'Test Address',
            'qualification' => 'Masters',
            'specialization' => 'Mathematics',
            'joining_date' => '2020-01-01',
            'salary' => 50000.00,
            'status' => 'active'
        ]);

        $this->command->info('Test users created successfully!');
        $this->command->info('Student User ID: ' . $studentUser->id . ', Student ID: ' . $student->id);
        $this->command->info('Teacher User ID: ' . $teacherUser->id . ', Teacher ID: ' . $teacher->id);
    }
}
