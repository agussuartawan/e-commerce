<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onUpdate('cascade');
            $table->foreignId('product_id')->constrained()->onUpdate('cascade');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            $table->foreignId('province_id')->constrained()->onUpdate('cascade');
            $table->foreignId('city_id')->constrained()->onUpdate('cascade');
            $table->foreignId('bank_id')->constrained()->onUpdate('cascade');

            $table->string('sale_number');
            $table->integer('qty');
            $table->decimal('grand_total', $precission = 18, $scale = 2);
            $table->string('date');
            $table->text('note');
            $table->text('address');
            $table->string('payment_status');
            $table->string('delivery_status');
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
        Schema::dropIfExists('sales');
    }
}
