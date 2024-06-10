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
            $table->string('name');
            $table->text('description');
            $table->integer('price');
            $table->integer('quantity');
            $table->integer('sold')->default(0);
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active'); // Adding the 'status' column
            $table->enum('sale_type', ['featured', 'hot_sale', 'new_arrival', 'normal'])->default('normal'); // Adding the 'sale_type' column
            $table->json('variations')->nullable();
            $table->json('photos')->nullable();
            $table->decimal('percent_off', 5, 2)->nullable();
            $table->dateTime('sale_start')->nullable();
            $table->dateTime('sale_end')->nullable();
            $table->foreignId('shop_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('brand_id')->constrained();
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
