<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $firstNames = [
            'Aarav', 'Aisha', 'Arjun', 'Avni', 'Dhruv', 'Diya', 'Ishaan', 'Kavya', 'Krishna', 'Mira',
            'Neha', 'Nikhil', 'Priya', 'Rahul', 'Riya', 'Rohan', 'Sanya', 'Shivam', 'Tanvi', 'Vedant',
            'Zara', 'Aditya', 'Ananya', 'Arnav', 'Bhavya', 'Chirag', 'Disha', 'Esha', 'Gaurav', 'Harsh',
            'Ira', 'Jai', 'Kashvi', 'Lakshay', 'Maya', 'Naman', 'Ojas', 'Pari', 'Qadir', 'Ritika',
            'Sahil', 'Tara', 'Uday', 'Vanya', 'Yash', 'Zain', 'Aadi', 'Bhavika', 'Chetan', 'Devika'
        ];

        $lastNames = [
            'Sharma', 'Verma', 'Patel', 'Kumar', 'Singh', 'Gupta', 'Malhotra', 'Kapoor', 'Joshi', 'Yadav',
            'Khan', 'Ali', 'Hussain', 'Ahmed', 'Rahman', 'Choudhury', 'Das', 'Bose', 'Banerjee', 'Mukherjee',
            'Chatterjee', 'Dutta', 'Sen', 'Roy', 'Ghosh', 'Mandal', 'Saha', 'Pal', 'Biswas', 'Nath',
            'Dey', 'Sarkar', 'Mondal', 'Haldar', 'Kar', 'Mazumdar', 'Bhattacharya', 'Ganguly', 'Chakraborty', 'Basu',
            'Mitra', 'Dutta', 'Sengupta', 'Bhatt', 'Shah', 'Mehta', 'Gandhi', 'Reddy', 'Naidu', 'Rao'
        ];

        for ($i = 1; $i <= 50; $i++) {
            $firstName = $faker->randomElement($firstNames);
            $lastName = $faker->randomElement($lastNames);
            $email = strtolower($firstName . '.' . $lastName . '@student.school.com');
            $studentId = 'STU' . str_pad($i, 6, '0', STR_PAD_LEFT);
            
            // Create user account
            $user = User::create([
                'name' => $firstName . ' ' . $lastName,
                'email' => $email,
                'login_id' => $studentId,
                'role' => 'student',
                'password' => Hash::make('password123'),
            ]);

            // Create student record
            Student::create([
                'user_id' => $user->id,
                'student_id' => $studentId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $faker->numerify('##########'),
                'date_of_birth' => $faker->dateTimeBetween('-18 years', '-6 years'),
                'gender' => $faker->randomElement(['male', 'female']),
                'address' => $faker->address(),
                'parent_name' => $faker->name(),
                'parent_phone' => $faker->numerify('##########'),
                'parent_email' => $faker->email(),
                'admission_date' => $faker->dateTimeBetween('-3 years', 'now'),
                'status' => $faker->randomElement(['active', 'inactive']),
                'photo' => null,
            ]);
        }
    }
} 