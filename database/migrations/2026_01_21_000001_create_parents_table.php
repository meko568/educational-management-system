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
        Schema::create('parents', function (Blueprint $table) {
            $table->id('code');
            $table->string('phone_number')->unique();
            $table->string('password');
            $table->string('plain_password')->nullable();
            $table->json('sons')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE parents AUTO_INCREMENT = 1000;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
