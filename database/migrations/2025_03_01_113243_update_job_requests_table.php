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
        Schema::table('job_requests', function (Blueprint $table) {
            // Make 'location' nullable and ensure it is a string
            $table->string('location')->nullable()->change();

            // Add 'location_langitude' and 'location_longitude' as strings if they do not exist
            if (!Schema::hasColumn('job_requests', 'location_langitude')) {
                $table->string('location_langitude')->nullable();
            }
            if (!Schema::hasColumn('job_requests', 'location_longitude')) {
                $table->string('location_longitude')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->string('location')->nullable(false)->change();

        // Drop the columns if they were added
        $table->dropColumn(['location_langitude', 'location_longitude']);
    }
};
