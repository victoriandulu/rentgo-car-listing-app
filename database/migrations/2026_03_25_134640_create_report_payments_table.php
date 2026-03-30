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
        Schema::create('report_payments', function (Blueprint $table) {
            $table->id();

            // Relationship to cars
            $table->foreignId('car_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Payment details
            $table->string('mpesa_code', 12)->unique();
            $table->string('phone', 20);
            $table->decimal('amount', 10, 2);

            // Status tracking
            $table->enum('status', ['pending', 'verified', 'rejected'])
                  ->default('pending');

            $table->timestamp('verified_at')->nullable();

            // Admin who verified
            $table->foreignId('verified_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_payments');
    }
};
