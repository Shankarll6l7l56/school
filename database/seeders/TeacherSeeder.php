<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $firstNames = [
            'Dr. Rajesh', 'Prof. Meera', 'Dr. Amit', 'Ms. Priya', 'Mr. Sanjay', 'Dr. Kavita', 'Prof. Ramesh', 'Ms. Anjali',
            'Dr. Suresh', 'Mr. Deepak', 'Prof. Sunita', 'Dr. Manoj', 'Ms. Rekha', 'Mr. Vikram', 'Dr. Neha', 'Prof. Arun',
            'Ms. Pooja', 'Dr. Rajiv', 'Mr. Ashish', 'Prof. Swati', 'Dr. Nitin', 'Ms. Ritu', 'Mr. Pankaj', 'Dr. Shweta',
            'Prof. Ajay', 'Ms. Divya', 'Dr. Rohit', 'Mr. Gaurav', 'Prof. Sneha', 'Dr. Abhishek', 'Ms. Pallavi', 'Mr. Rahul',
            'Dr. Ankita', 'Prof. Vivek', 'Ms. Shruti', 'Dr. Tarun', 'Mr. Karan', 'Prof. Jyoti', 'Dr. Harsh', 'Ms. Nidhi',
            'Mr. Aditya', 'Dr. Kriti', 'Prof. Saurabh', 'Ms. Tanvi', 'Dr. Prateek', 'Mr. Yash', 'Prof. Ishita', 'Dr. Arjun',
            'Ms. Zara', 'Mr. Vivaan', 'Dr. Aisha', 'Prof. Dhruv'
        ];

        $lastNames = [
            'Sharma', 'Verma', 'Patel', 'Kumar', 'Singh', 'Gupta', 'Malhotra', 'Kapoor', 'Joshi', 'Yadav',
            'Khan', 'Ali', 'Hussain', 'Ahmed', 'Rahman', 'Choudhury', 'Das', 'Bose', 'Banerjee', 'Mukherjee',
            'Chatterjee', 'Dutta', 'Sen', 'Roy', 'Ghosh', 'Mandal', 'Saha', 'Pal', 'Biswas', 'Nath',
            'Dey', 'Sarkar', 'Mondal', 'Haldar', 'Kar', 'Mazumdar', 'Bhattacharya', 'Ganguly', 'Chakraborty', 'Basu',
            'Mitra', 'Dutta', 'Sengupta', 'Bhatt', 'Shah', 'Mehta', 'Gandhi', 'Reddy', 'Naidu', 'Rao'
        ];

        $qualifications = [
            'M.Sc. Mathematics', 'Ph.D. Physics', 'M.A. English Literature', 'B.Tech Computer Science',
            'M.Sc. Chemistry', 'Ph.D. Biology', 'M.A. History', 'B.Tech Electronics', 'M.Sc. Economics',
            'Ph.D. Psychology', 'M.A. Geography', 'B.Tech Mechanical', 'M.Sc. Statistics', 'Ph.D. Sociology',
            'M.A. Political Science', 'B.Tech Civil', 'M.Sc. Botany', 'Ph.D. Zoology', 'M.A. Philosophy',
            'B.Tech Information Technology', 'M.Sc. Environmental Science', 'Ph.D. Anthropology',
            'M.A. Linguistics', 'B.Tech Chemical', 'M.Sc. Microbiology', 'Ph.D. Biochemistry',
            'M.A. Fine Arts', 'B.Tech Biotechnology', 'M.Sc. Geology', 'Ph.D. Astronomy'
        ];

        $specializations = [
            'Advanced Mathematics', 'Quantum Physics', 'Modern Literature', 'Software Engineering',
            'Organic Chemistry', 'Molecular Biology', 'World History', 'Digital Electronics',
            'Macroeconomics', 'Clinical Psychology', 'Physical Geography', 'Robotics',
            'Data Analysis', 'Social Psychology', 'International Relations', 'Structural Engineering',
            'Plant Physiology', 'Animal Behavior', 'Ethics', 'Web Development',
            'Climate Change', 'Cultural Studies', 'Computational Linguistics', 'Process Engineering',
            'Medical Microbiology', 'Enzymology', 'Digital Art', 'Genetic Engineering',
            'Mineralogy', 'Astrophysics'
        ];

        for ($i = 1; $i <= 20; $i++) {
            $firstName = $faker->randomElement($firstNames);
            $lastName = $faker->randomElement($lastNames);
            $email = strtolower(str_replace(['Dr. ', 'Prof. ', 'Mr. ', 'Ms. '], '', $firstName) . '.' . $lastName . '@teacher.school.com');
            $teacherId = 'TCH' . str_pad($i, 6, '0', STR_PAD_LEFT);
            
            // Create user account
            $user = User::create([
                'name' => $firstName . ' ' . $lastName,
                'email' => $email,
                'login_id' => $teacherId,
                'role' => 'teacher',
                'password' => Hash::make('password123'),
            ]);

            // Create teacher record
            Teacher::create([
                'user_id' => $user->id,
                'teacher_id' => $teacherId,
                'first_name' => str_replace(['Dr. ', 'Prof. ', 'Mr. ', 'Ms. '], '', $firstName),
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $faker->numerify('##########'),
                'date_of_birth' => $faker->dateTimeBetween('-60 years', '-25 years'),
                'gender' => $faker->randomElement(['male', 'female']),
                'address' => $faker->address(),
                'qualification' => $faker->randomElement($qualifications),
                'specialization' => $faker->randomElement($specializations),
                'joining_date' => $faker->dateTimeBetween('-10 years', 'now'),
                'salary' => $faker->numberBetween(30000, 80000),
                'status' => $faker->randomElement(['active', 'inactive']),
                'photo' => null,
            ]);
        }
    }
} 