@extends('teacher.layouts.app')

@section('title', 'Class Exams')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Exams - {{ $class->name }}</h5>
                    <small class="text-muted">Section: {{ $class->section ?? 'N/A' }}</small>
                </div>
                <div>
                    <span class="badge bg-info">Total Exams: {{ $exams->total() }}</span>
                </div>
            </div>
            <div class="card-body">
                @if($exams->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Exam Title</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Duration</th>
                                    <th>Total Marks</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exams as $exam)
                                <tr>
                                    <td>
                                        <strong>{{ $exam->title }}</strong>
                                        @if($exam->description)
                                            <br><small class="text-muted">{{ Str::limit($exam->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $exam->subject->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') }}</td>
                                    <td>{{ $exam->start_time ?? 'TBD' }}</td>
                                    <td>{{ $exam->duration ?? 'TBD' }}</td>
                                    <td>{{ $exam->total_marks ?? 'TBD' }}</td>
                                    <td>
                                        @php
                                            $examDate = \Carbon\Carbon::parse($exam->exam_date);
                                            $today = \Carbon\Carbon::today();
                                            
                                            if($examDate->isPast()) {
                                                $status = 'completed';
                                                $badgeClass = 'secondary';
                                                $statusText = 'Completed';
                                            } elseif($examDate->isToday()) {
                                                $status = 'today';
                                                $badgeClass = 'warning';
                                                $statusText = 'Today';
                                            } elseif($examDate->diffInDays($today) <= 7) {
                                                $status = 'upcoming';
                                                $badgeClass = 'info';
                                                $statusText = 'Upcoming';
                                            } else {
                                                $status = 'scheduled';
                                                $badgeClass = 'primary';
                                                $statusText = 'Scheduled';
                                            }
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $exams->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No exams found</h5>
                        <p class="text-muted">No exams have been scheduled for this class yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 