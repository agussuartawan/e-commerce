<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnInSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('product_color_id')->constrained()->onUpdate('cascade');
            $table->foreignId('product_fragrance_id')->constrained()->onUpdate('cascade');
            $table->dateTime('due_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('color_id');
            $table->dropColumn('fragrance_id');
            $table->dropColumn('due_date');
        });
    }
}
