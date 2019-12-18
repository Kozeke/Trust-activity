<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('domain_id');   
            $table->integer('module_plan_id')->default(0);
            $table->integer('status')->default(1);         
            $table->dateTime('purchases_at');
            $table->dateTime('purchases_till');   
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
        Schema::dropIfExists('module_purchases');
    }
}
