<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'name' => 'Admin',
            'password' => Hash::make('Admin@123'), // strong password
            'role' => 'admin', // make sure you added the role column
            'academicYear' => 'none'
        ]);
    }
}
