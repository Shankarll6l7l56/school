@extends('admin.layouts.app')

@section('title', 'Exams - School Management System')

@section('page-title', 'Exams Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0">
                <i class="bi bi-file-text me-2 text-danger"></i>
                All Exams
            </h4>
            <p class="text-muted mb-0">Manage exam schedules and information</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('exams.create') }}" class="btn btn-danger">
                <i class="bi bi-plus-circle me-2"></i>
                Schedule Exam
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($exams->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Exam Name</th>
                                <th>Subject</th>
                                <th>Class</th>
                                <th>Date & Time</th>
                                <th>Marks</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exams as $exam)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $exam->exam_name }}</div>
                                    @if($exam->description)
                                        <small class="text-muted">{{ $exam->description }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($exam->subject)
                                        <span class="badge bg-info">{{ $exam->subject->subject_name }}</span>
                                    @else
                                        <span class="text-muted">No subject</span>
                                    @endif
                                </td>
                                <td>
                                    @if($exam->class)
                                        {{ $exam->class->class_name }} - {{ $exam->class->section }}
                                    @else
                                        <span class="text-muted">No class</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $exam->exam_date->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $exam->start_time->format('H:i') }} - {{ $exam->end_time->format('H:i') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $exam->total_marks }} marks</span>
                                </td>
                                <td>
                                    @if($exam->status == 'scheduled')
                                        <span class="badge bg-warning">Scheduled</span>
                                    @elseif($exam->status == 'ongoing')
                                        <span class="badge bg-info">Ongoing</span>
                                    @elseif($exam->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('exams.show', $exam) }}" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('exams.edit', $exam) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-file-text text-muted fa-4x mb-3"></i>
                    <h5 class="text-muted">No exams found</h5>
                    <p class="text-muted">Get started by scheduling your first exam</p>
                    <a href="{{ route('exams.create') }}" class="btn btn-danger">
                        <i class="bi bi-plus-circle me-2"></i>
                        Schedule First Exam
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 