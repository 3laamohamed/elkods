<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_money', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date',100);
            $table->string('time',100);
            $table->integer('customer_id');
            $table->double('money',10,2);
            $table->text('note')->nullable();
            $table->integer('user')();
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
        Schema::dropIfExists('customer_money');
    }
}
