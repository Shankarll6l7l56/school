<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Teacher;
use Faker\Factory as Faker;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $subjects = [
            [
                'subject_name' => 'Mathematics',
                'subject_code' => 'MATH101',
                'description' => 'Advanced mathematics including algebra, calculus, and trigonometry',
                'credits' => 4
            ],
            [
                'subject_name' => 'Physics',
                'subject_code' => 'PHY101',
                'description' => 'Fundamental principles of physics including mechanics and thermodynamics',
                'credits' => 4
            ],
            [
                'subject_name' => 'Chemistry',
                'subject_code' => 'CHEM101',
                'description' => 'General chemistry covering atomic structure and chemical reactions',
                'credits' => 4
            ],
            [
                'subject_name' => 'Biology',
                'subject_code' => 'BIO101',
                'description' => 'Introduction to biological sciences and life processes',
                'credits' => 4
            ],
            [
                'subject_name' => 'English Literature',
                'subject_code' => 'ENG101',
                'description' => 'Study of classic and contemporary English literature',
                'credits' => 3
            ],
            [
                'subject_name' => 'History',
                'subject_code' => 'HIST101',
                'description' => 'World history from ancient civilizations to modern times',
                'credits' => 3
            ],
            [
                'subject_name' => 'Geography',
                'subject_code' => 'GEO101',
                'description' => 'Physical and human geography with environmental studies',
                'credits' => 3
            ],
            [
                'subject_name' => 'Computer Science',
                'subject_code' => 'CS101',
                'description' => 'Programming fundamentals and computer applications',
                'credits' => 4
            ],
            [
                'subject_name' => 'Economics',
                'subject_code' => 'ECO101',
                'description' => 'Basic economic principles and market systems',
                'credits' => 3
            ],
            [
                'subject_name' => 'Psychology',
                'subject_code' => 'PSY101',
                'description' => 'Introduction to human behavior and mental processes',
                'credits' => 3
            ],
            [
                'subject_name' => 'Political Science',
                'subject_code' => 'POL101',
                'description' => 'Study of political systems and governance',
                'credits' => 3
            ],
            [
                'subject_name' => 'Sociology',
                'subject_code' => 'SOC101',
                'description' => 'Study of human society and social behavior',
                'credits' => 3
            ],
            [
                'subject_name' => 'Art & Design',
                'subject_code' => 'ART101',
                'description' => 'Creative arts including drawing, painting, and digital design',
                'credits' => 2
            ],
            [
                'subject_name' => 'Music',
                'subject_code' => 'MUS101',
                'description' => 'Music theory and practical instrumental training',
                'credits' => 2
            ],
            [
                'subject_name' => 'Physical Education',
                'subject_code' => 'PE101',
                'description' => 'Physical fitness and sports activities',
                'credits' => 1
            ],
            [
                'subject_name' => 'Environmental Science',
                'subject_code' => 'ENV101',
                'description' => 'Study of environmental issues and sustainability',
                'credits' => 3
            ],
            [
                'subject_name' => 'Statistics',
                'subject_code' => 'STAT101',
                'description' => 'Statistical methods and data analysis',
                'credits' => 3
            ],
            [
                'subject_name' => 'Philosophy',
                'subject_code' => 'PHIL101',
                'description' => 'Critical thinking and philosophical inquiry',
                'credits' => 3
            ],
            [
                'subject_name' => 'Linguistics',
                'subject_code' => 'LING101',
                'description' => 'Study of language structure and communication',
                'credits' => 3
            ],
            [
                'subject_name' => 'Astronomy',
                'subject_code' => 'AST101',
                'description' => 'Introduction to celestial objects and space science',
                'credits' => 3
            ]
        ];

        // Get all teachers
        $teachers = Teacher::all();

        foreach ($subjects as $subjectData) {
            // Assign a random teacher to each subject
            $teacher = $teachers->random();
            
            Subject::create([
                'subject_name' => $subjectData['subject_name'],
                'subject_code' => $subjectData['subject_code'],
                'description' => $subjectData['description'],
                'teacher_id' => $teacher->id,
                'credits' => $subjectData['credits'],
                'status' => $faker->randomElement(['active', 'inactive']),
            ]);
        }
    }
} 