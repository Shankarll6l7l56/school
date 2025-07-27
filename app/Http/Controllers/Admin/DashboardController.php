<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\Exam;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => Student::where('status', 'active')->count(),
            'total_teachers' => Teacher::where('status', 'active')->count(),
            'total_classes' => ClassRoom::where('status', 'active')->count(),
            'total_subjects' => Subject::where('status', 'active')->count(),
        ];

        $recent_students = Student::latest()->take(5)->get();
        $recent_teachers = Teacher::latest()->take(5)->get();
        $upcoming_exams = Exam::where('status', 'scheduled')
                              ->where('exam_date', '>=', now()->toDateString())
                              ->orderBy('exam_date')
                              ->take(5)
                              ->get();

        return view('admin.dashboard', compact('stats', 'recent_students', 'recent_teachers', 'upcoming_exams'));
    }
} 