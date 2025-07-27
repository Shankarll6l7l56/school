<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('classes');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('parent_name', 'like', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $students = $query->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $classes = ClassRoom::where('status', 'active')->get();
        return view('admin.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students|unique:users',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'parent_email' => 'required|email',
            'admission_date' => 'required|date',
            'class_ids' => 'array',
            'class_ids.*' => 'exists:classes,id'
        ]);

        // Create user record first
        $studentId = 'STU' . strtoupper(Str::random(8));
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'login_id' => $studentId,
            'role' => 'student',
            'password' => Hash::make('password123'), // Default password, can be changed later
        ]);

        // Create student record
        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => $studentId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'parent_name' => $request->parent_name,
            'parent_phone' => $request->parent_phone,
            'parent_email' => $request->parent_email,
            'admission_date' => $request->admission_date,
            'status' => 'active'
        ]);

        if ($request->has('class_ids')) {
            $student->classes()->attach($request->class_ids, [
                'enrollment_date' => now(),
                'status' => 'enrolled'
            ]);
        }

        return redirect()->route('students.index')->with('success', 'Student created successfully!');
    }

    public function show(Student $student)
    {
        $student->load(['classes', 'attendance', 'results']);
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classes = ClassRoom::where('status', 'active')->get();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id . '|unique:users,email,' . $student->user_id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'parent_email' => 'required|email',
            'admission_date' => 'required|date',
            'status' => 'required|in:active,inactive,graduated,transferred',
            'class_ids' => 'array',
            'class_ids.*' => 'exists:classes,id'
        ]);

        // Update user record
        if ($student->user) {
            $student->user->update([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
            ]);
        }

        // Update student record
        $student->update($request->except('class_ids'));

        if ($request->has('class_ids')) {
            $student->classes()->sync($request->class_ids);
        }

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        // Delete associated user record
        if ($student->user) {
            $student->user->delete();
        }
        
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
} 