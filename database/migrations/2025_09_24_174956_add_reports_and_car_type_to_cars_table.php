<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->integer('reports')->default(0); // Number of reports sold/bought
            $table->string('car_type')->nullable(); // e.g., Sedan, SUV, Hatchback
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['reports', 'car_type']);
        });
    }
};
