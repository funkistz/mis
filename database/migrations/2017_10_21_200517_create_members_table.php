<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('gender')->nullable();
            $table->integer('race_id')->unsigned();
            $table->timestamp('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('nric');
            $table->integer('nationality_id')->unsigned();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->integer('education_level_id')->unsigned()->nullable();
            $table->string('skill')->nullable();
            $table->string('illness')->nullable();
            $table->string('mar_stat')->nullable();
            $table->string('unif_stat')->nullable();
            $table->integer('member_status_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
