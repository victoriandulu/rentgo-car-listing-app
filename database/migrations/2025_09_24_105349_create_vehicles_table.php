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
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->decimal('price', 12, 2);
        $table->string('specs')->nullable();
        $table->string('dealer')->nullable();
        $table->string('category')->nullable(); // "Kenya" or "Import"
        $table->string('image')->nullable();
        $table->year('year')->nullable();
        $table->decimal('report_price', 12, 2)->default(500);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
