<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMemberCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_cards', function (Blueprint $table) {
            $table->string('postfix')->nullable()->after('card_no');
            $table->string('prefix')->nullable()->after('card_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_cards', function (Blueprint $table) {
            $table->dropColumn('postfix');
            $table->dropColumn('prefix');
        });
    }
}
