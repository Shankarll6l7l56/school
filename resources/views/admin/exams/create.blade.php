@extends('admin.layouts.app')

@section('title', 'Schedule Exam - School Management System')
@section('page-title', 'Schedule New Exam')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-file-text me-2"></i>
                    Exam Information
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('exams.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Basic Exam Information -->
                        <div class="col-md-6">
                            <h6 class="text-danger mb-3">Basic Information</h6>
                            
                            <div class="mb-3">
                                <label for="exam_name" class="form-label">Exam Name *</label>
                                <input type="text" class="form-control @error('exam_name') is-invalid @enderror" 
                                       id="exam_name" name="exam_name" value="{{ old('exam_name') }}" required>
                                @error('exam_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="class_id" class="form-label">Class *</label>
                                <select class="form-select @error('class_id') is-invalid @enderror" id="class_id" name="class_id" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->class_name }} - {{ $class->section }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subject_id" class="form-label">Subject *</label>
                                <select class="form-select @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->subject_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Exam Schedule & Marks -->
                        <div class="col-md-6">
                            <h6 class="text-danger mb-3">Schedule & Marks</h6>
                            
                            <div class="mb-3">
                                <label for="exam_date" class="form-label">Exam Date *</label>
                                <input type="date" class="form-control @error('exam_date') is-invalid @enderror" 
                                       id="exam_date" name="exam_date" value="{{ old('exam_date') }}" 
                                       min="{{ date('Y-m-d') }}" required>
                                @error('exam_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="start_time" class="form-label">Start Time *</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                       id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="end_time" class="form-label">End Time *</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                       id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="total_marks" class="form-label">Total Marks *</label>
                                <input type="number" class="form-control @error('total_marks') is-invalid @enderror" 
                                       id="total_marks" name="total_marks" value="{{ old('total_marks') }}" 
                                       min="1" max="1000" required>
                                @error('total_marks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="passing_marks" class="form-label">Passing Marks *</label>
                                <input type="number" class="form-control @error('passing_marks') is-invalid @enderror" 
                                       id="passing_marks" name="passing_marks" value="{{ old('passing_marks') }}" 
                                       min="1" max="1000" required>
                                @error('passing_marks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-danger mb-3">Additional Information</h6>
                            <div class="mb-3">
                                <label for="instructions" class="form-label">Instructions</label>
                                <textarea class="form-control @error('instructions') is-invalid @enderror" 
                                          id="instructions" name="instructions" rows="4" 
                                          placeholder="Enter any special instructions for students...">{{ old('instructions') }}</textarea>
                                @error('instructions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('exams.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-check-circle"></i> Schedule Exam
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate passing marks as 40% of total marks if not set
    const totalMarksInput = document.getElementById('total_marks');
    const passingMarksInput = document.getElementById('passing_marks');
    
    totalMarksInput.addEventListener('input', function() {
        if (passingMarksInput.value === '') {
            const totalMarks = parseInt(this.value) || 0;
            const passingMarks = Math.ceil(totalMarks * 0.4);
            passingMarksInput.value = passingMarks;
        }
    });
    
    // Ensure end time is after start time
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    function validateEndTime() {
        if (startTimeInput.value && endTimeInput.value) {
            if (startTimeInput.value >= endTimeInput.value) {
                endTimeInput.setCustomValidity('End time must be after start time');
                endTimeInput.classList.add('is-invalid');
            } else {
                endTimeInput.setCustomValidity('');
                endTimeInput.classList.remove('is-invalid');
            }
        }
    }
    
    startTimeInput.addEventListener('change', validateEndTime);
    endTimeInput.addEventListener('change', validateEndTime);
});
</script>
@endsection 