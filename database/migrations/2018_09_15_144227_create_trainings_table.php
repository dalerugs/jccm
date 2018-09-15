<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member')->default(0);
            $table->integer('batch')->default(0);
            $table->integer('pre_encounter')->default(0);
            $table->integer('encounter')->default(0);
            $table->integer('post_encounter')->default(0);
            $table->integer('sol1')->default(0);
            $table->integer('sol2')->default(0);
            $table->integer('re_encounter')->default(0);
            $table->integer('sol3')->default(0);
            $table->string('baptism')->default("");
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
        Schema::dropIfExists('trainings');
    }
}
