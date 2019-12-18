<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotStreaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_streaks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('domain_id');
            $table->string('name'); 
            $table->string('message'); 
            $table->integer('shows')->default(0);    
            $table->integer('conversions')->default(20);          
            $table->integer('days')->default(7);         
            $table->string('show_conversions')->default('yes');   
            $table->string('send_to_url')->nullable(); 
            $table->string('open_new')->default('no')->nullable(); 
            $table->integer('status')->default(1); 
            $table->string('image');   
            $table->string('translate_from')->nullable();        
            $table->string('translate_someone')->nullable();   
            $table->string('locale')->nullable();   
            $table->string('fake')->nullable();   
            $table->text('fake_city')->nullable();   
            $table->string('fake_locale')->nullable();  
            $table->string('show_all')->default('no')->nullable(); 
            $table->string('show_main')->default('no')->nullable();       
			$table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('hot_streaks');
    }
}
