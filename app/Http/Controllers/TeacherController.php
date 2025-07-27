<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('login')->with('error', 'Teacher profile not found.');
        }

        // Get teacher's classes
        $classes = ClassRoom::where('teacher_id', $teacher->id)->get();
        
        // Get total students from all classes
        $totalStudents = 0;
        foreach ($classes as $class) {
            $totalStudents += $class->students()->count();
        }
        
        // Get today's attendance
        $studentIds = collect();
        foreach ($classes as $class) {
            $studentIds = $studentIds->merge($class->students()->pluck('students.id'));
        }
        
        $todayAttendance = Attendance::whereIn('student_id', $studentIds)
            ->whereDate('date', today())->get();
        
        $presentToday = $todayAttendance->where('status', 'present')->count();
        $absentToday = $todayAttendance->where('status', 'absent')->count();
        
        // Get recent exams
        $recentExams = Exam::whereIn('class_id', $classes->pluck('id'))
            ->orderBy('exam_date', 'desc')
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact(
            'teacher',
            'classes',
            'totalStudents',
            'presentToday',
            'absentToday',
            'recentExams'
        ));
    }

    public function profile()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('login')->with('error', 'Teacher profile not found.');
        }

        return view('teacher.profile', compact('teacher'));
    }

    public function classes()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('login')->with('error', 'Teacher profile not found.');
        }

        $classes = ClassRoom::where('teacher_id', $teacher->id)
            ->withCount('students')
            ->paginate(10);

        return view('teacher.classes', compact('teacher', 'classes'));
    }

    public function classStudents($classId)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('login')->with('error', 'Teacher profile not found.');
        }

        $class = ClassRoom::where('id', $classId)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $students = $class->students()
            ->orderBy('first_name')
            ->paginate(20);

        return view('teacher.class-students', compact('teacher', 'class', 'students'));
    }

    public function attendance($classId)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('login')->with('error', 'Teacher profile not found.');
        }

        $class = ClassRoom::where('id', $classId)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $students = $class->students()->orderBy('first_name')->get();
        
        $date = request('date', today()->toDateString());
        
        $attendance = Attendance::whereIn('student_id', $students->pluck('id'))
            ->whereDate('date', $date)
            ->get()
            ->keyBy('student_id');

        return view('teacher.attendance', compact('teacher', 'class', 'students', 'attendance', 'date'));
    }

    public function markAttendance(Request $request, $classId)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('login')->with('error', 'Teacher profile not found.');
        }

        $class = ClassRoom::where('id', $classId)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late'
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $request->date
                ],
                [
                    'status' => $status
                ]
            );
        }

        return redirect()->route('teacher.attendance', $classId)
            ->with('success', 'Attendance marked successfully!');
    }

    public function exams($classId)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('login')->with('error', 'Teacher profile not found.');
        }

        $class = ClassRoom::where('id', $classId)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $exams = Exam::where('class_id', $classId)
            ->orderBy('exam_date', 'desc')
            ->paginate(15);

        return view('teacher.exams', compact('teacher', 'class', 'exams'));
    }

    public function results($classId)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('login')->with('error', 'Teacher profile not found.');
        }

        $class = ClassRoom::where('id', $classId)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $studentIds = $class->students()->pluck('students.id');
        
        $results = Result::whereIn('student_id', $studentIds)
            ->with(['student', 'exam'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('teacher.results', compact('teacher', 'class', 'results'));
    }
} 