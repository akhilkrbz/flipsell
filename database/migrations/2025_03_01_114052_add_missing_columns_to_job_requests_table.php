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
            $table->dateTime('job_date')->nullable()->after('business_id');
            $table->tinyInteger('job_date_flexible')->default(0)->after('job_date');
            $table->string('address')->nullable()->after('job_date_flexible');
            $table->tinyInteger('full_screen_image')->default(0)->after('address');
            $table->string('connect_type', 50)->nullable()->after('full_screen_image');
            $table->string('image_1')->nullable()->after('connect_type');
            $table->string('image_2')->nullable()->after('image_1');
            $table->string('image_3')->nullable()->after('image_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_requests', function (Blueprint $table) {
            $table->dropColumn([
                'job_date',
                'job_date_flexible',
                'address',
                'full_screen_image',
                'connect_type',
                'image_1',
                'image_2',
                'image_3',
            ]);
        });
    }
};
