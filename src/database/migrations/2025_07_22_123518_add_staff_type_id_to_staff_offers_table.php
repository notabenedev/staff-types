<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffTypeIdToStaffOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_offers', function (Blueprint $table) {
            $table->unsignedInteger("staff_type_id")
                ->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_offers', function (Blueprint $table) {
            $table->dropColumn("staff_type_id");
        });
    }
}
