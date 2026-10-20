<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add a "description" column to hero_slides (shown under each slide image).
     */
    public function up(): void
    {
        if (Schema::hasTable('hero_slides') && ! Schema::hasColumn('hero_slides', 'description')) {
            Schema::table('hero_slides', function (Blueprint $table) {
                $table->text('description')->nullable()->after('title');
            });
        }
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        if (Schema::hasTable('hero_slides') && Schema::hasColumn('hero_slides', 'description')) {
            Schema::table('hero_slides', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
};
