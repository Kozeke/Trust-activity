<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJumpOutCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jump_out_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('user_id');  
            $table->integer('domain_id');        
            $table->integer('template_id');
            $table->string('show_all')->default('no')->nullable(); 
            $table->string('show_main')->default('no')->nullable();  
            $table->integer('priority')->default(1);     
            $table->integer('status')->default(1);     
            $table->timestamp('deleted_at');       
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
        Schema::dropIfExists('jump_out_companies');
    }
}
