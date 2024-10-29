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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no');
            $table->integer('user_id');
            $table->integer('bank_id')->nullable();
            $table->date('rental_start_date');
            $table->date('rental_end_date');
            $table->integer('rental_duration');
            $table->string('total');
            $table->string('total_price');
            $table->string('discount_percent')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('balance')->nullable();
            $table->string('payment_duedate')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
