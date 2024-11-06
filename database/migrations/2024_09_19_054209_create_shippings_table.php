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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('courier_send')->nullable();
            $table->string('courier_send_phone')->nullable();
            $table->string('courier_take')->nullable();
            $table->string('courier_take_phone')->nullable();
            $table->string('recipient');
            $table->string('telephone');
            $table->text('address');
            $table->string('city');
            $table->string('postcode');
            $table->string('country');
            $table->date('delivery_date');
            $table->date('return_date');
            $table->string('product_location');
            $table->longText('note_send')->nullable();
            $table->longText('note_take')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
