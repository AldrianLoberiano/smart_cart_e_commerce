<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('sku')->unique();
            $table->integer('stock')->default(0);
            $table->integer('low_stock_threshold')->default(10);
            $table->boolean('track_stock')->default(true);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->json('images')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('weight_unit')->default('kg');
            $table->json('meta_data')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['slug', 'is_active']);
            $table->index('sku');
            $table->index(['is_featured', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
