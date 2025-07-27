@extends('teacher.layouts.app')

@section('title', 'Class Results')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Results - {{ $class->name }}</h5>
                    <small class="text-muted">Section: {{ $class->section ?? 'N/A' }}</small>
                </div>
                <div>
                    <span class="badge bg-warning">Total Results: {{ $results->total() }}</span>
                </div>
            </div>
            <div class="card-body">
                @if($results->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Student</th>
                                    <th>Roll No</th>
                                    <th>Exam</th>
                                    <th>Subject</th>
                                    <th>Marks Obtained</th>
                                    <th>Total Marks</th>
                                    <th>Percentage</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $result)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-circle fa-2x text-muted me-2"></i>
                                            <div>
                                                <strong>{{ $result->student->name }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $result->student->roll_number }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $result->exam->title ?? 'N/A' }}</strong>
                                    </td>
                                    <td>{{ $result->exam->subject->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $result->marks_obtained }}</span>
                                    </td>
                                    <td>{{ $result->total_marks }}</td>
                                    <td>
                                        <span class="badge bg-{{ $result->percentage >= 80 ? 'success' : ($result->percentage >= 60 ? 'warning' : 'danger') }}">
                                            {{ $result->percentage }}%
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $grade = '';
                                            if($result->percentage >= 90) $grade = 'A+';
                                            elseif($result->percentage >= 80) $grade = 'A';
                                            elseif($result->percentage >= 70) $grade = 'B+';
                                            elseif($result->percentage >= 60) $grade = 'B';
                                            elseif($result->percentage >= 50) $grade = 'C+';
                                            elseif($result->percentage >= 40) $grade = 'C';
                                            else $grade = 'F';
                                        @endphp
                                        <span class="badge bg-{{ $grade == 'F' ? 'danger' : ($grade == 'A+' || $grade == 'A' ? 'success' : 'warning') }}">
                                            {{ $grade }}
                                        </span>
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
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No results found</h5>
                        <p class="text-muted">No exam results have been published for this class yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 