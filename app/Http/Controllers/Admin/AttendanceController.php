<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::where('status', 'active')->get();
        $selectedClass = request('class_id');
        $selectedDate = request('date', now()->format('Y-m-d'));
        
        $attendances = collect();
        
        if ($selectedClass) {
            $attendances = Attendance::with(['student', 'class'])
                ->where('class_id', $selectedClass)
                ->where('date', $selectedDate)
                ->get();
        }
        
        return view('admin.attendance.index', compact('classes', 'selectedClass', 'selectedDate', 'attendances'));
    }

    public function create()
    {
        $classes = ClassRoom::with('students')->where('status', 'active')->get();
        return view('admin.attendance.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'attendance_data' => 'required|array',
            'attendance_data.*.student_id' => 'required|exists:students,id',
            'attendance_data.*.status' => 'required|in:present,absent,late,excused'
        ]);

        foreach ($request->attendance_data as $data) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $data['student_id'],
                    'class_id' => $request->class_id,
                    'date' => $request->date
                ],
                [
                    'status' => $data['status'],
                    'remarks' => $data['remarks'] ?? null
                ]
            );
        }

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully!');
    }

    public function show(Attendance $attendance)
    {
        $attendance->load(['student', 'class']);
        return view('admin.attendance.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $attendance->load(['student', 'class']);
        return view('admin.attendance.edit', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late,excused',
            'remarks' => 'nullable|string'
        ]);

        $attendance->update($request->all());

        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully!');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'Attendance record deleted successfully!');
    }

    public function bulkCreate()
    {
        $classes = ClassRoom::with('students')->where('status', 'active')->get();
        return view('admin.attendance.bulk-create', compact('classes'));
    }

    public function getStudentsByClass($classId)
    {
        $class = ClassRoom::with('students')->findOrFail($classId);
        return response()->json($class->students);
    }
} 