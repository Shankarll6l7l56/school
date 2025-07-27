@extends('admin.layouts.app')

@section('title', 'Dashboard - School Management System')
@section('page-title', 'Dashboard')

@section('content')

<?php
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Models\Subject;
$tot_students = Student::count();
$tot_teachers = Teacher::count();
$tot_classes = ClassRoom::count();
$tot_subjects = Subject::count();

?>
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-white-50 text-uppercase mb-1">Total Students : <span class="text-white bg-warning rounded-pill px-2 py-1">{{ $tot_students }}</span></div>
                        <div class="h5 mb-0 text-white"> Active : {{ $stats['total_students'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people text-white-50" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-white-50 text-uppercase mb-1">Total Teachers : <span class="text-white bg-warning rounded-pill px-2 py-1">{{ $tot_teachers }}</span></div>
                        <div class="h5 mb-0 text-white"> Active : {{ $stats['total_teachers'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-workspace text-white-50" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-white-50 text-uppercase mb-1">Total Classes : <span class="text-white bg-warning rounded-pill px-2 py-1">{{ $tot_classes }}</span></div>
                        <div class="h5 mb-0 text-white"> Active : {{ $stats['total_classes'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-building text-white-50" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-white-50 text-uppercase mb-1">Total Subjects : <span class="text-white bg-warning rounded-pill px-2 py-1">{{ $tot_subjects }}</span></div>
                        <div class="h5 mb-0 text-white"> Active : {{ $stats['total_subjects'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-book text-white-50" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Students -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-people me-2"></i>
                    Recent Students
                </h5>
            </div>
            <div class="card-body">
                @if($recent_students->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_students as $student)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-white fw-bold p-1">{{ substr($student->first_name, 0, 1) }}</span>
                                            </div>
                                            {{ $student->full_name }}
                                        </div>
                                    </td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $student->status === 'active' ? 'success' : ($student->status === 'inactive' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('students.index') }}" class="btn btn-outline-primary btn-sm">
                            View All Students
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">No students found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Teachers -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person-workspace me-2"></i>
                    Recent Teachers
                </h5>
            </div>
            <div class="card-body">
                @if($recent_teachers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Specialization</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_teachers as $teacher)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-white fw-bold p-1">{{ substr($teacher->first_name, 0, 1) }}</span>
                                            </div>
                                            {{ $teacher->full_name }}
                                        </div>
                                    </td>
                                    <td>{{ $teacher->specialization }}</td>
                                    <td>
                                        <span class="badge bg-{{ $teacher->status === 'active' ? 'success' : ($teacher->status === 'inactive' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($teacher->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('teachers.index') }}" class="btn btn-outline-success btn-sm">
                            View All Teachers
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-person-workspace text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">No teachers found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Upcoming Exams -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="bi bi-calendar-event me-2"></i>
                    Upcoming Exams
                </h5>
            </div>
            <div class="card-body">
                @if($upcoming_exams->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Exam Name</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcoming_exams as $exam)
                                <tr>
                                    <td>{{ $exam->exam_name }}</td>
                                    <td>{{ $exam->class->class_name }}</td>
                                    <td>{{ $exam->subject->subject_name }}</td>
                                    <td>{{ $exam->exam_date->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam->end_time)->format('H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $exam->status === 'scheduled' ? 'primary' : ($exam->status === 'ongoing' ? 'warning' : ($exam->status === 'completed' ? 'success' : 'danger')) }}">
                                            {{ ucfirst($exam->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('exams.index') }}" class="btn btn-outline-warning btn-sm">
                            View All Exams
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-event text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">No upcoming exams</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 