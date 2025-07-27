<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Str;

class UpdateExistingUsersLoginIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update admin user
        $adminUser = User::where('role', 'admin')->first();
        if ($adminUser && !$adminUser->login_id) {
            $adminUser->update(['login_id' => 'ADMIN001']);
        }

        // Update existing students
        $students = Student::all();
        foreach ($students as $student) {
            if ($student->user && !$student->user->login_id) {
                $student->user->update(['login_id' => $student->student_id]);
            }
        }

        // Update existing teachers
        $teachers = Teacher::all();
        foreach ($teachers as $teacher) {
            if ($teacher->user && !$teacher->user->login_id) {
                $teacher->user->update(['login_id' => $teacher->teacher_id]);
            }
        }

        // Update any remaining users without login_id
        $usersWithoutLoginId = User::whereNull('login_id')->get();
        foreach ($usersWithoutLoginId as $user) {
            $loginId = '';
            switch ($user->role) {
                case 'admin':
                    $loginId = 'ADMIN' . strtoupper(Str::random(6));
                    break;
                case 'teacher':
                    $loginId = 'TCH' . strtoupper(Str::random(8));
                    break;
                case 'student':
                    $loginId = 'STU' . strtoupper(Str::random(8));
                    break;
            }
            $user->update(['login_id' => $loginId]);
        }
    }
}
