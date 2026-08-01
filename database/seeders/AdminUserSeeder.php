<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

    public function run(): void
    {
        Student::updateOrCreate(
            ['role' => 'admin'],
            [
                'name' => 'Admin'
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin@123')),
                'academicYear' => 'none'
            ]
        );
    }
}
