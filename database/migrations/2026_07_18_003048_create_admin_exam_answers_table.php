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
        Schema::create('admin_exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('admin_exam_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('admin_exam_questions')->onDelete('cascade');
            $table->foreignId('choice_id')->nullable()->constrained('admin_exam_choices')->onDelete('set null');
            $table->text('text_answer')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_exam_answers');
    }
};
