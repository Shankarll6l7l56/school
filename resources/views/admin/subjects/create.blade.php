@extends('admin.layouts.app')

@section('title', 'Add Subject - School Management System')
@section('page-title', 'Add New Subject')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-book-plus me-2"></i>
                    Subject Information
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <h6 class="text-warning mb-3">Basic Information</h6>
                            
                            <div class="mb-3">
                                <label for="subject_name" class="form-label">Subject Name *</label>
                                <input type="text" class="form-control @error('subject_name') is-invalid @enderror" 
                                       id="subject_name" name="subject_name" value="{{ old('subject_name') }}" required>
                                @error('subject_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="credits" class="form-label">Credits *</label>
                                <select class="form-select @error('credits') is-invalid @enderror" id="credits" name="credits" required>
                                    <option value="">Select Credits</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('credits') == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i == 1 ? 'Credit' : 'Credits' }}
                                        </option>
                                    @endfor
                                </select>
                                @error('credits')
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
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
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
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-check-circle"></i> Create Subject
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
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
});
</script>
@endsection 