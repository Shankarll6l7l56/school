@extends('admin.layouts.app')

@section('title', 'Bulk Upload Results - School Management System')
@section('page-title', 'Bulk Upload Results')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-upload me-2"></i>
                    Bulk Upload Exam Results
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('results.bulk-store') }}" method="POST" id="bulkResultsForm">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="exam_id" class="form-label">Select Exam <span class="text-danger">*</span></label>
                            <select name="exam_id" id="exam_id" class="form-select @error('exam_id') is-invalid @enderror" required>
                                <option value="">Choose an exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->exam_name }} - {{ $exam->exam_date }} ({{ $exam->subject->subject_name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('exam_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Exam Details</label>
                            <div id="examDetails" class="text-muted">
                                <p class="mb-1">Select an exam to see details</p>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <h6 class="alert-heading">Instructions</h6>
                        <ul class="mb-0">
                            <li>Select an exam from the dropdown above</li>
                            <li>Enter marks for each student in the table below</li>
                            <li>Marks should be between 0 and the total marks for the exam</li>
                            <li>You can add remarks for individual students (optional)</li>
                            <li>Click "Save All Results" to submit all results at once</li>
                        </ul>
                    </div>

                    <div id="studentsTable" style="display: none;">
                        <h6 class="mb-3">Enter Results for Students</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Student</th>
                                        <th>Student ID</th>
                                        <th>Marks Obtained <span class="text-danger">*</span></th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody id="studentsTableBody">
                                    <!-- Students will be loaded here dynamically -->
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('results.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Results
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Save All Results
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const examSelect = document.getElementById('exam_id');
    const examDetails = document.getElementById('examDetails');
    const studentsTable = document.getElementById('studentsTable');
    const studentsTableBody = document.getElementById('studentsTableBody');

    examSelect.addEventListener('change', function() {
        const examId = this.value;
        if (examId) {
            // Show exam details
            const selectedOption = this.options[this.selectedIndex];
            const examText = selectedOption.text;
            examDetails.innerHTML = `
                <p class="mb-1"><strong>Exam:</strong> ${examText}</p>
                <p class="mb-1"><strong>Total Marks:</strong> <span id="totalMarks">Loading...</span></p>
                <p class="mb-0"><strong>Passing Marks:</strong> <span id="passingMarks">Loading...</span></p>
            `;

            // Load students for this exam
            loadStudentsForExam(examId);
        } else {
            examDetails.innerHTML = '<p class="mb-1">Select an exam to see details</p>';
            studentsTable.style.display = 'none';
        }
    });

    function loadStudentsForExam(examId) {
        // This would typically make an AJAX call to get students for the exam
        // For now, we'll show a placeholder
        studentsTableBody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center">
                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                    Loading students...
                </td>
            </tr>
        `;
        studentsTable.style.display = 'block';

        // Simulate loading students (replace with actual AJAX call)
        setTimeout(() => {
            // This is a placeholder - in real implementation, you'd fetch students from the server
            studentsTableBody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        <i class="bi bi-info-circle me-2"></i>
                        Students will be loaded here when you select an exam with enrolled students.
                    </td>
                </tr>
            `;
        }, 1000);
    }

    // Form validation
    document.getElementById('bulkResultsForm').addEventListener('submit', function(e) {
        const examId = examSelect.value;
        if (!examId) {
            e.preventDefault();
            alert('Please select an exam first.');
            return;
        }

        // Additional validation can be added here
        const marksInputs = document.querySelectorAll('input[name^="results"][name$="[marks_obtained]"]');
        let isValid = true;

        marksInputs.forEach(input => {
            const marks = parseFloat(input.value);
            const totalMarks = parseFloat(document.getElementById('totalMarks').textContent);
            
            if (isNaN(marks) || marks < 0 || marks > totalMarks) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please check the marks entered. They should be between 0 and the total marks.');
        }
    });
});
</script>
@endpush
@endsection