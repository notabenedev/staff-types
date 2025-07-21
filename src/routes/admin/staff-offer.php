<?php
use App\Http\Controllers\Vendor\StaffTypes\Admin\StaffOfferController;
use Illuminate\Support\Facades\Route;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {

    Route::group([
        "middleware" => ["web", "management"],
        "as" => "staff-offers.",
        "prefix" => "staff-offers",
    ], function () {
        Route::get("/{offer}", [StaffOfferController::class, "show"])->name("show");
        Route::get("/{offer}/edit", [StaffOfferController::class, "edit"])->name("edit");
        Route::put("/{offer}", [StaffOfferController::class, "update"])->name("update");
        Route::delete("/{offer}", [StaffOfferController::class, "destroy"])->name("destroy");

        Route::get('/{offer}/params', [StaffOfferController::class, 'params'])->name('params');
    });

    Route::group([
        "as" => "employees.show.staff-offers.",
        "prefix" => config("site-staff.employeeUrlName")."/{employee}/staff-offers",
    ], function () {
        // Предложения сотрудника
        Route::get("/", [StaffOfferController::class, "index"])->name("index");
        Route::get("/create", [StaffOfferController::class, "create"])->name("create");
        Route::post("", [StaffOfferController::class, "store"])->name("store");

        // приоритет
        Route::get("/tree/priority", [StaffOfferController::class,"priority"])
            ->name("priority");
        Route::put("/tree/item-priority", [StaffOfferController::class,"changeItemsPriority"])
            ->name("item-priority");

    });


});