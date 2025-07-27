<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ClassRoom;
use Faker\Factory as Faker;

class StudentClassAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all students and classes
        $students = Student::all();
        $classes = ClassRoom::all();

        // Assign students to classes
        foreach ($students as $student) {
            // Randomly assign 1-2 classes to each student
            $numClasses = $faker->randomElement([1, 2]);
            $selectedClasses = $classes->random($numClasses);

            foreach ($selectedClasses as $class) {
                // Check if student is already enrolled in this class
                $existingEnrollment = $student->classes()->where('class_id', $class->id)->exists();
                
                if (!$existingEnrollment) {
                    $student->classes()->attach($class->id, [
                        'enrollment_date' => $faker->dateTimeBetween('-2 years', 'now'),
                        'status' => $faker->randomElement(['enrolled', 'dropped', 'graduated']),
                    ]);
                }
            }
        }
    }
} 