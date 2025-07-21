<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => "admin/vue",
    'middleware' => ['web', 'management'],
    'namespace' => 'App\Http\Controllers\Vendor\StaffTypes\Ajax'
], function () {
    // Роуты параметров.
    Route::group([
        'prefix' => "staff-params",
        'as' => "admin.vue.staff-params.",
    ], function () {
        // Получить доступные.
        Route::get('/available/{model}/{id}', 'StaffParamController@available')
            ->name('available');
        // Получить параметры.
        Route::get('/{model}/{id}', 'StaffParamController@get')
            ->name('get');
        // Загрузка.
        Route::post('/{model}/{id}', 'StaffParamController@post')
            ->name('post');
        // Удаление .
        Route::delete('/{model}/{id}/{param}/delete', 'StaffParamController@delete')
            ->name('delete');
        // Сменить значение
        Route::post('/{model}/{id}/{param}/value', 'StaffParamController@value')
            ->name('value');
    });

});