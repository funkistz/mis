<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseClassMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_class_member', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_class_id')->nullable();
            $table->integer('member_id')->nullable();
            $table->timestamp('accepted')->nullable();
            $table->tinyInteger('fixed')->nullable()->default(0);
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
        Schema::dropIfExists('course_class_member');
    }
}
