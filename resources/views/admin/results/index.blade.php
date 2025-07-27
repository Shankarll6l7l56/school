@extends('admin.layouts.app')

@section('title', 'Results - School Management System')
@section('page-title', 'Results')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('results.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Search by student name..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="exam_id" class="form-select">
                            <option value="">All Exams</option>
                            @foreach($exams ?? [] as $exam)
                                <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->exam_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pass" {{ request('status') === 'pass' ? 'selected' : '' }}>Pass</option>
                            <option value="fail" {{ request('status') === 'fail' ? 'selected' : '' }}>Fail</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('results.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('results.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add New Result
        </a>
        <a href="{{ route('results.bulk-create') }}" class="btn btn-info">
            <i class="bi bi-upload"></i> Bulk Upload
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-graph-up me-2"></i>
            Exam Results
        </h5>
    </div>
    <div class="card-body">
        @if($results->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Student</th>
                            <th>Exam</th>
                            <th>Subject</th>
                            <th>Marks Obtained</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <span class="text-white fw-bold">{{ substr($result->student->first_name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $result->student->full_name }}</div>
                                        <small class="text-muted">{{ $result->student->student_id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $result->exam->exam_name }}</div>
                                <small class="text-muted">{{ $result->exam->exam_date }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $result->subject->subject_name }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $result->marks_obtained }}</div>
                                <small class="text-muted">/ {{ $result->exam->total_marks }}</small>
                            </td>
                            <td>
                                <div class="fw-bold">{{ number_format($result->percentage, 1) }}%</div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $result->grade === 'A+' || $result->grade === 'A' ? 'success' : ($result->grade === 'B+' || $result->grade === 'B' ? 'info' : ($result->grade === 'C+' || $result->grade === 'C' ? 'warning' : 'danger')) }}">
                                    {{ $result->grade }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $result->status === 'pass' ? 'success' : 'danger' }}">
                                    {{ ucfirst($result->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('results.show', $result) }}" class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('results.edit', $result) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('results.destroy', $result) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this result?')">
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
                {{ $results->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-graph-up text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">No results found</h4>
                <p class="text-muted">Get started by adding exam results.</p>
                <a href="{{ route('results.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add First Result
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