<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'section',
        'capacity',
        'teacher_id',
        'room_number',
        'status',
        'description'
    ];

    /**
     * Get the primary teacher for this class.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get all teachers assigned to this class.
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_teacher', 'class_id', 'teacher_id')
                    ->withPivot('role', 'assigned_date', 'status', 'responsibilities')
                    ->withTimestamps();
    }

    /**
     * Get the primary teacher for this class.
     */
    public function primaryTeacher()
    {
        return $this->belongsToMany(Teacher::class, 'class_teacher', 'class_id', 'teacher_id')
                    ->wherePivot('role', 'primary')
                    ->withPivot('assigned_date', 'status', 'responsibilities')
                    ->withTimestamps();
    }

    /**
     * Get the students in this class.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_class', 'class_id', 'student_id')
                    ->withPivot('enrollment_date', 'status')
                    ->withTimestamps();
    }

    /**
     * Get the attendance records for this class.
     */
    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }

    /**
     * Get the exams for this class.
     */
    public function exams()
    {
        return $this->hasMany(Exam::class, 'class_id');
    }

    /**
     * Get the full class name with section.
     */
    public function getFullClassNameAttribute()
    {
        return $this->class_name . ' - ' . $this->section;
    }
} 