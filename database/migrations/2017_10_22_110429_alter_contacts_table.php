<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function(Blueprint $table)
        {
            $table->renameColumn('first_name', 'name');
            $table->renameColumn('phone', 'phone_1');
            $table->string('phone_2')->nullable()->after('phone');
            $table->dropColumn('middle_name');
            $table->dropColumn('last_name');
            $table->dropColumn('company');
            $table->renameColumn('position', 'relation');
            $table->dropColumn('mobile');
            $table->dropColumn('fax');
            $table->dropColumn('website');
            $table->dropColumn('address_id');
            $table->dropColumn('contactable_id');
            $table->dropColumn('contactable_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('contacts', function(Blueprint $table)
        // {
        //
        // });
    }
}
