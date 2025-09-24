<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Basic Info
            $table->string('name');
            $table->year('year');
            $table->string('location')->nullable();
            $table->string('availability')->nullable(); // Available, Pending, Sold

            // Technical Specs
            $table->string('drive')->nullable();
            $table->integer('mileage')->nullable();
            $table->string('engine_size')->nullable();
            $table->string('fuel_type')->nullable();
            $table->integer('horse_power')->nullable();
            $table->string('transmission')->nullable();
            $table->string('torque')->nullable();
            $table->string('aspiration')->nullable();
            $table->string('acceleration')->nullable();

            // Price & Description
            $table->decimal('price', 12, 2);
            $table->text('description')->nullable();

            // Extra Data
            $table->json('specification')->nullable();   // checkboxes/features
            $table->json('running_cost')->nullable();    // insurance, fuel, etc.

            // Images
            $table->string('image')->nullable(); // main image
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
