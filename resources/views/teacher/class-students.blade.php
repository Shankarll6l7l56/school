@extends('teacher.layouts.app')

@section('title', 'Class Students')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>{{ $class->name }} - Students</h5>
                    <small class="text-muted">Section: {{ $class->section ?? 'N/A' }} | Room: {{ $class->room_number ?? 'N/A' }}</small>
                </div>
                <div>
                    <span class="badge bg-success">Total Students: {{ $students->total() }}</span>
                </div>
            </div>
            <div class="card-body">
                @if($students->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Roll No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Actions</th>
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
                                                @if($student->date_of_birth)
                                                    <br><small class="text-muted">Age: {{ \Carbon\Carbon::parse($student->date_of_birth)->age }} years</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $student->user->email ?? 'N/A' }}</td>
                                    <td>{{ $student->phone ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $student->gender == 'male' ? 'info' : 'warning' }}">
                                            {{ ucfirst($student->gender ?? 'N/A') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $student->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($student->status ?? 'inactive') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#studentModal{{ $student->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $students->links() }}
                    </div>
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

<!-- Student Detail Modals -->
@foreach($students as $student)
<div class="modal fade" id="studentModal{{ $student->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Student Details - {{ $student->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Roll Number:</strong> {{ $student->roll_number }}</p>
                        <p><strong>Name:</strong> {{ $student->name }}</p>
                        <p><strong>Email:</strong> {{ $student->user->email ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $student->phone ?? 'N/A' }}</p>
                        <p><strong>Gender:</strong> {{ ucfirst($student->gender ?? 'N/A') }}</p>
                        <p><strong>Date of Birth:</strong> {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Blood Group:</strong> {{ $student->blood_group ?? 'N/A' }}</p>
                        <p><strong>Father's Name:</strong> {{ $student->father_name ?? 'N/A' }}</p>
                        <p><strong>Mother's Name:</strong> {{ $student->mother_name ?? 'N/A' }}</p>
                        <p><strong>Admission Date:</strong> {{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('M d, Y') : 'N/A' }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $student->status == 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($student->status ?? 'inactive') }}
                            </span>
                        </p>
                    </div>
                    <div class="col-12">
                        <p><strong>Address:</strong> {{ $student->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection 