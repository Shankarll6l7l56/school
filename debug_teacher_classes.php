<?php

require_once 'vendor/autoload.php';

use App\Models\Teacher;
use App\Models\ClassRoom;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Teacher-Class Relationship Debug ===\n\n";

// Check table data
echo "1. Checking class_teacher table data:\n";
$assignments = DB::table('class_teacher')->get();
echo "Total assignments: " . $assignments->count() . "\n";

if ($assignments->count() > 0) {
    echo "Sample assignments:\n";
    foreach ($assignments->take(5) as $assignment) {
        echo "- Teacher ID: {$assignment->teacher_id}, Class ID: {$assignment->class_id}, Role: {$assignment->role}\n";
    }
}

// Find a teacher with assignments
echo "\n2. Finding teacher with assignments:\n";
$teacherWithAssignments = DB::table('class_teacher')->first();
if ($teacherWithAssignments) {
    $teacher = Teacher::find($teacherWithAssignments->teacher_id);
    echo "Teacher ID: {$teacher->id}, Name: {$teacher->full_name}\n";
    
    // Test the relationship
    echo "3. Testing assignedClasses relationship:\n";
    $assignedClasses = $teacher->assignedClasses;
    echo "Assigned classes count: " . $assignedClasses->count() . "\n";
    
    if ($assignedClasses->count() > 0) {
        echo "Assigned classes:\n";
        foreach ($assignedClasses as $class) {
            echo "- {$class->class_name} - {$class->section} (Role: {$class->pivot->role})\n";
        }
    } else {
        echo "No classes assigned to this teacher.\n";
    }
}

// Check classes
echo "\n4. Checking classes:\n";
$classWithAssignments = DB::table('class_teacher')->first();
if ($classWithAssignments) {
    $class = ClassRoom::find($classWithAssignments->class_id);
    echo "Class ID: {$class->id}, Name: {$class->class_name} - {$class->section}\n";
    
    // Test the relationship from class side
    echo "5. Testing teachers relationship from class side:\n";
    $teachers = $class->teachers;
    echo "Teachers count: " . $teachers->count() . "\n";
    
    if ($teachers->count() > 0) {
        echo "Teachers assigned:\n";
        foreach ($teachers as $teacher) {
            echo "- {$teacher->full_name} (Role: {$teacher->pivot->role})\n";
        }
    } else {
        echo "No teachers assigned to this class.\n";
    }
}

echo "\n=== Debug Complete ===\n"; 