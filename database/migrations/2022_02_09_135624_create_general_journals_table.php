<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onUpdate('cascade');
            $table->date('date');
            $table->decimal('debit', $precission = 18, $scale = 2)->defaul(0);
            $table->decimal('credit', $precission = 18, $scale = 2)->defaul(0);
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
        Schema::dropIfExists('general_journals');
    }
}
