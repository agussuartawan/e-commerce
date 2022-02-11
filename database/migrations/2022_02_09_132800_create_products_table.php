<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onUpdate('cascade');
            $table->foreignId('product_color_id')->constrained()->onUpdate('cascade');
            $table->foreignId('product_fragrance_id')->constrained()->onUpdate('cascade');
            $table->foreignId('product_unit_id')->constrained()->onUpdate('cascade');
            
            $table->string('name');
            $table->string('stock');
            $table->decimal('selling_price', $precission = 18, $scale = 2);
            $table->integer('size')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
