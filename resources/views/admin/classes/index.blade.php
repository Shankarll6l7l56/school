@extends('admin.layouts.app')

@section('title', 'Classes - School Management System')
@section('page-title', 'Classes')

@section('content')
<div class="row mb-4">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('classes.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search by class name..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2 text-end">
        <a href="{{ route('classes.create') }}" class="btn btn-info">
            <i class="bi bi-plus-circle"></i> Add New Class
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-info text-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-building me-2"></i>
            Classes List
        </h5>
    </div>
    <div class="card-body">
        @if($classes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Class Name</th>
                            <th>Section</th>
                            <th>Teacher</th>
                            <th>Room</th>
                            <th>Students</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-info rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <span class="text-white fw-bold">{{ substr($class->class_name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $class->class_name }}</div>
                                        <small class="text-muted">{{ $class->description ?? 'No description' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $class->section }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <span class="text-white fw-bold">{{ substr($class->teacher->first_name, 0, 1) }}</span>
                                    </div>
                                    <span>{{ $class->teacher->full_name }}</span>
                                </div>
                            </td>
                            <td>{{ $class->room_number }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $class->students->count() }}</span>
                            </td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    @php
                                        $percentage = $class->capacity > 0 ? ($class->students->count() / $class->capacity) * 100 : 0;
                                    @endphp
                                    <div class="progress-bar bg-{{ $percentage > 80 ? 'danger' : ($percentage > 60 ? 'warning' : 'success') }}" 
                                         style="width: {{ $percentage }}%">
                                        {{ $class->students->count() }}/{{ $class->capacity }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $class->status === 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst($class->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('classes.show', $class) }}" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('classes.edit', $class) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('classes.destroy', $class) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this class?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $classes->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-building text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">No classes found</h4>
                <p class="text-muted">Get started by adding your first class.</p>
                <a href="{{ route('classes.create') }}" class="btn btn-info">
                    <i class="bi bi-plus-circle"></i> Add First Class
                </a>
            </div>
        @endif
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 16px;
}
.progress {
    border-radius: 10px;
}
</style>
@endsection 