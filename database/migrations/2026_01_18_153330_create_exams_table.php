<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('academicYear');
            $table->text('description')->nullable();
            $table->date('exam_date');
            $table->integer('total_marks');
            $table->enum('status', ['draft', 'scheduled', 'in_progress', 'completed', 'cancelled'])->default('draft');

            // Using student_code as foreign key
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('code')
                ->on('students')
                ->onDelete('cascade');

            $table->timestamps();

            // Index for better performance on date-based queries
            $table->index('exam_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
