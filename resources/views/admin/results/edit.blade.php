@extends('admin.layouts.app')

@section('title', 'Edit Result - School Management System')
@section('page-title', 'Edit Result')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Exam Result
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('results.update', $result) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                            <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $result->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->full_name }} ({{ $student->student_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="exam_id" class="form-label">Exam <span class="text-danger">*</span></label>
                            <select name="exam_id" id="exam_id" class="form-select @error('exam_id') is-invalid @enderror" required>
                                <option value="">Select Exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ old('exam_id', $result->exam_id) == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->exam_name }} - {{ $exam->exam_date }}
                                    </option>
                                @endforeach
                            </select>
                            @error('exam_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                            <select name="subject_id" id="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $result->subject_id) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->subject_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="marks_obtained" class="form-label">Marks Obtained <span class="text-danger">*</span></label>
                            <input type="number" name="marks_obtained" id="marks_obtained" class="form-control @error('marks_obtained') is-invalid @enderror" 
                                   value="{{ old('marks_obtained', $result->marks_obtained) }}" min="0" step="0.01" required>
                            @error('marks_obtained')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" 
                                  rows="3" placeholder="Any additional remarks...">{{ old('remarks', $result->remarks) }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Result Summary -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Current Result Summary</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Marks:</strong> {{ $result->marks_obtained }}/{{ $result->exam->total_marks }}
                            </div>
                            <div class="col-md-3">
                                <strong>Percentage:</strong> {{ number_format($result->percentage, 1) }}%
                            </div>
                            <div class="col-md-3">
                                <strong>Grade:</strong> {{ $result->grade }}
                            </div>
                            <div class="col-md-3">
                                <strong>Status:</strong> 
                                <span class="badge bg-{{ $result->status === 'pass' ? 'success' : 'danger' }}">
                                    {{ ucfirst($result->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('results.show', $result) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Result
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Update Result
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 