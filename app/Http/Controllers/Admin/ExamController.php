<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ClassRoom;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['class', 'subject'])->latest()->paginate(10);
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $classes = ClassRoom::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        return view('admin.exams.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_marks' => 'required|integer|min:1|max:1000',
            'passing_marks' => 'required|integer|min:1|max:1000|lte:total_marks',
            'instructions' => 'nullable|string'
        ], [
            'end_time.after' => 'The end time must be after the start time.',
        ]);

        Exam::create([
            'exam_name' => $request->exam_name,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'exam_date' => $request->exam_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_marks' => $request->total_marks,
            'passing_marks' => $request->passing_marks,
            'instructions' => $request->instructions,
            'status' => 'scheduled'
        ]);

        return redirect()->route('exams.index')->with('success', 'Exam scheduled successfully!');
    }

    public function show(Exam $exam)
    {
        $exam->load(['class', 'subject', 'results.student']);
        return view('admin.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $classes = ClassRoom::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        return view('admin.exams.edit', compact('exam', 'classes', 'subjects'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'exam_name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_marks' => 'required|integer|min:1|max:1000',
            'passing_marks' => 'required|integer|min:1|max:1000|lte:total_marks',
            'instructions' => 'nullable|string',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled'
        ], [
            'end_time.after' => 'The end time must be after the start time.',
        ]);

        $exam->update($request->all());

        return redirect()->route('exams.index')->with('success', 'Exam updated successfully!');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully!');
    }

    public function updateStatus(Exam $exam, Request $request)
    {
        $request->validate([
            'status' => 'required|in:scheduled,ongoing,completed,cancelled'
        ]);

        $exam->update(['status' => $request->status]);

        return redirect()->route('exams.show', $exam)->with('success', 'Exam status updated successfully!');
    }
} 