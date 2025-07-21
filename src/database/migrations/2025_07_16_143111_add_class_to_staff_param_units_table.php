<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClassToStaffParamUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_param_units', function (Blueprint $table) {
            $table->string("class")
                ->after('slug')
                ->default('staff-offer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_param_units', function (Blueprint $table) {
            $table->dropColumn("class");
        });
    }
}
