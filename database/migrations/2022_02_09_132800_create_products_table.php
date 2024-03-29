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
            $table->foreignId('product_unit_id')->constrained()->onUpdate('cascade');
            
            $table->string('product_name');
            $table->integer('stock')->default(0);
            $table->decimal('selling_price', $precission = 18, $scale = 2);
            $table->decimal('production_price', $precission = 18, $scale = 2);
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
