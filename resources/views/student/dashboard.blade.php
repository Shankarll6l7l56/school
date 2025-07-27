@extends('student.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Welcome Card -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h2 class="card-title text-primary">Welcome, {{ $student->name }}!</h2>
                <p class="card-text">Class: {{ $student->class->name ?? 'Not Assigned' }} | Roll No: {{ $student->roll_number }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-md-4 mb-4">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-calendar-check fa-3x mb-3"></i>
                <h3 class="card-title">{{ $attendancePercentage }}%</h3>
                <p class="card-text">Attendance This Month</p>
                <small>Present: {{ $presentDays }} | Absent: {{ $absentDays }}</small>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-chart-line fa-3x mb-3"></i>
                <h3 class="card-title">{{ $recentResults->count() }}</h3>
                <p class="card-text">Recent Results</p>
                <small>Latest exam results</small>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card stats-card">
            <div class="card-body text-center">
                <i class="fas fa-file-alt fa-3x mb-3"></i>
                <h3 class="card-title">{{ $upcomingExams->count() }}</h3>
                <p class="card-text">Upcoming Exams</p>
                <small>Next scheduled exams</small>
            </div>
        </div>
    </div>

    <!-- Recent Results -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Recent Results</h5>
            </div>
            <div class="card-body">
                @if($recentResults->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Exam</th>
                                    <th>Subject</th>
                                    <th>Marks</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentResults as $result)
                                <tr>
                                    <td>{{ $result->exam->title ?? 'N/A' }}</td>
                                    <td>{{ $result->exam->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $result->marks_obtained }}/{{ $result->total_marks }}</td>
                                    <td>
                                        <span class="badge bg-{{ $result->percentage >= 80 ? 'success' : ($result->percentage >= 60 ? 'warning' : 'danger') }}">
                                            {{ $result->percentage }}%
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No recent results available.</p>
                @endif
                <div class="text-center mt-3">
                    <a href="{{ route('student.results') }}" class="btn btn-outline-primary">View All Results</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Exams -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Upcoming Exams</h5>
            </div>
            <div class="card-body">
                @if($upcomingExams->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Exam</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingExams as $exam)
                                <tr>
                                    <td>{{ $exam->title }}</td>
                                    <td>{{ $exam->subject->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') }}</td>
                                    <td>{{ $exam->start_time ?? 'TBD' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No upcoming exams scheduled.</p>
                @endif
                <div class="text-center mt-3">
                    <a href="{{ route('student.exams') }}" class="btn btn-outline-primary">View All Exams</a>
                </div>
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
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('student.attendance') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-calendar-check me-2"></i>View Attendance
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('student.results') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-chart-line me-2"></i>View Results
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('student.exams') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-file-alt me-2"></i>View Exams
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('student.profile') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-user me-2"></i>Update Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 