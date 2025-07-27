<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Result;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            return redirect()->route('login')->with('error', 'Student profile not found.');
        }

        // Get student's attendance
        $attendance = Attendance::where('student_id', $student->id)
            ->whereMonth('date', now()->month)
            ->get();

        $presentDays = $attendance->where('status', 'present')->count();
        $absentDays = $attendance->where('status', 'absent')->count();
        $totalDays = $presentDays + $absentDays;
        $attendancePercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 2) : 0;

        // Get recent results
        $recentResults = Result::where('student_id', $student->id)
            ->with('exam')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get upcoming exams from student's classes
        $classIds = $student->classes->pluck('id');
        $upcomingExams = Exam::whereIn('class_id', $classIds)
            ->where('exam_date', '>=', now()->toDateString())
            ->orderBy('exam_date', 'asc')
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'student',
            'attendancePercentage',
            'presentDays',
            'absentDays',
            'totalDays',
            'recentResults',
            'upcomingExams'
        ));
    }

    public function profile()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            return redirect()->route('login')->with('error', 'Student profile not found.');
        }

        return view('student.profile', compact('student'));
    }

    public function attendance()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            return redirect()->route('login')->with('error', 'Student profile not found.');
        }

        $attendance = Attendance::where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('student.attendance', compact('student', 'attendance'));
    }

    public function results()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            return redirect()->route('login')->with('error', 'Student profile not found.');
        }

        $results = Result::where('student_id', $student->id)
            ->with('exam')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('student.results', compact('student', 'results'));
    }

    public function exams()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            return redirect()->route('login')->with('error', 'Student profile not found.');
        }

        // Get exams from student's classes
        $classIds = $student->classes->pluck('id');
        $exams = Exam::whereIn('class_id', $classIds)
            ->orderBy('exam_date', 'desc')
            ->paginate(15);

        return view('student.exams', compact('student', 'exams'));
    }
} 