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
        Schema::create('health_trackings', function (Blueprint $table) {
            $table->id('tracking_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pregnancy_id');
            $table->date('date_recorded');
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('blood_pressure', 20)->nullable();
            $table->integer('heart_rate')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Foreign keys
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('pregnancy_id')->references('id')->on('user_pregnancies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_trackings');
    }
};
