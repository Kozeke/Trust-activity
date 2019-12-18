<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotStreakShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_streak_shows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip');
            $table->integer('module_id');    
            $table->integer('domain_id');    
            $table->string('url');        
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
        Schema::dropIfExists('hot_streak_shows');
    }
}
