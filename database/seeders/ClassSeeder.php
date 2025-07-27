<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassRoom;
use App\Models\Teacher;
use Faker\Factory as Faker;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $classes = [
            [
                'class_name' => 'Class 1',
                'section' => 'A',
                'capacity' => 30,
                'room_number' => '101',
                'description' => 'Primary education foundation class'
            ],
            [
                'class_name' => 'Class 1',
                'section' => 'B',
                'capacity' => 30,
                'room_number' => '102',
                'description' => 'Primary education foundation class'
            ],
            [
                'class_name' => 'Class 2',
                'section' => 'A',
                'capacity' => 30,
                'room_number' => '103',
                'description' => 'Elementary education class'
            ],
            [
                'class_name' => 'Class 2',
                'section' => 'B',
                'capacity' => 30,
                'room_number' => '104',
                'description' => 'Elementary education class'
            ],
            [
                'class_name' => 'Class 3',
                'section' => 'A',
                'capacity' => 30,
                'room_number' => '105',
                'description' => 'Primary education class'
            ],
            [
                'class_name' => 'Class 3',
                'section' => 'B',
                'capacity' => 30,
                'room_number' => '106',
                'description' => 'Primary education class'
            ],
            [
                'class_name' => 'Class 4',
                'section' => 'A',
                'capacity' => 30,
                'room_number' => '107',
                'description' => 'Primary education class'
            ],
            [
                'class_name' => 'Class 4',
                'section' => 'B',
                'capacity' => 30,
                'room_number' => '108',
                'description' => 'Primary education class'
            ],
            [
                'class_name' => 'Class 5',
                'section' => 'A',
                'capacity' => 30,
                'room_number' => '109',
                'description' => 'Primary education class'
            ],
            [
                'class_name' => 'Class 5',
                'section' => 'B',
                'capacity' => 30,
                'room_number' => '110',
                'description' => 'Primary education class'
            ],
            [
                'class_name' => 'Class 6',
                'section' => 'A',
                'capacity' => 35,
                'room_number' => '201',
                'description' => 'Middle school class'
            ],
            [
                'class_name' => 'Class 6',
                'section' => 'B',
                'capacity' => 35,
                'room_number' => '202',
                'description' => 'Middle school class'
            ],
            [
                'class_name' => 'Class 7',
                'section' => 'A',
                'capacity' => 35,
                'room_number' => '203',
                'description' => 'Middle school class'
            ],
            [
                'class_name' => 'Class 7',
                'section' => 'B',
                'capacity' => 35,
                'room_number' => '204',
                'description' => 'Middle school class'
            ],
            [
                'class_name' => 'Class 8',
                'section' => 'A',
                'capacity' => 35,
                'room_number' => '205',
                'description' => 'Middle school class'
            ],
            [
                'class_name' => 'Class 8',
                'section' => 'B',
                'capacity' => 35,
                'room_number' => '206',
                'description' => 'Middle school class'
            ],
            [
                'class_name' => 'Class 9',
                'section' => 'A',
                'capacity' => 40,
                'room_number' => '301',
                'description' => 'Secondary education class'
            ],
            [
                'class_name' => 'Class 9',
                'section' => 'B',
                'capacity' => 40,
                'room_number' => '302',
                'description' => 'Secondary education class'
            ],
            [
                'class_name' => 'Class 10',
                'section' => 'A',
                'capacity' => 40,
                'room_number' => '303',
                'description' => 'Secondary education class'
            ],
            [
                'class_name' => 'Class 10',
                'section' => 'B',
                'capacity' => 40,
                'room_number' => '304',
                'description' => 'Secondary education class'
            ],
            [
                'class_name' => 'Class 11',
                'section' => 'Science',
                'capacity' => 35,
                'room_number' => '401',
                'description' => 'Higher secondary science stream'
            ],
            [
                'class_name' => 'Class 11',
                'section' => 'Commerce',
                'capacity' => 35,
                'room_number' => '402',
                'description' => 'Higher secondary commerce stream'
            ],
            [
                'class_name' => 'Class 11',
                'section' => 'Arts',
                'capacity' => 30,
                'room_number' => '403',
                'description' => 'Higher secondary arts stream'
            ],
            [
                'class_name' => 'Class 12',
                'section' => 'Science',
                'capacity' => 35,
                'room_number' => '404',
                'description' => 'Higher secondary science stream'
            ],
            [
                'class_name' => 'Class 12',
                'section' => 'Commerce',
                'capacity' => 35,
                'room_number' => '405',
                'description' => 'Higher secondary commerce stream'
            ],
            [
                'class_name' => 'Class 12',
                'section' => 'Arts',
                'capacity' => 30,
                'room_number' => '406',
                'description' => 'Higher secondary arts stream'
            ]
        ];

        // Get all teachers
        $teachers = Teacher::all();

        foreach ($classes as $classData) {
            // Assign a random teacher to each class
            $teacher = $teachers->random();
            
            ClassRoom::create([
                'class_name' => $classData['class_name'],
                'section' => $classData['section'],
                'capacity' => $classData['capacity'],
                'teacher_id' => $teacher->id,
                'room_number' => $classData['room_number'],
                'status' => $faker->randomElement(['active', 'inactive']),
                'description' => $classData['description'],
            ]);
        }
    }
} 