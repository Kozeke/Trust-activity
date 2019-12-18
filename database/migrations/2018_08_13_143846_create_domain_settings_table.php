<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domain_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('domain_id');
            $table->string('hide_notifications')->default('no');
            $table->string('show_on_top')->default('no');           
            $table->string('position')->default('off');
            $table->string('viewing_this_page')->default('off');
            $table->integer('spacing_between')->default(5);
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
        Schema::dropIfExists('domain_settings');
    }
}
