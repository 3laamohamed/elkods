<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_borrows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id');
            $table->double('borrow',10,2);
            $table->double('value',10,2);
            $table->double('re_value',10,2);
            $table->string('date');
            $table->integer('user');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('customers_borrows');
    }
}
