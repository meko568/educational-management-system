<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{

    public function run(): void
    {
        Student::updateOrCreate(
            ['role' => 'admin'],
            [
                'name' => env('ADMIN_NAME', 'Admin'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin@123')),
                'academicYear' => 'none'
            ]
        );
    }
}
