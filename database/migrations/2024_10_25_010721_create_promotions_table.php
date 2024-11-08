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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('promotion_code')->nullable();
            $table->string('discount_percent')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('minimum_transaction');
            $table->string('amount');
            $table->string('expired_date');
            $table->longText('description');
            $table->enum('status', ['Active', 'Draft','Expired'])->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
