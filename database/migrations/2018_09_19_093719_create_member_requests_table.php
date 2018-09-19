<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_requests', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('member')->default(0);
          $table->string('first_name',50);
          $table->string('last_name',50);
          $table->string('sex',10);
          $table->date('birth_date');
          $table->text('address',10);
          $table->integer('level')->default(0);
          $table->integer('network_id')->default(0);
          $table->integer('leader_id')->default(0);
          $table->string('dp_filename',100)->default("default.png");
          $table->string('leader_code',50)->default("");
          $table->integer('isNetwork')->default(0);
          $table->string('action',20);
          $table->integer('approved')->default(0);
          $table->integer('inactive')->default(0);
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
        Schema::dropIfExists('member_requests');
    }
}
