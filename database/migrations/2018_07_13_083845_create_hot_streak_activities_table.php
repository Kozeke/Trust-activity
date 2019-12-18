<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotStreakActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_streak_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hot_streak_id');
            $table->string('email');   
            $table->string('ip');        
            $table->string('city');   
            $table->string('city_code');       
            $table->text('gravatar_data');         
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
        Schema::dropIfExists('hot_streak_activities');
    }
}
