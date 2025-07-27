@extends('admin.layouts.app')

@section('title', 'Class Details - School Management System')
@section('page-title', 'Class Details')

@section('content')
<div class="row justify-content-center mb-3">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-building me-2"></i>
                    Class Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-info">Basic Information</h6>
                        <p><strong>Class Name:</strong> {{ $class->class_name }}</p>
                        <p><strong>Section:</strong> {{ $class->section }}</p>
                        <p><strong>Room Number:</strong> {{ $class->room_number }}</p>
                        <p><strong>Capacity:</strong> {{ $class->capacity }} students</p>
                        <p><strong>Status:</strong> <span class="badge bg-{{ $class->status === 'active' ? 'success' : 'warning' }}">{{ ucfirst($class->status) }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-info">Assignment Information</h6>
                        <p><strong>Primary Teacher:</strong> {{ $class->teacher->full_name ?? 'Not assigned' }}</p>
                        <p><strong>Teacher Specialization:</strong> {{ $class->teacher->specialization ?? '-' }}</p>
                        <p><strong>Teacher Email:</strong> {{ $class->teacher->email ?? '-' }}</p>
                        <p><strong>Description:</strong> {{ $class->description ?? 'No description available' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="bi bi-person-workspace me-2"></i>Assigned Teachers</h6>
            </div>
            <div class="card-body">
                @if($class->teachers && $class->teachers->count())
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Teacher</th>
                                    <th>Role</th>
                                    <th>Specialization</th>
                                    <th>Email</th>
                                    <th>Assigned Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($class->teachers as $teacher)
                                <tr>
                                    <td>
                                        <strong>{{ $teacher->full_name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $teacher->pivot->role === 'primary' ? 'success' : 'info' }}">
                                            {{ ucfirst($teacher->pivot->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $teacher->specialization }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ date('d-m-Y', strtotime($teacher->pivot->assigned_date)) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $teacher->pivot->status === 'active' ? 'success' : 'warning' }}">
                                            {{ ucfirst($teacher->pivot->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">No teachers assigned to this class.</p>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0"><i class="bi bi-people me-2"></i>Enrolled Students ({{ $class->students->count() }}/{{ $class->capacity }})</h6>
            </div>
            <div class="card-body">
                @if($class->students->count())
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($class->students as $student)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $student->student_id }}</span>
                                    </td>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $student->pivot->status === 'active' ? 'success' : 'warning' }}">
                                            {{ ucfirst($student->pivot->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">No students enrolled in this class.</p>
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
                        @if($class->attendance && $class->attendance->count())
                            @php
                                $present = $class->attendance->where('status', 'present')->count();
                                $absent = $class->attendance->where('status', 'absent')->count();
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
                        <h6 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Recent Exams</h6>
                    </div>
                    <div class="card-body">
                        @if($class->exams && $class->exams->count())
                            <ul class="list-group">
                                @foreach($class->exams->take(5) as $exam)
                                    <li class="list-group-item">
                                        <strong>{{ $exam->subject->subject_name ?? 'Exam' }}</strong>:
                                        {{ $exam->exam_date ?? '-' }}
                                        <span class="text-muted">({{ $exam->total_marks ?? '-' }} marks)</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">No exams found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('classes.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('classes.edit', $class) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit Class
            </a>
        </div>
    </div>
</div>
@endsection 