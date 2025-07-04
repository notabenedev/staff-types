<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffParamUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_param_units', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("slug")
                ->unique();
            $table->integer('priority')
                ->default(0);
            $table->dateTime("demonstrated_at")
                ->nullable();
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
        Schema::dropIfExists('staff_param_units');
    }
}
