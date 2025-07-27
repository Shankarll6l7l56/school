@extends('admin.layouts.app')

@section('title', 'Exam Details - School Management System')
@section('page-title', 'Exam Details')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0">
                <i class="bi bi-file-text me-2 text-danger"></i>
                Exam Details
            </h4>
            <p class="text-muted mb-0">View exam information and results</p>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="btn-group" role="group">
                <a href="{{ route('exams.edit', $exam) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Exam
                </a>
                <a href="{{ route('exams.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Exams
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Exam Information -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Exam Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Exam Name</label>
                                <p class="mb-0 fs-5">{{ $exam->exam_name }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Subject</label>
                                <p class="mb-0">
                                    @if($exam->subject)
                                        <span class="badge bg-info fs-6">{{ $exam->subject->subject_name }}</span>
                                    @else
                                        <span class="text-muted">No subject assigned</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Class</label>
                                <p class="mb-0">
                                    @if($exam->class)
                                        {{ $exam->class->class_name }} - {{ $exam->class->section }}
                                    @else
                                        <span class="text-muted">No class assigned</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Exam Date</label>
                                <p class="mb-0 fs-5">{{ $exam->exam_date->format('F d, Y') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Time</label>
                                <p class="mb-0 fs-5">{{ $exam->start_time->format('H:i') }} - {{ $exam->end_time->format('H:i') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Duration</label>
                                <p class="mb-0 fs-5">
                                    @php
                                        $start = \Carbon\Carbon::parse($exam->start_time);
                                        $end = \Carbon\Carbon::parse($exam->end_time);
                                        $duration = $start->diffInMinutes($end);
                                    @endphp
                                    {{ $duration }} minutes
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Total Marks</label>
                                <p class="mb-0 fs-5">{{ $exam->total_marks }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Passing Marks</label>
                                <p class="mb-0 fs-5">{{ $exam->passing_marks }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($exam->instructions)
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Instructions</label>
                        <div class="p-3 bg-light rounded">
                            {{ $exam->instructions }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status and Actions -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-gear me-2"></i>
                        Status & Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted">Current Status</label>
                        <div class="mb-3">
                            @if($exam->status == 'scheduled')
                                <span class="badge bg-warning fs-6">Scheduled</span>
                            @elseif($exam->status == 'ongoing')
                                <span class="badge bg-info fs-6">Ongoing</span>
                            @elseif($exam->status == 'completed')
                                <span class="badge bg-success fs-6">Completed</span>
                            @else
                                <span class="badge bg-danger fs-6">Cancelled</span>
                            @endif
                        </div>
                        
                        @if($exam->status != 'completed' && $exam->status != 'cancelled')
                        <form action="{{ route('exams.update-status', $exam) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="status" class="form-label">Update Status</label>
                                <select class="form-select" name="status" id="status">
                                    <option value="scheduled" {{ $exam->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="ongoing" {{ $exam->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ $exam->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $exam->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-check-circle me-2"></i>
                                Update Status
                            </button>
                        </form>
                        @endif
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('results.create', ['exam_id' => $exam->id]) }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-2"></i>
                            Add Results
                        </a>
                        <a href="{{ route('results.index', ['exam_id' => $exam->id]) }}" class="btn btn-info">
                            <i class="bi bi-list me-2"></i>
                            View Results
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    @if($exam->results->count() > 0)
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0">
                <i class="bi bi-trophy me-2"></i>
                Exam Results ({{ $exam->results->count() }} students)
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Student</th>
                            <th>Marks Obtained</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exam->results as $result)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $result->student->name ?? 'Unknown Student' }}</div>
                                <small class="text-muted">{{ $result->student->roll_number ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $result->marks_obtained }}/{{ $exam->total_marks }}</span>
                            </td>
                            <td>
                                @php
                                    $percentage = ($result->marks_obtained / $exam->total_marks) * 100;
                                @endphp
                                <span class="badge bg-secondary">{{ number_format($percentage, 1) }}%</span>
                            </td>
                            <td>
                                @if($percentage >= 90)
                                    <span class="badge bg-success">A+</span>
                                @elseif($percentage >= 80)
                                    <span class="badge bg-success">A</span>
                                @elseif($percentage >= 70)
                                    <span class="badge bg-primary">B</span>
                                @elseif($percentage >= 60)
                                    <span class="badge bg-warning">C</span>
                                @elseif($percentage >= 50)
                                    <span class="badge bg-info">D</span>
                                @else
                                    <span class="badge bg-danger">F</span>
                                @endif
                            </td>
                            <td>
                                @if($result->marks_obtained >= $exam->passing_marks)
                                    <span class="badge bg-success">Pass</span>
                                @else
                                    <span class="badge bg-danger">Fail</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('results.edit', $result) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-trophy text-muted fa-4x mb-3"></i>
            <h5 class="text-muted">No results available</h5>
            <p class="text-muted">Results will appear here once they are added</p>
            <a href="{{ route('results.create', ['exam_id' => $exam->id]) }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>
                Add First Result
            </a>
        </div>
    </div>
    @endif
</div>
@endsection 