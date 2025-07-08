<?php
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Vendor\StaffTypes\Admin\StaffParamUnitController;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {
    Route::group([
        "prefix" => config("staff-types.paramUnitUrlName"),
        "as" => "staff-param-units.",
    ],function (){
        // param-units
        Route::get("/", [StaffParamUnitController::class, "index"])->name("index");
        Route::get("/create", [StaffParamUnitController::class, "create"])->name("create");
        Route::post("", [StaffParamUnitController::class, "store"])->name("store");
        Route::get("/{unit}", [StaffParamUnitController::class, "show"])->name("show");
        Route::get("/{unit}/edit", [StaffParamUnitController::class, "edit"])->name("edit");
        Route::put("/{unit}", [StaffParamUnitController::class, "update"])->name("update");
        Route::delete("/{unit}", [StaffParamUnitController::class, "destroy"])->name("destroy");

        // приоритет
        Route::put("/tree/priority", [StaffParamUnitController::class,"changeItemsPriority"])
            ->name("item-priority");

    });
}
);
