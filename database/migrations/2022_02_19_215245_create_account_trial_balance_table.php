<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTrialBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_trial_balance', function (Blueprint $table) {
            $table->foreignId('account_id')->constrained()->onUpdate('cascade');
            $table->foreignId('trial_balance_id')->constrained()->onUpdate('cascade');
            $table->decimal('debit', $precission = 18, $scale = 2)->default(0);
            $table->decimal('credit', $precission = 18, $scale = 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_trial_balance');
    }
}
