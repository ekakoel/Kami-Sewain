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
        Schema::create('business_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('logo', 100);
            $table->string('logo_alt', 100);
            $table->string('business_name', 100);
            $table->longText('story')->nullable();
            $table->string('caption',255);
            $table->text('description')->nullable();
            $table->longText('vision')->nullable();
            $table->longText('mission')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('map', 255)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('website', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_profiles');
    }
};
