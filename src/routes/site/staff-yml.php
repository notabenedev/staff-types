<?php

use Illuminate\Support\Facades\Route;

Route::group([
    "namespace" => "App\Http\Controllers\Vendor\StaffTypes\Site",
    "middleware" => ["web"],
    "as" => "staff.yml",
    "prefix" => config("staff-types.ymlUrlName"),
], function () {
    Route::get("/{type}", "StaffYmlController@show")->name("show");
});