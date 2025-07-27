@extends('student.layouts.app')

@section('title', 'Attendance')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Attendance Record</h5>
                <div>
                    <span class="badge bg-primary">Total Days: {{ $attendance->total() }}</span>
                </div>
            </div>
            <div class="card-body">
                @if($attendance->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendance as $record)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($record->date)->format('l') }}</td>
                                    <td>
                                        @if($record->status == 'present')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Present
                                            </span>
                                        @elseif($record->status == 'absent')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Absent
                                            </span>
                                        @elseif($record->status == 'late')
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Late
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $record->remarks ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $attendance->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No attendance records found</h5>
                        <p class="text-muted">Your attendance records will appear here once they are marked by your teacher.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 