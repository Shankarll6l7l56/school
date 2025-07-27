<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with('classes', 'assignedClasses', 'subjects');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('teacher_id', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $teachers = $query->latest()->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers|unique:users',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'qualification' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'salary' => 'required|numeric|min:0'
        ]);

        // Create user record first
        $teacherId = 'TCH' . strtoupper(Str::random(8));
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'login_id' => $teacherId,
            'role' => 'teacher',
            'password' => Hash::make('password123'), // Default password, can be changed later
        ]);

        // Create teacher record
        Teacher::create([
            'user_id' => $user->id,
            'teacher_id' => $teacherId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'qualification' => $request->qualification,
            'specialization' => $request->specialization,
            'joining_date' => $request->joining_date,
            'salary' => $request->salary,
            'status' => 'active'
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully!');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['classes', 'assignedClasses', 'subjects']);
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'qualification' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,retired'
        ]);

        $teacher->update($request->all());

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully!');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully!');
    }

    public function assignClasses(Request $request, Teacher $teacher)
    {
        \Log::info('Assign Classes Request:', $request->all());
        $request->validate([
            'class_assignments' => 'required|array',
            'class_assignments.*.assigned' => 'required|in:1',
            'class_assignments.*.role' => 'required|in:primary,secondary,assistant'
        ]);

        $assignedCount = 0;

        foreach ($request->class_assignments as $classId => $assignment) {
            if ($assignment['assigned']) {
                // Check if teacher is already assigned to this class
                $existingAssignment = $teacher->assignedClasses()->where('class_id', $classId)->exists();
                
                if (!$existingAssignment) {
                    $teacher->assignedClasses()->attach($classId, [
                        'role' => $assignment['role'],
                        'assigned_date' => now(),
                        'status' => 'active'
                    ]);
                    $assignedCount++;
                }
            }
        }

        if ($assignedCount > 0) {
            return redirect()->route('teachers.show', $teacher)
                ->with('success', "Successfully assigned {$assignedCount} class(es) to {$teacher->full_name}!");
        } else {
            return redirect()->route('teachers.show', $teacher)
                ->with('info', 'No new classes were assigned.');
        }
    }
} 