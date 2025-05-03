<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('midwives', function (Blueprint $table) {
            $table->id('midwife_id');
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('password', 255);
            $table->string('phone_number', 20)->nullable();
            $table->string('profile_picture', 255)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('role', ['midwife', 'admin'])->default('midwife');
            $table->enum('available_day', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midwives');
    }
};
