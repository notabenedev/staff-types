<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorStaffOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `staff_offers` CHANGE `city` `city` varchar(255) ;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `staff_offers` CHANGE `city` `city` int unsigned;");
    }
}
