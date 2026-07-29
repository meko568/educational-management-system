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
        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_code');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->integer('watch_percentage')->default(0);
            $table->timestamp('last_watched_at')->useCurrent();
            $table->timestamps();

            $table->unique(['student_code', 'lesson_id']);
            $table->foreign('student_code')->references('code')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_progress');
    }
};
