@extends('teacher.layouts.app')

@section('title', 'Profile')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Teacher Profile</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-user-circle fa-6x text-success"></i>
                        </div>
                        <h5>{{ $teacher->name }}</h5>
                        <p class="text-muted">Teacher ID: {{ $teacher->teacher_id ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <p class="form-control-plaintext">{{ $teacher->name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Teacher ID</label>
                                <p class="form-control-plaintext">{{ $teacher->teacher_id ?? 'Not assigned' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <p class="form-control-plaintext">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Phone</label>
                                <p class="form-control-plaintext">{{ $teacher->phone ?? 'Not provided' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Department</label>
                                <p class="form-control-plaintext">{{ $teacher->department ?? 'Not assigned' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Qualification</label>
                                <p class="form-control-plaintext">{{ $teacher->qualification ?? 'Not provided' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Date of Birth</label>
                                <p class="form-control-plaintext">{{ $teacher->date_of_birth ? \Carbon\Carbon::parse($teacher->date_of_birth)->format('M d, Y') : 'Not provided' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Gender</label>
                                <p class="form-control-plaintext">{{ ucfirst($teacher->gender ?? 'Not specified') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Blood Group</label>
                                <p class="form-control-plaintext">{{ $teacher->blood_group ?? 'Not specified' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Joining Date</label>
                                <p class="form-control-plaintext">{{ $teacher->joining_date ? \Carbon\Carbon::parse($teacher->joining_date)->format('M d, Y') : 'Not provided' }}</p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Address</label>
                                <p class="form-control-plaintext">{{ $teacher->address ?? 'Not provided' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Emergency Contact</label>
                                <p class="form-control-plaintext">{{ $teacher->emergency_contact ?? 'Not provided' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-{{ $teacher->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($teacher->status ?? 'inactive') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 