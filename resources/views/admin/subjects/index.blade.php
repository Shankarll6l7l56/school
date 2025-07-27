@extends('admin.layouts.app')

@section('title', 'Subjects - School Management System')

@section('page-title', 'Subjects Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0">
                <i class="bi bi-book-fill me-2 text-warning"></i>
                All Subjects
            </h4>
            <p class="text-muted mb-0">Manage subject information and assignments</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('subjects.create') }}" class="btn btn-warning">
                <i class="bi bi-plus-circle me-2"></i>
                Add New Subject
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($subjects->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Subject Name</th>
                                <th>Subject Code</th>
                                <th>Teacher</th>
                                <th>Credits</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $subject->subject_name }}</div>
                                    @if($subject->description)
                                        <small class="text-muted">{{ $subject->description }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $subject->subject_code }}</span>
                                </td>
                                <td>
                                    @if($subject->teacher)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-white fw-bold">{{ substr($subject->teacher->first_name, 0, 1) }}</span>
                                            </div>
                                            {{ $subject->teacher->full_name }}
                                        </div>
                                    @else
                                        <span class="text-muted">No teacher assigned</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $subject->credits }} credits</span>
                                </td>
                                <td>
                                    @if($subject->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-warning">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('subjects.show', $subject) }}" class="btn btn-sm btn-outline-warning" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-outline-info" title="Edit Subject">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Delete Subject" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $subject->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Delete Modal for this subject -->
                                    <div class="modal fade" id="deleteModal{{ $subject->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $subject->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $subject->id }}">
                                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                                        Confirm Delete
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete the subject <strong>"{{ $subject->subject_name }}"</strong>?</p>
                                                    <p class="text-danger mb-0">
                                                        <i class="bi bi-exclamation-circle me-1"></i>
                                                        This action cannot be undone and will also delete all related exams and results.
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bi bi-trash me-2"></i>
                                                            Delete Subject
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-book-fill text-muted fa-4x mb-3"></i>
                    <h5 class="text-muted">No subjects found</h5>
                    <p class="text-muted">Get started by adding your first subject</p>
                    <a href="{{ route('subjects.create') }}" class="btn btn-warning">
                        <i class="bi bi-plus-circle me-2"></i>
                        Add First Subject
                    </a>
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