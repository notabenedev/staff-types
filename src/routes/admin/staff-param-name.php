<?php
use App\Http\Controllers\Vendor\StaffTypes\Admin\StaffParamNameController;
use Illuminate\Support\Facades\Route;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {

    Route::group([
        "middleware" => ["web", "management"],
        "as" => "staff-param-names.",
        "prefix" => "staff-param-names",
    ], function () {
        Route::get("/{name}", [StaffParamNameController::class, "show"])->name("show");
        Route::get("/{name}/edit", [StaffParamNameController::class, "edit"])->name("edit");
        Route::put("/{name}", [StaffParamNameController::class, "update"])->name("update");
        Route::delete("/{name}", [StaffParamNameController::class, "destroy"])->name("destroy");
    });

    Route::group([
        "as" => "staff-param-units.staff-param-names.",
        "prefix" => "staff-param-units/{unit}/staff-param-names",
    ], function () {
        // Параметры группы
        Route::get("/", [StaffParamNameController::class, "index"])->name("index");
        Route::get("/create", [StaffParamNameController::class, "create"])->name("create");
        Route::post("", [StaffParamNameController::class, "store"])->name("store");

        // приоритет
        Route::get("/tree/priority", [StaffParamNameController::class,"priority"])
            ->name("priority");
        Route::put("/tree/item-priority", [StaffParamNameController::class,"changeItemsPriority"])
            ->name("item-priority");
    });


});