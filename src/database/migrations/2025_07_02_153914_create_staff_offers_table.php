<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("staff_employee_id");
            $table->unsignedInteger("contact_id");
            $table->string("title");
            $table->string("slug")
                ->unique();
            $table->unsignedInteger("price")
                ->nullable();
            $table->boolean("from_price")
                ->nullable();
            $table->unsignedInteger("old_price")
                ->nullable();
            $table->string("currency")
                ->nullable();
            $table->string("sales_notes")
                ->nullable();
            $table->longText("description")
                ->nullable();
            $table->tinyInteger("experience")
                ->comment("Лет опыта");
            $table->tinyInteger("city")
                ->comment("Город работы");
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
        Schema::dropIfExists('staff_offers');
    }
}
