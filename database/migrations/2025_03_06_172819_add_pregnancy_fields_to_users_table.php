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
        Schema::create('user_pregnancies', function (Blueprint $table) {
            $table->id('pregnancy_id');
            $table->unsignedBigInteger('user_id');
            $table->date('start_date');
            $table->date('due_date')->nullable();
            $table->integer('gravida')->comment('Number of pregnancies');
            $table->integer('para')->comment('Number of births');
            $table->integer('abortus')->comment('Number of miscarriages');
            $table->integer('pregnancy_week')->nullable();
            $table->date('last_check_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_pregnancies');
    }
};
