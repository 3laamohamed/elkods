<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_periods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer');
            $table->string('date',50);
            $table->string('day',25);
            $table->string('shift',20);
            $table->integer('type');
            $table->string('type_name',25);
            $table->double('price',10,2);
            $table->double('quantity',10,2);
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
        Schema::dropIfExists('supply_periods');
    }
}
