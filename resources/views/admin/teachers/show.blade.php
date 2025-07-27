@extends('admin.layouts.app')

@section('title', 'Teacher Details - School Management System')
@section('page-title', 'Teacher Details')

@section('content')
<div class="row justify-content-center mb-3">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person-workspace me-2"></i>
                    Teacher Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-success">Personal Information</h6>
                        <p><strong>Teacher ID:</strong> <span class="badge bg-success">{{ $teacher->teacher_id }}</span></p>
                        <p><strong>Login ID:</strong> <span class="badge bg-info">{{ $teacher->user->login_id ?? 'Not set' }}</span></p>
                        <p><strong>Name:</strong> {{ $teacher->first_name }} {{ $teacher->last_name }}</p>
                        <p><strong>Email:</strong> {{ $teacher->email }}</p>
                        <p><strong>Phone:</strong> {{ $teacher->phone ?? '-' }}</p>
                        <p><strong>Date of Birth:</strong> {{ date('d-m-y', strtotime($teacher->date_of_birth)) }}</p>
                        <p><strong>Gender:</strong> {{ ucfirst($teacher->gender) }}</p>
                        <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($teacher->status) }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Professional Information</h6>
                        <p><strong>Qualification:</strong> {{ $teacher->qualification }}</p>
                        <p><strong>Specialization:</strong> {{ $teacher->specialization }}</p>
                        <p><strong>Joining Date:</strong> {{ date('d-m-y', strtotime($teacher->joining_date)) }}</p>
                        <p><strong>Salary:</strong> ${{ number_format($teacher->salary, 2) }}</p>
                        <p><strong>Address:</strong> {{ $teacher->address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-people me-2"></i>Assigned Classes ({{ $teacher->assignedClasses->count() }})</h6>
                <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#assignClassesModal">
                    <i class="bi bi-plus-circle"></i> Assign More Classes
                </button>
            </div>
            <div class="card-body">
                @if($teacher->assignedClasses->count())
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Class</th>
                                    <th>Role</th>
                                    <th>Students</th>
                                    <th>Assigned Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teacher->assignedClasses as $class)
                                <tr>
                                    <td>
                                        <strong>{{ $class->class_name }} - {{ $class->section }}</strong>
                                        <br><small class="text-muted">{{ $class->room_number }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $class->pivot->role === 'primary' ? 'success' : 'info' }}">
                                            {{ ucfirst($class->pivot->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $class->students->count() }} Students</span>
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($class->pivot->assigned_date)) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $class->pivot->status === 'active' ? 'success' : 'warning' }}">
                                            {{ ucfirst($class->pivot->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('classes.show', $class) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">No classes assigned to this teacher.</p>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-book me-2"></i>Assigned Subjects</h6>
            </div>
            <div class="card-body">
                @if($teacher->subjects->count())
                    <ul class="list-group">
                        @foreach($teacher->subjects as $subject)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $subject->subject_name }}
                                <span class="badge bg-info">{{ $subject->subject_code }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">No subjects assigned.</p>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit Teacher
            </a>
        </div>
    </div>
</div>

<!-- Assign Classes Modal -->
<div class="modal fade" id="assignClassesModal" tabindex="-1" aria-labelledby="assignClassesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignClassesModalLabel">
                    <i class="bi bi-plus-circle me-2"></i>Assign Classes to {{ $teacher->full_name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('teachers.assign-classes', $teacher) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Instructions</h6>
                        <ul class="mb-0">
                            <li>Select classes you want to assign to this teacher</li>
                            <li>Choose the role for each class assignment</li>
                            <li>You can assign multiple classes at once</li>
                            <li>Primary role means the teacher is the main teacher for that class</li>
                        </ul>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Available Classes</label>
                        <div class="row">
                            @php
                                $availableClasses = \App\Models\ClassRoom::where('status', 'active')
                                    ->whereNotIn('id', $teacher->assignedClasses->pluck('id'))
                                    ->get();
                            @endphp
                            
                            @if($availableClasses->count() > 0)
                                @foreach($availableClasses as $class)
                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                        <input type="hidden" name="class_assignments[{{ $class->id }}][assigned]" value="0">
                                        <input class="form-check-input" type="checkbox" 
                                               name="class_assignments[{{ $class->id }}][assigned]" 
                                               value="1" id="class_{{ $class->id }}">
                                        <label class="form-check-label" for="class_{{ $class->id }}">
                                            <strong>{{ $class->class_name }} - {{ $class->section }}</strong>
                                            <br><small class="text-muted">{{ $class->room_number }} | {{ $class->students->count() }} students</small>
                                        </label>
                                    </div>
                                    <div class="ms-4 mt-1">
                                        <select class="form-select form-select-sm" name="class_assignments[{{ $class->id }}][role]">
                                            <option value="secondary">Secondary Teacher</option>
                                            <option value="primary">Primary Teacher</option>
                                            <option value="assistant">Assistant Teacher</option>
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <p class="text-muted">No available classes to assign. All active classes are already assigned to this teacher.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Assign Classes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 