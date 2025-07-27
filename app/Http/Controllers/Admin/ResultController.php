<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::with(['student', 'exam', 'subject'])->latest()->paginate(10);
        return view('admin.results.index', compact('results'));
    }

    public function create()
    {
        $exams = Exam::where('status', 'completed')->get();
        $students = Student::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        return view('admin.results.create', compact('exams', 'students', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks_obtained' => 'required|integer|min:0',
            'remarks' => 'nullable|string'
        ]);

        // Get exam details to calculate percentage and grade
        $exam = Exam::findOrFail($request->exam_id);
        $percentage = ($request->marks_obtained / $exam->total_marks) * 100;
        $grade = $this->calculateGrade($percentage);
        $status = $request->marks_obtained >= $exam->passing_marks ? 'pass' : 'fail';

        Result::create([
            'student_id' => $request->student_id,
            'exam_id' => $request->exam_id,
            'subject_id' => $request->subject_id,
            'marks_obtained' => $request->marks_obtained,
            'percentage' => $percentage,
            'grade' => $grade,
            'status' => $status,
            'remarks' => $request->remarks
        ]);

        return redirect()->route('results.index')->with('success', 'Result recorded successfully!');
    }

    public function show(Result $result)
    {
        $result->load(['student', 'exam', 'subject']);
        return view('admin.results.show', compact('result'));
    }

    public function edit(Result $result)
    {
        $exams = Exam::where('status', 'completed')->get();
        $students = Student::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        return view('admin.results.edit', compact('result', 'exams', 'students', 'subjects'));
    }

    public function update(Request $request, Result $result)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks_obtained' => 'required|integer|min:0',
            'remarks' => 'nullable|string'
        ]);

        // Recalculate percentage and grade
        $exam = Exam::findOrFail($request->exam_id);
        $percentage = ($request->marks_obtained / $exam->total_marks) * 100;
        $grade = $this->calculateGrade($percentage);
        $status = $request->marks_obtained >= $exam->passing_marks ? 'pass' : 'fail';

        $result->update([
            'student_id' => $request->student_id,
            'exam_id' => $request->exam_id,
            'subject_id' => $request->subject_id,
            'marks_obtained' => $request->marks_obtained,
            'percentage' => $percentage,
            'grade' => $grade,
            'status' => $status,
            'remarks' => $request->remarks
        ]);

        return redirect()->route('results.index')->with('success', 'Result updated successfully!');
    }

    public function destroy(Result $result)
    {
        $result->delete();
        return redirect()->route('results.index')->with('success', 'Result deleted successfully!');
    }

    public function bulkCreate()
    {
        $exams = Exam::where('status', 'completed')->get();
        return view('admin.results.bulk-create', compact('exams'));
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'results' => 'required|array',
            'results.*.student_id' => 'required|exists:students,id',
            'results.*.marks_obtained' => 'required|integer|min:0'
        ]);

        $exam = Exam::findOrFail($request->exam_id);

        foreach ($request->results as $data) {
            $percentage = ($data['marks_obtained'] / $exam->total_marks) * 100;
            $grade = $this->calculateGrade($percentage);
            $status = $data['marks_obtained'] >= $exam->passing_marks ? 'pass' : 'fail';

            Result::updateOrCreate(
                [
                    'student_id' => $data['student_id'],
                    'exam_id' => $request->exam_id,
                    'subject_id' => $exam->subject_id
                ],
                [
                    'marks_obtained' => $data['marks_obtained'],
                    'percentage' => $percentage,
                    'grade' => $grade,
                    'status' => $status,
                    'remarks' => $data['remarks'] ?? null
                ]
            );
        }

        return redirect()->route('results.index')->with('success', 'Results recorded successfully!');
    }

    private function calculateGrade($percentage)
    {
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B+';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 50) return 'C+';
        if ($percentage >= 40) return 'C';
        if ($percentage >= 30) return 'D';
        return 'F';
    }
} 