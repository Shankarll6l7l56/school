@extends('admin.layouts.app')

@section('title', 'Add Class - School Management System')
@section('page-title', 'Add New Class')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-building-add me-2"></i>
                    Class Information
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('classes.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <h6 class="text-info mb-3">Basic Information</h6>
                            
                            <div class="mb-3">
                                <label for="class_name" class="form-label">Class Name *</label>
                                <input type="text" class="form-control @error('class_name') is-invalid @enderror" 
                                       id="class_name" name="class_name" value="{{ old('class_name') }}" 
                                       placeholder="e.g., Class 10, Grade 5" required>
                                @error('class_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="section" class="form-label">Section *</label>
                                <input type="text" class="form-control @error('section') is-invalid @enderror" 
                                       id="section" name="section" value="{{ old('section') }}" 
                                       placeholder="e.g., A, B, C" required>
                                @error('section')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="room_number" class="form-label">Room Number *</label>
                                <input type="text" class="form-control @error('room_number') is-invalid @enderror" 
                                       id="room_number" name="room_number" value="{{ old('room_number') }}" 
                                       placeholder="e.g., 101, Lab 2" required>
                                @error('room_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="capacity" class="form-label">Capacity *</label>
                                <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                       id="capacity" name="capacity" value="{{ old('capacity') }}" 
                                       min="1" max="100" placeholder="Maximum number of students" required>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Assignment Information -->
                        <div class="col-md-6">
                            <h6 class="text-info mb-3">Assignment Information</h6>
                            
                            <div class="mb-3">
                                <label for="teacher_id" class="form-label">Primary Teacher *</label>
                                <select class="form-select @error('teacher_id') is-invalid @enderror" id="teacher_id" name="teacher_id" required>
                                    <option value="">Select Primary Teacher</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->full_name }} ({{ $teacher->specialization }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($teachers->count() == 0)
                                    <div class="form-text text-warning">
                                        <i class="bi bi-exclamation-triangle"></i> No teachers available. 
                                        <a href="{{ route('teachers.create') }}">Create a teacher first</a>.
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="additional_teachers" class="form-label">Additional Teachers</label>
                                <select class="form-select @error('additional_teachers') is-invalid @enderror" 
                                        id="additional_teachers" name="additional_teachers[]" multiple>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ in_array($teacher->id, old('additional_teachers', [])) ? 'selected' : '' }}>
                                            {{ $teacher->full_name }} ({{ $teacher->specialization }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Hold Ctrl (or Cmd on Mac) to select multiple teachers</div>
                                @error('additional_teachers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3" 
                                          placeholder="Optional description about the class">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('classes.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-info" {{ $teachers->count() == 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-check-circle"></i> Create Class
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 