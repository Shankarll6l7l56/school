@extends('teacher.layouts.app')

@section('title', 'Mark Attendance')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Mark Attendance - {{ $class->name }}</h5>
                    <small class="text-muted">Section: {{ $class->section ?? 'N/A' }} | Total Students: {{ $students->count() }}</small>
                </div>
                <div>
                    <span class="badge bg-success">{{ $date }}</span>
                </div>
            </div>
            <div class="card-body">
                @if($students->count() > 0)
                    <form action="{{ route('teacher.mark-attendance', $class->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="date" value="{{ $date }}">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="attendance_date" class="form-label">Select Date</label>
                                <input type="date" class="form-control" id="attendance_date" name="attendance_date" value="{{ $date }}" onchange="this.form.submit()">
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i>Save Attendance
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Roll No</th>
                                        <th>Student Name</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">{{ $student->roll_number }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-circle fa-2x text-muted me-2"></i>
                                                <div>
                                                    <strong>{{ $student->name }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="present_{{ $student->id }}" value="present" 
                                                    {{ isset($attendance[$student->id]) && $attendance[$student->id]->status == 'present' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-success btn-sm" for="present_{{ $student->id }}">
                                                    <i class="fas fa-check me-1"></i>Present
                                                </label>

                                                <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="absent_{{ $student->id }}" value="absent"
                                                    {{ isset($attendance[$student->id]) && $attendance[$student->id]->status == 'absent' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger btn-sm" for="absent_{{ $student->id }}">
                                                    <i class="fas fa-times me-1"></i>Absent
                                                </label>

                                                <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="late_{{ $student->id }}" value="late"
                                                    {{ isset($attendance[$student->id]) && $attendance[$student->id]->status == 'late' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-warning btn-sm" for="late_{{ $student->id }}">
                                                    <i class="fas fa-clock me-1"></i>Late
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="remarks[{{ $student->id }}]" 
                                                placeholder="Optional remarks" value="{{ $attendance[$student->id]->remarks ?? '' }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save me-2"></i>Save Attendance
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No students found</h5>
                        <p class="text-muted">No students are currently enrolled in this class.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when date changes
    document.getElementById('attendance_date').addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
@endsection 