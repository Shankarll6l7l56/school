@extends('admin.layouts.app')

@section('title', 'Result Details - School Management System')
@section('page-title', 'Result Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up me-2"></i>
                    Exam Result Details
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Student Information</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                <span class="text-white fw-bold fs-4">{{ substr($result->student->first_name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $result->student->full_name }}</h5>
                                <p class="text-muted mb-0">{{ $result->student->student_id }}</p>
                            </div>
                        </div>
                        <p><strong>Email:</strong> {{ $result->student->email }}</p>
                        <p><strong>Phone:</strong> {{ $result->student->phone ?? 'N/A' }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $result->student->status === 'active' ? 'success' : 'warning' }}">
                                {{ ucfirst($result->student->status) }}
                            </span>
                        </p>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Exam Information</h6>
                        <p><strong>Exam Name:</strong> {{ $result->exam->exam_name }}</p>
                        <p><strong>Subject:</strong> {{ $result->subject->subject_name }}</p>
                        <p><strong>Exam Date:</strong> {{ $result->exam->exam_date }}</p>
                        <p><strong>Duration:</strong> {{ $result->exam->start_time }} - {{ $result->exam->end_time }}</p>
                        <p><strong>Total Marks:</strong> {{ $result->exam->total_marks }}</p>
                        <p><strong>Passing Marks:</strong> {{ $result->exam->passing_marks }}</p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-muted mb-3">Result Details</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="text-primary mb-1">{{ $result->marks_obtained }}</h4>
                                    <small class="text-muted">Marks Obtained</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="text-info mb-1">{{ number_format($result->percentage, 1) }}%</h4>
                                    <small class="text-muted">Percentage</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="text-{{ $result->grade === 'A+' || $result->grade === 'A' ? 'success' : ($result->grade === 'B+' || $result->grade === 'B' ? 'info' : ($result->grade === 'C+' || $result->grade === 'C' ? 'warning' : 'danger')) }} mb-1">
                                        {{ $result->grade }}
                                    </h4>
                                    <small class="text-muted">Grade</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="text-{{ $result->status === 'pass' ? 'success' : 'danger' }} mb-1">
                                        {{ ucfirst($result->status) }}
                                    </h4>
                                    <small class="text-muted">Status</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($result->remarks)
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-muted mb-3">Remarks</h6>
                        <p class="bg-light p-3 rounded">{{ $result->remarks }}</p>
                    </div>
                </div>
                @endif

                <hr>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('results.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Results
                    </a>
                    <div>
                        <a href="{{ route('results.edit', $result) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit Result
                        </a>
                        <form action="{{ route('results.destroy', $result) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this result?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Delete Result
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-lg {
    width: 60px;
    height: 60px;
    font-size: 24px;
}
</style>
@endsection 