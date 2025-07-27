<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassRoom::with('teacher', 'students');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('class_name', 'like', "%{$search}%")
                  ->orWhere('section', 'like', "%{$search}%")
                  ->orWhere('room_number', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $classes = $query->latest()->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = Teacher::where('status', 'active')->get();
        return view('admin.classes.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'section' => 'required|string|max:10',
            'capacity' => 'required|integer|min:1',
            'teacher_id' => 'required|exists:teachers,id',
            'room_number' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
            'additional_teachers' => 'nullable|array',
            'additional_teachers.*' => 'exists:teachers,id'
        ]);

        $class = ClassRoom::create([
            'class_name' => $request->class_name,
            'section' => $request->section,
            'capacity' => $request->capacity,
            'teacher_id' => $request->teacher_id,
            'room_number' => $request->room_number,
            'status' => 'active',
            'description' => $request->description
        ]);

        // Assign primary teacher
        $class->teachers()->attach($request->teacher_id, [
            'role' => 'primary',
            'assigned_date' => now(),
            'status' => 'active'
        ]);

        // Assign additional teachers if any
        if ($request->has('additional_teachers')) {
            foreach ($request->additional_teachers as $teacherId) {
                if ($teacherId != $request->teacher_id) {
                    $class->teachers()->attach($teacherId, [
                        'role' => 'secondary',
                        'assigned_date' => now(),
                        'status' => 'active'
                    ]);
                }
            }
        }

        return redirect()->route('classes.index')->with('success', 'Class created successfully!');
    }

    public function show(ClassRoom $class)
    {
        $class->load(['teacher', 'teachers', 'students']);
        return view('admin.classes.show', compact('class'));
    }

    public function edit(ClassRoom $class)
    {
        $teachers = Teacher::where('status', 'active')->get();
        return view('admin.classes.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, ClassRoom $class)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'section' => 'required|string|max:10',
            'capacity' => 'required|integer|min:1',
            'teacher_id' => 'required|exists:teachers,id',
            'room_number' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string|max:1000'
        ]);

        $class->update($request->all());

        return redirect()->route('classes.index')->with('success', 'Class updated successfully!');
    }

    public function destroy(ClassRoom $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted successfully!');
    }
} 