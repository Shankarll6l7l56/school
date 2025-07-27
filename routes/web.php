<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\StudentController as StudentPortalController;
use App\Http\Controllers\TeacherController as TeacherPortalController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Students Routes
        Route::resource('students', StudentController::class);
        
        // Teachers Routes
        Route::resource('teachers', TeacherController::class);
        Route::post('/teachers/{teacher}/assign-classes', [TeacherController::class, 'assignClasses'])->name('teachers.assign-classes');
        
        // Classes Routes
        Route::resource('classes', ClassController::class);
        
        // Subjects Routes
        Route::resource('subjects', SubjectController::class);
        
        // Attendance Routes
        Route::resource('attendance', AttendanceController::class);
        Route::get('/attendance/bulk/create', [AttendanceController::class, 'bulkCreate'])->name('attendance.bulk-create');
        Route::get('/attendance/students/{classId}', [AttendanceController::class, 'getStudentsByClass'])->name('attendance.students-by-class');
        
        // Exams Routes
        Route::resource('exams', ExamController::class);
        Route::patch('/exams/{exam}/status', [ExamController::class, 'updateStatus'])->name('exams.update-status');
        
        // Results Routes
        Route::resource('results', ResultController::class);
        Route::get('/results/bulk/create', [ResultController::class, 'bulkCreate'])->name('results.bulk-create');
        Route::post('/results/bulk/store', [ResultController::class, 'bulkStore'])->name('results.bulk-store');
    });

    // Student Portal Routes
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [StudentPortalController::class, 'profile'])->name('profile');
        Route::get('/attendance', [StudentPortalController::class, 'attendance'])->name('attendance');
        Route::get('/results', [StudentPortalController::class, 'results'])->name('results');
        Route::get('/exams', [StudentPortalController::class, 'exams'])->name('exams');
    });

    // Teacher Portal Routes
    Route::middleware(['role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [TeacherPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [TeacherPortalController::class, 'profile'])->name('profile');
        Route::get('/classes', [TeacherPortalController::class, 'classes'])->name('classes');
        Route::get('/classes/{classId}/students', [TeacherPortalController::class, 'classStudents'])->name('class-students');
        Route::get('/classes/{classId}/attendance', [TeacherPortalController::class, 'attendance'])->name('attendance');
        Route::post('/classes/{classId}/attendance', [TeacherPortalController::class, 'markAttendance'])->name('mark-attendance');
        Route::get('/classes/{classId}/exams', [TeacherPortalController::class, 'exams'])->name('exams');
        Route::get('/classes/{classId}/results', [TeacherPortalController::class, 'results'])->name('results');
    });
});
