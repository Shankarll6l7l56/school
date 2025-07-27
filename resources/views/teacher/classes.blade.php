@extends('teacher.layouts.app')

@section('title', 'My Classes')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chalkboard me-2"></i>My Classes</h5>
                <div>
                    <span class="badge bg-success">Total Classes: {{ $classes->total() }}</span>
                </div>
            </div>
            <div class="card-body">
                @if($classes->count() > 0)
                    <div class="row">
                        @foreach($classes as $class)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="card-title text-success">{{ $class->name }}</h5>
                                        <span class="badge bg-primary">{{ $class->students_count ?? 0 }} Students</span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <p class="card-text">
                                            <strong>Section:</strong> {{ $class->section ?? 'N/A' }}<br>
                                            <strong>Room:</strong> {{ $class->room_number ?? 'N/A' }}<br>
                                            <strong>Capacity:</strong> {{ $class->capacity ?? 'N/A' }}
                                        </p>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('teacher.class-students', $class->id) }}" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-users me-1"></i>View Students
                                        </a>
                                        <a href="{{ route('teacher.attendance', $class->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-calendar-check me-1"></i>Mark Attendance
                                        </a>
                                        <a href="{{ route('teacher.exams', $class->id) }}" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-file-alt me-1"></i>Manage Exams
                                        </a>
                                        <a href="{{ route('teacher.results', $class->id) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="fas fa-chart-line me-1"></i>View Results
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $classes->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-chalkboard fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No classes assigned</h5>
                        <p class="text-muted">You haven't been assigned to any classes yet. Please contact the administrator.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 