# User Role System Documentation

## Overview
This SMS (School Management System) implements a comprehensive user role system where every student and teacher has a corresponding user account with appropriate roles.

## User Roles
- **admin**: Full system access
- **teacher**: Teacher portal access
- **student**: Student portal access

## Database Structure

### Users Table
- `id`: Primary key
- `name`: Full name
- `email`: Unique email address
- `role`: Enum ('admin', 'teacher', 'student')
- `password`: Hashed password
- `email_verified_at`: Email verification timestamp
- `remember_token`: Remember me token
- `created_at`, `updated_at`: Timestamps

### Students Table
- `id`: Primary key
- `user_id`: Foreign key to users table
- `student_id`: Unique student identifier
- `first_name`, `last_name`: Student name
- `email`: Student email (must match user email)
- `phone`: Contact number
- `date_of_birth`: Birth date
- `gender`: Enum ('male', 'female', 'other')
- `address`: Student address
- `parent_name`, `parent_phone`, `parent_email`: Parent information
- `admission_date`: Date of admission
- `status`: Enum ('active', 'inactive', 'graduated', 'transferred')
- `photo`: Profile photo path
- `created_at`, `updated_at`: Timestamps

### Teachers Table
- `id`: Primary key
- `user_id`: Foreign key to users table
- `teacher_id`: Unique teacher identifier
- `first_name`, `last_name`: Teacher name
- `email`: Teacher email (must match user email)
- `phone`: Contact number
- `date_of_birth`: Birth date
- `gender`: Enum ('male', 'female', 'other')
- `address`: Teacher address
- `qualification`: Educational qualification
- `specialization`: Subject specialization
- `joining_date`: Date of joining
- `salary`: Monthly salary
- `status`: Enum ('active', 'inactive', 'retired')
- `photo`: Profile photo path
- `created_at`, `updated_at`: Timestamps

## How It Works

### Creating a Student
1. Admin creates a student through the admin panel
2. System automatically creates a user record with:
   - `name`: First name + Last name
   - `email`: Student email
   - `role`: 'student'
   - `password`: Default password ('password123')
3. System creates a student record with `user_id` linking to the user
4. Student can now login using their email and default password

### Creating a Teacher
1. Admin creates a teacher through the admin panel
2. System automatically creates a user record with:
   - `name`: First name + Last name
   - `email`: Teacher email
   - `role`: 'teacher'
   - `password`: Default password ('password123')
3. System creates a teacher record with `user_id` linking to the user
4. Teacher can now login using their email and default password

### Authentication Flow
1. User enters email and password
2. System authenticates against users table
3. Based on user role, system redirects to appropriate dashboard:
   - `admin` → Admin dashboard
   - `teacher` → Teacher dashboard
   - `student` → Student dashboard

### Role-Based Access Control
- **Admin**: Can access all admin functions (manage students, teachers, classes, etc.)
- **Teacher**: Can access teacher portal (view classes, mark attendance, etc.)
- **Student**: Can access student portal (view attendance, results, exams, etc.)

## Model Relationships

### User Model
```php
public function student()
{
    return $this->hasOne(Student::class);
}

public function teacher()
{
    return $this->hasOne(Teacher::class);
}
```

### Student Model
```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

### Teacher Model
```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

## Security Features
- Password hashing using Laravel's Hash facade
- Role-based middleware protection
- Email uniqueness validation across users, students, and teachers tables
- Automatic user record deletion when student/teacher is deleted

## Default Passwords
- Students: `password123`
- Teachers: `password123`
- Admins: `admin123` (from seeder)

## Important Notes
- When updating student/teacher information, the corresponding user record is also updated
- When deleting student/teacher, the corresponding user record is also deleted
- Email addresses must be unique across all tables (users, students, teachers)
- The system maintains referential integrity between users and their profiles 