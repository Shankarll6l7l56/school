@extends('teacher.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Welcome Card -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h2 class="card-title text-success">Welcome, {{ $teacher->name }}!</h2>
                <p class="card-text">Teacher ID: {{ $teacher->teacher_id ?? 'N/A' }} | Department: {{ $teacher->department ?? 'Not Assigned' }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-md-3 mb-4">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-chalkboard fa-3x mb-3"></i>
                <h3 class="card-title">{{ $classes->count() }}</h3>
                <p class="card-text">Total Classes</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-users fa-3x mb-3"></i>
                <h3 class="card-title">{{ $totalStudents }}</h3>
                <p class="card-text">Total Students</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-3x mb-3"></i>
                <h3 class="card-title">{{ $presentToday }}</h3>
                <p class="card-text">Present Today</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-times-circle fa-3x mb-3"></i>
                <h3 class="card-title">{{ $absentToday }}</h3>
                <p class="card-text">Absent Today</p>
            </div>
        </div>
    </div>

    <!-- My Classes -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chalkboard me-2"></i>My Classes</h5>
            </div>
            <div class="card-body">
                @if($classes->count() > 0)
                    <div class="row">
                        @foreach($classes as $class)
                        <div class="col-md-6 mb-3">
                            <div class="card border">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $class->name }}</h6>
                                    <p class="card-text text-muted">Section: {{ $class->section ?? 'N/A' }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-primary">{{ $class->students_count ?? 0 }} Students</span>
                                        <a href="{{ route('teacher.class-students', $class->id) }}" class="btn btn-sm btn-outline-success">
                                            View Students
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">No classes assigned yet.</p>
                @endif
                <div class="text-center mt-3">
                    <a href="{{ route('teacher.classes') }}" class="btn btn-outline-success">Manage Classes</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Exams -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Recent Exams</h5>
            </div>
            <div class="card-body">
                @if($recentExams->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentExams as $exam)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $exam->title }}</h6>
                                    <small class="text-muted">{{ $exam->subject->name ?? 'N/A' }}</small>
                                </div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($exam->exam_date)->format('M d') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">No recent exams.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($classes->count() > 0)
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('teacher.attendance', $classes->first()->id) }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-calendar-check me-2"></i>Mark Attendance
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('teacher.exams', $classes->first()->id) }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-file-alt me-2"></i>Manage Exams
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('teacher.results', $classes->first()->id) }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-chart-line me-2"></i>View Results
                        </a>
                    </div>
                    @endif
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('teacher.profile') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-user me-2"></i>Update Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 