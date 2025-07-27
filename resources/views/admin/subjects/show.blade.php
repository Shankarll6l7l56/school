@extends('admin.layouts.app')

@section('title', $subject->subject_name . ' - School Management System')
@section('page-title', 'Subject Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0">
                <i class="bi bi-book-fill me-2 text-warning"></i>
                {{ $subject->subject_name }}
            </h4>
            <p class="text-muted mb-0">Subject Code: {{ $subject->subject_code }}</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>
                Edit Subject
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Subject Information -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Subject Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold text-muted">Subject Name:</td>
                                    <td>{{ $subject->subject_name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Subject Code:</td>
                                    <td><span class="badge bg-light text-dark">{{ $subject->subject_code }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Credits:</td>
                                    <td><span class="badge bg-info">{{ $subject->credits }} credits</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Status:</td>
                                    <td>
                                        @if($subject->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            @if($subject->description)
                                <h6 class="text-muted mb-2">Description:</h6>
                                <p class="text-muted">{{ $subject->description }}</p>
                            @else
                                <p class="text-muted"><em>No description available</em></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Teacher Information -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-fill me-2"></i>
                        Assigned Teacher
                    </h5>
                </div>
                <div class="card-body">
                    @if($subject->teacher)
                        <div class="row">
                            <div class="col-md-2">
                                <div class="avatar-lg bg-success rounded-circle d-flex align-items-center justify-content-center">
                                    <span class="text-white fw-bold fs-4">{{ substr($subject->teacher->first_name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <h5 class="mb-1">{{ $subject->teacher->full_name }}</h5>
                                <p class="text-muted mb-2">{{ $subject->teacher->email }}</p>
                                @if($subject->teacher->phone)
                                    <p class="text-muted mb-0">Phone: {{ $subject->teacher->phone }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-person-x text-muted fa-3x mb-3"></i>
                            <h6 class="text-muted">No teacher assigned</h6>
                            <p class="text-muted">This subject currently has no assigned teacher</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Exams -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-file-text me-2"></i>
                        Exams ({{ $subject->exams->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($subject->exams->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Exam Title</th>
                                        <th>Date</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subject->exams as $exam)
                                    <tr>
                                        <td>{{ $exam->title }}</td>
                                        <td>{{ $exam->exam_date ? $exam->exam_date->format('M d, Y') : 'N/A' }}</td>
                                        <td>{{ $exam->duration ?? 'N/A' }}</td>
                                        <td>
                                            @if($exam->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-warning">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-file-text text-muted fa-3x mb-3"></i>
                            <h6 class="text-muted">No exams found</h6>
                            <p class="text-muted">No exams have been created for this subject yet</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Results -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-graph-up me-2"></i>
                        Results ({{ $subject->results->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($subject->results->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Student</th>
                                        <th>Exam</th>
                                        <th>Score</th>
                                        <th>Grade</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subject->results as $result)
                                    <tr>
                                        <td>{{ $result->student->full_name ?? 'N/A' }}</td>
                                        <td>{{ $result->exam->title ?? 'N/A' }}</td>
                                        <td>{{ $result->score ?? 'N/A' }}</td>
                                        <td>
                                            @if($result->grade)
                                                <span class="badge bg-success">{{ $result->grade }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $result->created_at ? $result->created_at->format('M d, Y') : 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-graph-up text-muted fa-3x mb-3"></i>
                            <h6 class="text-muted">No results found</h6>
                            <p class="text-muted">No results have been recorded for this subject yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Stats -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bar-chart me-2"></i>
                        Quick Stats
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-warning mb-1">{{ $subject->exams->count() }}</h4>
                                <small class="text-muted">Exams</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-info mb-1">{{ $subject->results->count() }}</h4>
                            <small class="text-muted">Results</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-gear me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i>
                            Edit Subject
                        </a>
                        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to Subjects
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
.avatar-lg {
    width: 80px;
    height: 80px;
    font-size: 32px;
}
</style>
@endsection 