<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTigopesaPushTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tigopesa_push_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference')->unique();
            $table->string('customer_msisdn');
            $table->string('biller_msisdn');
            $table->double('amount');
            $table->timestamp('callback_received_at')->nullable();
            $table->boolean('callback_status')->nullable();
            $table->string('callback_description')->nullable();
            $table->string('tigopesa_transaction_id')->nullable();
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
        Schema::dropIfExists('tigopesa_push_transactions');
    }
}
