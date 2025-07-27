@extends('admin.layouts.app')

@section('title', 'Edit Subject - School Management System')
@section('page-title', 'Edit Subject')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Subject Information
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('subjects.update', $subject) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <h6 class="text-warning mb-3">Basic Information</h6>
                            
                            <div class="mb-3">
                                <label for="subject_name" class="form-label">Subject Name *</label>
                                <input type="text" class="form-control @error('subject_name') is-invalid @enderror" 
                                       id="subject_name" name="subject_name" value="{{ old('subject_name', $subject->subject_name) }}" required>
                                @error('subject_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subject_code" class="form-label">Subject Code</label>
                                <input type="text" class="form-control" id="subject_code" value="{{ $subject->subject_code }}" readonly>
                                <small class="text-muted">Subject code is auto-generated and cannot be changed</small>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3">{{ old('description', $subject->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="credits" class="form-label">Credits *</label>
                                <select class="form-select @error('credits') is-invalid @enderror" id="credits" name="credits" required>
                                    <option value="">Select Credits</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('credits', $subject->credits) == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i == 1 ? 'Credit' : 'Credits' }}
                                        </option>
                                    @endfor
                                </select>
                                @error('credits')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="active" {{ old('status', $subject->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $subject->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Teacher Assignment -->
                        <div class="col-md-6">
                            <h6 class="text-warning mb-3">Teacher Assignment</h6>
                            
                            <div class="mb-3">
                                <label for="teacher_id" class="form-label">Assign Teacher *</label>
                                <select class="form-select @error('teacher_id') is-invalid @enderror" id="teacher_id" name="teacher_id" required>
                                    <option value="">Select Teacher</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id', $subject->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->full_name }} 
                                            @if($teacher->subjects)
                                                ({{ $teacher->subjects->count() }} subjects)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Teacher Information Preview -->
                            <div id="teacher-info" class="mt-3" style="display: none;">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Teacher Information</h6>
                                        <div id="teacher-details"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Current Teacher Info -->
                            @if($subject->teacher)
                            <div class="mt-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Current Teacher</h6>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-success fw-bold">{{ substr($subject->teacher->first_name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <p class="mb-1">{{ $subject->teacher->full_name }}</p>
                                                <small>{{ $subject->teacher->email }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('subjects.show', $subject) }}" class="btn btn-secondary">
                                    <i class="bi bi-eye me-2"></i>
                                    View Details
                                </a>
                                <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Update Subject
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Subject Statistics -->
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-bar-chart me-2"></i>
                    Subject Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="border-end">
                            <h4 class="text-warning mb-1">{{ $subject->exams->count() }}</h4>
                            <small class="text-muted">Total Exams</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border-end">
                            <h4 class="text-info mb-1">{{ $subject->results->count() }}</h4>
                            <small class="text-muted">Total Results</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4 class="text-success mb-1">{{ $subject->credits }}</h4>
                        <small class="text-muted">Credits</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const teacherSelect = document.getElementById('teacher_id');
    const teacherInfo = document.getElementById('teacher-info');
    const teacherDetails = document.getElementById('teacher-details');
    
    // Teacher data for preview (you might want to load this via AJAX in a real application)
    const teachers = @json($teachers);
    
    teacherSelect.addEventListener('change', function() {
        const selectedTeacherId = this.value;
        
        if (selectedTeacherId) {
            const teacher = teachers.find(t => t.id == selectedTeacherId);
            if (teacher) {
                teacherDetails.innerHTML = `
                    <p class="mb-1"><strong>Name:</strong> ${teacher.first_name} ${teacher.last_name}</p>
                    <p class="mb-1"><strong>Email:</strong> ${teacher.email}</p>
                    <p class="mb-1"><strong>Phone:</strong> ${teacher.phone || 'N/A'}</p>
                    <p class="mb-0"><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                `;
                teacherInfo.style.display = 'block';
            }
        } else {
            teacherInfo.style.display = 'none';
        }
    });

    // Show teacher info on page load if teacher is selected
    if (teacherSelect.value) {
        teacherSelect.dispatchEvent(new Event('change'));
    }
});
</script>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
}
</style>
@endsection 