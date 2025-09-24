<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // 'origin' field: 'import' or 'kenya'
            $table->string('origin')->default('kenya');

            // 'source' field: dealer name, e.g., 'Nairobi Auto Mart'
            $table->string('source')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['origin', 'source']);
        });
    }
};
