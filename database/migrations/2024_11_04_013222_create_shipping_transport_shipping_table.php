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
        Schema::create('shipping_transport_shipping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_id')->constrained('shippings')->onDelete('cascade');
            $table->foreignId('shipping_transport_id')->constrained('shipping_transports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_transport_shipping');
    }
};
