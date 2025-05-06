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
            $table->bigIncrements('pregnancy_id');
            $table->unsignedBigInteger('user_id'); // foreign key
            $table->date('start_date');
            $table->date('due_date');
            $table->integer('gravida');
            $table->integer('para');
            $table->integer('abortus');
            $table->integer('pregnancy_week');
            $table->date('last_check_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('user_id')->on('users');
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
