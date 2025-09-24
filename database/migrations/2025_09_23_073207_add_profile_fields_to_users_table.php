<?php

// database/migrations/xxxx_xx_xx_add_profile_fields_to_users.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();

            // Document paths
            $table->string('driver_license')->nullable();
            $table->string('proof_of_address')->nullable();
            $table->string('additional_doc')->nullable();
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone','address','city','state','zip_code',
                'driver_license','proof_of_address','additional_doc'
            ]);
        });
    }
};
