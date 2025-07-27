@extends('admin.layouts.app')

@section('title', 'Teachers - School Management System')
@section('page-title', 'Teachers')

@section('content')
<div class="row mb-4">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('teachers.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="retired" {{ request('status') === 'retired' ? 'selected' : '' }}>Retired</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2 text-end">
        <a href="{{ route('teachers.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add New Teacher
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-person-workspace me-2"></i>
            Teachers List
        </h5>
    </div>
    <div class="card-body">
        @if($teachers->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Teacher ID</th>
                            <!-- <th>Login ID</th> -->
                            <th>Name</th>
                            <th>Email</th>
                            <th>Specialization</th>
                            <th>Classes</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                        <tr>
                            <td>
                                <span class="badge bg-success">{{ $teacher->teacher_id }}</span>
                            </td>
                            <!-- <td>
                                <span class="badge bg-info">{{ $teacher->user->login_id ?? 'Not set' }}</span>
                            </td> -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <span class="text-white fw-bold">{{ substr($teacher->first_name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $teacher->full_name }}</div>
                                        <small class="text-muted">{{ $teacher->qualification }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $teacher->email }}</td>
                            <td>
                                <span class="badge bg-info">{{ $teacher->specialization }}</span>
                            </td>
                            <td>
                                @if($teacher->assignedClasses->count() > 0)
                                    @foreach($teacher->assignedClasses->take(2) as $class)
                                        <span class="badge bg-{{ $class->pivot->role === 'primary' ? 'success' : 'primary' }} me-1">
                                            {{ $class->class_name }} ({{ $class->pivot->role }})
                                        </span>
                                    @endforeach
                                    @if($teacher->assignedClasses->count() > 2)
                                        <span class="badge bg-secondary">+{{ $teacher->assignedClasses->count() - 2 }} more</span>
                                    @endif
                                @else
                                    <span class="text-muted">No classes</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $teacher->status === 'active' ? 'success' : ($teacher->status === 'inactive' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($teacher->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-sm btn-outline-success" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this teacher?')">
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
                {{ $teachers->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-person-workspace text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">No teachers found</h4>
                <p class="text-muted">Get started by adding your first teacher.</p>
                <a href="{{ route('teachers.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Add First Teacher
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
</style>
@endsection 