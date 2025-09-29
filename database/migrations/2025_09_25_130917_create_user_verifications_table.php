<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('driver_license')->nullable();
            $table->string('proof_of_address')->nullable();
            $table->json('additional_docs')->nullable(); // multiple
            $table->string('national_id')->nullable();
            $table->string('photo')->nullable();
            $table->string('verification_video')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_verifications');
    }
};
