<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffParamNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_param_names', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("staff_param_unit_id")->nullable();
            $table->string("title")->unique();
            $table->string("name");
            $table->string("slug")->unique();
            $table->string("value_type");
            $table->dateTime("expected_at")->nullable();
            $table->integer('priority')->default(0);
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
        Schema::dropIfExists('staff_param_names');
    }
}
