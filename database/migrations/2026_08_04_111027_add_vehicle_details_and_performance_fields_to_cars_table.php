<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds the extra vehicle-detail and performance fields
     * shown on the "Vehicle Details" / "Vehicle Performance" reference cards
     * that don't exist on the cars table yet.
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // Vehicle Details additions
            $table->string('variant')->nullable()->after('car_type');
            $table->unsignedTinyInteger('seats')->nullable()->after('variant');
            $table->unsignedTinyInteger('doors')->nullable()->after('seats');

            // Vehicle Performance additions
            $table->string('fuel_consumption')->nullable()->after('fuel_type');
            $table->string('fuel_tank_capacity')->nullable()->after('fuel_consumption');
            $table->string('cylinder_layout')->nullable()->after('fuel_tank_capacity');
            $table->string('kilowatts')->nullable()->after('horse_power');
            $table->string('gears')->nullable()->after('transmission');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn([
                'variant',
                'seats',
                'doors',
                'fuel_consumption',
                'fuel_tank_capacity',
                'cylinder_layout',
                'kilowatts',
                'gears',
            ]);
        });
    }
};
