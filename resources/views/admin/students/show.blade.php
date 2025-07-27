@extends('admin.layouts.app')

@section('title', 'Student Details - School Management System')
@section('page-title', 'Student Details')

@section('content')
<div class="row justify-content-center mb-3">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person-lines-fill me-2"></i>
                    Student Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Personal Information</h6>
                        <p><strong>Student ID:</strong> <span class="badge bg-success">{{ $student->student_id }}</span></p>
                        <p><strong>Login ID:</strong> <span class="badge bg-info">{{ $student->user->login_id ?? 'Not set' }}</span></p>
                        <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
                        <p><strong>Email:</strong> {{ $student->email }}</p>
                        <p><strong>Phone:</strong> {{ $student->phone ?? '-' }}</p>
                        <p><strong>Date of Birth:</strong> {{ date('d-m-y', strtotime($student->date_of_birth)) }}</p>
                        <p><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
                        <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($student->status) }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Parent/Guardian Information</h6>
                        <p><strong>Name:</strong> {{ $student->parent_name }}</p>
                        <p><strong>Phone:</strong> {{ $student->parent_phone }}</p>
                        <p><strong>Email:</strong> {{ $student->parent_email }}</p>
                        <p><strong>Address:</strong> {{ $student->address }}</p>
                        <p><strong>Admission Date:</strong> {{ date('d-m-y', strtotime($student->admission_date)) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0"><i class="bi bi-people me-2"></i>Assigned Classes</h6>
            </div>
            <div class="card-body">
                @if($student->classes->count())
                    <ul class="list-group">
                        @foreach($student->classes as $class)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $class->class_name }} - {{ $class->section }}
                                <span class="badge bg-primary">Teacher: {{ $class->teacher->full_name ?? '-' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">No classes assigned.</p>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Attendance Summary</h6>
                    </div>
                    <div class="card-body">
                        @if($student->attendance && $student->attendance->count())
                            @php
                                $present = $student->attendance->where('status', 'present')->count();
                                $absent = $student->attendance->where('status', 'absent')->count();
                                $total = $present + $absent;
                                $percentage = $total > 0 ? round(($present / $total) * 100, 2) : 0;
                            @endphp
                            <p><strong>Present Days:</strong> {{ $present }}</p>
                            <p><strong>Absent Days:</strong> {{ $absent }}</p>
                            <p><strong>Attendance %:</strong> {{ $percentage }}%</p>
                        @else
                            <p class="text-muted mb-0">No attendance records found.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Recent Results</h6>
                    </div>
                    <div class="card-body">
                        @if($student->results && $student->results->count())
                            <ul class="list-group">
                                @foreach($student->results->take(5) as $result)
                                    <li class="list-group-item">
                                        <strong>{{ $result->exam->subject->subject_name ?? 'Exam' }}</strong>:
                                        {{ $result->marks_obtained }} / {{ $result->exam->total_marks ?? '-' }}
                                        <span class="text-muted">({{ $result->exam->exam_date ?? '-' }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">No results found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection 