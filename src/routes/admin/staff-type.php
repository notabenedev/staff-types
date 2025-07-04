<?php
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Vendor\StaffTypes\Admin\StaffTypeController;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {
    Route::group([
        "prefix" => config("staff-types.typeUrlName"),
        "as" => "staff-types.",
    ],function (){
        //types tree
        Route::get("/", [StaffTypeController::class, "index"])->name("index");
        Route::get("/create", [StaffTypeController::class, "create"])->name("create");
        Route::post("", [StaffTypeController::class, "store"])->name("store");
        Route::get("/{type}", [StaffTypeController::class, "show"])->name("show");
        Route::get("/{type}/edit", [StaffTypeController::class, "edit"])->name("edit");
        Route::put("/{type}", [StaffTypeController::class, "update"])->name("update");
        Route::delete("/{type}", [StaffTypeController::class, "destroy"])->name("destroy");
    });

    Route::group([
        "prefix" => config("staff-types.typeUrlName")."/{type}",
        "as" => "staff-types.",
    ], function () {
        // в файл выгрузки
        Route::put("export", [StaffTypeController::class,"export"])
            ->name("export");

    });
}
);
