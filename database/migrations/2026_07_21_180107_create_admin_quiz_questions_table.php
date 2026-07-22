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
        Schema::create('admin_quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('admin_quizzes')->onDelete('cascade');
            $table->text('question_text');
            $table->string('question_image')->nullable();
            $table->integer('order');
            $table->integer('points')->default(1);
            $table->enum('type', ['multiple_choice', 'true_false', 'fill_blank'])->default('multiple_choice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_quiz_questions');
    }
};
