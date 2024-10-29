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
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Pastikan engine InnoDB digunakan
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->foreignId('category_id')->nullable()->constrained('categories', 'id')->onDelete('set null');
            $table->foreignId('model_id')->nullable()->constrained('product_models', 'id')->onDelete('set null');
            $table->foreignId('color_id')->nullable()->constrained('product_colors', 'id')->onDelete('set null');
            $table->foreignId('material_id')->nullable()->constrained('product_materials', 'id')->onDelete('set null');
            $table->string('price');
            $table->string('cover');
            $table->string('alt');
            $table->string('sku');
            $table->string('stock');
            $table->string('production_date');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
