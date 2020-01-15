<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::prefix('properties')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('new', 'PropertyController@store')
            ->middleware('can:create,App\Entities\Property')
            ->name('properties.new')
        ;

        Route::post('create', 'PropertyController@create')
            ->middleware('can:create,App\Entities\Property')
            ->name('properties.create')
        ;

        Route::get('edit/{property}', 'PropertyController@edit')
            ->middleware('can:update,property')
            ->name('properties.edit')
        ;

        Route::put('update/{property}', 'PropertyController@update')
            ->middleware('can:update,property')
            ->name('properties.update')
        ;

        Route::delete('{property}', 'PropertyController@delete')
            ->middleware('can:delete,property')
            ->name('properties.delete')
        ;

        Route::get('', 'PropertyController@readAll')
            ->name('properties.list')
        ;
    });

    Route::post('search', 'PropertySearchController@searchNear')
        ->name('properties.search_near')
    ;

    Route::get('{property}', 'PropertyController@read')
        ->name('properties.read')
    ;
});

Route::get('/', 'PropertySearchController@search')
    ->name('properties.search')
;
