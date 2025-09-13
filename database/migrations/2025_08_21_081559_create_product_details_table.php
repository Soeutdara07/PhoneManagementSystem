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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->restrictOnDelete();
            $table->foreignId('supplier_id')->references('id')->on('suppliers')->restrictOnDelete();
            $table->decimal('cost', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->string('product_identifier');
            $table->string('sold_status')->nullable();
            $table->string('condition')->nullable();
            $table->text('product_description')->nullable();
            $table->foreignId('color_id')->nullable()->references('id')->on('product_colors')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
