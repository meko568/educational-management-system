<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('name');
            $table->id('code');
            $table->string('password');
            $table->string('plain_password')->nullable();
            $table->string('academicYear');
            $table->string('phone')->nullable();
            $table->string('parent_phone')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('role')->default('student');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE students AUTO_INCREMENT = 1000;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
