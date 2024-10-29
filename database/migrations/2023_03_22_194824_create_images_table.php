<?php

use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name',125);
            $table->string('url');
            $table->integer('product_id');
            $table->string('alt');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
