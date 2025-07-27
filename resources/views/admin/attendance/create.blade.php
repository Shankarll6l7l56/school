@extends('admin.layouts.app')

@section('title', 'Record Attendance - School Management System')
@section('page-title', 'Record Attendance')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-calendar-check me-2"></i>
                    Record Student Attendance
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('attendance.store') }}" method="POST" id="attendance-form">
                    @csrf
                    
                    <div class="row">
                        <!-- Class and Date Selection -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Class Information</h6>
                            
                            <div class="mb-3">
                                <label for="class_id" class="form-label">Select Class *</label>
                                <select class="form-select @error('class_id') is-invalid @enderror" 
                                       id="class_id" name="class_id" required>
                                    <option value="">Choose a class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->class_name }} - {{ $class->section }}
                                            ({{ $class->students->count() }} students)
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Date *</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                       id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Class Information Preview -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Class Details</h6>
                            
                            <div id="class-info" class="mt-3" style="display: none;">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Class Information</h6>
                                        <div id="class-details"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Records -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">Student Attendance</h6>
                            
                            <div id="students-container" style="display: none;">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Student</th>
                                                <th>Roll Number</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="students-list">
                                            <!-- Students will be loaded here dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="no-students" class="text-center py-5" style="display: none;">
                                <i class="bi bi-people text-muted fa-4x mb-3"></i>
                                <h5 class="text-muted">No students found</h5>
                                <p class="text-muted">Please select a class to view students</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
                                    <i class="bi bi-check-circle"></i> Record Attendance
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
    const classSelect = document.getElementById('class_id');
    const dateInput = document.getElementById('date');
    const studentsContainer = document.getElementById('students-container');
    const studentsList = document.getElementById('students-list');
    const noStudents = document.getElementById('no-students');
    const classInfo = document.getElementById('class-info');
    const classDetails = document.getElementById('class-details');
    const submitBtn = document.getElementById('submit-btn');
    
    // Class data for preview
    const classes = @json($classes);
    
    classSelect.addEventListener('change', function() {
        const selectedClassId = this.value;
        
        if (selectedClassId) {
            const selectedClass = classes.find(c => c.id == selectedClassId);
            if (selectedClass) {
                // Show class information
                classDetails.innerHTML = `
                    <p class="mb-1"><strong>Class:</strong> ${selectedClass.class_name} - ${selectedClass.section}</p>
                    <p class="mb-1"><strong>Students:</strong> ${selectedClass.students.length}</p>
                    <p class="mb-0"><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                `;
                classInfo.style.display = 'block';
                
                // Load students
                loadStudents(selectedClass.students);
                submitBtn.disabled = false;
            }
        } else {
            classInfo.style.display = 'none';
            studentsContainer.style.display = 'none';
            noStudents.style.display = 'none';
            submitBtn.disabled = true;
        }
    });
    
    function loadStudents(students) {
        if (students.length === 0) {
            studentsContainer.style.display = 'none';
            noStudents.style.display = 'block';
            return;
        }
        
        studentsContainer.style.display = 'block';
        noStudents.style.display = 'none';
        
        studentsList.innerHTML = '';
        
        students.forEach((student, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                            <span class="text-white fw-bold">${student.first_name.charAt(0)}</span>
                        </div>
                        ${student.first_name} ${student.last_name}
                    </div>
                </td>
                <td>${student.roll_number || 'N/A'}</td>
                <td>
                    <select class="form-select form-select-sm" name="attendance_data[${index}][status]" required>
                        <option value="">Select Status</option>
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                        <option value="excused">Excused</option>
                    </select>
                    <input type="hidden" name="attendance_data[${index}][student_id]" value="${student.id}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" 
                           name="attendance_data[${index}][remarks]" 
                           placeholder="Optional remarks">
                </td>
            `;
            studentsList.appendChild(row);
        });
    }
    
    // Form validation
    document.getElementById('attendance-form').addEventListener('submit', function(e) {
        const statusSelects = document.querySelectorAll('select[name*="[status]"]');
        let allSelected = true;
        
        statusSelects.forEach(select => {
            if (!select.value) {
                allSelected = false;
            }
        });
        
        if (!allSelected) {
            e.preventDefault();
            alert('Please select attendance status for all students.');
        }
    });
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