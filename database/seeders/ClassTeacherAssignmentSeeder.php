<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\ClassRoom;
use Faker\Factory as Faker;

class ClassTeacherAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all teachers and classes
        $teachers = Teacher::where('status', 'active')->get();
        $classes = ClassRoom::where('status', 'active')->get();

        if ($teachers->count() == 0 || $classes->count() == 0) {
            $this->command->info('No teachers or classes found. Please run TeacherSeeder and ClassSeeder first.');
            return;
        }

        $this->command->info('Creating class-teacher assignments...');

        // Assign teachers to classes
        foreach ($classes as $class) {
            // Each class should have at least one primary teacher
            $primaryTeacher = $teachers->random();
            
            // Assign primary teacher
            $class->teachers()->attach($primaryTeacher->id, [
                'role' => 'primary',
                'assigned_date' => $faker->dateTimeBetween('-1 year', 'now'),
                'status' => 'active',
                'responsibilities' => 'Main class teacher responsible for overall class management'
            ]);

            // Randomly assign 1-2 additional teachers to some classes
            $additionalTeachers = $teachers->where('id', '!=', $primaryTeacher->id)->random($faker->numberBetween(0, 2));
            
            foreach ($additionalTeachers as $teacher) {
                $role = $faker->randomElement(['secondary', 'assistant']);
                $class->teachers()->attach($teacher->id, [
                    'role' => $role,
                    'assigned_date' => $faker->dateTimeBetween('-6 months', 'now'),
                    'status' => 'active',
                    'responsibilities' => $role === 'secondary' ? 'Supporting teacher for specific subjects' : 'Assistant teacher for lab work and activities'
                ]);
            }
        }

        // Also assign some teachers to multiple classes
        $teachersForMultipleClasses = $teachers->random(min(5, $teachers->count()));
        
        foreach ($teachersForMultipleClasses as $teacher) {
            $additionalClasses = $classes->where('id', '!=', $teacher->classes->first()->id ?? 0)->random($faker->numberBetween(1, 3));
            
            foreach ($additionalClasses as $class) {
                // Check if teacher is already assigned to this class
                $existingAssignment = $teacher->assignedClasses()->where('class_id', $class->id)->exists();
                
                if (!$existingAssignment) {
                    $role = $faker->randomElement(['primary', 'secondary', 'assistant']);
                    $class->teachers()->attach($teacher->id, [
                        'role' => $role,
                        'assigned_date' => $faker->dateTimeBetween('-3 months', 'now'),
                        'status' => 'active',
                        'responsibilities' => $role === 'primary' ? 'Primary teacher for this class' : 
                                           ($role === 'secondary' ? 'Secondary teacher for support' : 'Assistant teacher')
                    ]);
                }
            }
        }

        $totalAssignments = \DB::table('class_teacher')->count();
        $this->command->info("Created {$totalAssignments} class-teacher assignments successfully!");
    }
} 