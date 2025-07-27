@extends('admin.layouts.app')

@section('title', 'Attendance - School Management System')

@section('page-title', 'Attendance Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0">
                <i class="bi bi-calendar-check me-2 text-primary"></i>
                Attendance Records
            </h4>
            <p class="text-muted mb-0">Manage student attendance and records</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>
                Record Attendance
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('attendance.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="class_id" class="form-label">Select Class</label>
                    <select class="form-select" id="class_id" name="class_id">
                        <option value="">Choose a class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }} - {{ $class->section }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $selectedDate }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-search me-1"></i>
                            View Attendance
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="card">
        <div class="card-body">
            @if($selectedClass && $attendances->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Class</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <span class="text-white fw-bold">{{ substr($attendance->student->first_name, 0, 1) }}</span>
                                        </div>
                                        {{ $attendance->student->full_name }}
                                    </div>
                                </td>
                                <td>{{ $attendance->class->class_name }} - {{ $attendance->class->section }}</td>
                                <td>{{ $attendance->date->format('M d, Y') }}</td>
                                <td>
                                    @if($attendance->status == 'present')
                                        <span class="badge bg-success">Present</span>
                                    @elseif($attendance->status == 'absent')
                                        <span class="badge bg-danger">Absent</span>
                                    @elseif($attendance->status == 'late')
                                        <span class="badge bg-warning">Late</span>
                                    @else
                                        <span class="badge bg-info">Excused</span>
                                    @endif
                                </td>
                                <td>{{ $attendance->remarks ?? '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif($selectedClass)
                <div class="text-center py-5">
                    <i class="bi bi-calendar-check text-muted fa-4x mb-3"></i>
                    <h5 class="text-muted">No attendance records found</h5>
                    <p class="text-muted">No attendance has been recorded for this class on the selected date</p>
                    <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>
                        Record Attendance
                    </a>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-calendar-check text-muted fa-4x mb-3"></i>
                    <h5 class="text-muted">Select a class to view attendance</h5>
                    <p class="text-muted">Choose a class and date to view attendance records</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
}
</style>
@endsection 