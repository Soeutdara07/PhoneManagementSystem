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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete();

            $table->foreignId('product_detail_id')->references('id')->on('product_details')->restrictOnDelete();

            // Purchase fields
            $table->date('purchase_date');
            $table->integer('purchase_qty');
            $table->decimal('purchase_price', 10, 2);
            $table->text('purchase_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
