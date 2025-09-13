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
                 $table->id();
                $table->string('product_name');

                // Category: required, restrict deletion
                $table->foreignId('category_id')
                    ->constrained('categories')
                    ->restrictOnDelete();

                // Brand:, restrict deletion
                $table->foreignId('brand_id')
                    ->constrained('brands')
                    ->restrictOnDelete();

                $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
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
