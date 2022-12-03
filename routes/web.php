<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\CustomerController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
################################## Information Routes #########################
Route::group(['controller'=>InfoController::class],function(){
    Route::get('viewInfo','index')->name('viewInfo');
    Route::post('getInfo','getInfo');
    Route::post('saveInfo','saveInfo');
});

################################## locations Routes ###########################
Route::group(['controller'=>LocationsController::class],function(){
    Route::get('viewLocations','viewLocations')->name('viewLocations');
    Route::post('getLocations','getLocations');
    Route::post('saveLocation','saveLocation');
    Route::post('updateLocation','updateLocation');
    Route::post('deleteLocation','deleteLocation');
});

################################## Customers Routes ###########################
Route::group(['controller'=>CustomerController::class],function(){
    Route::get('viewCustomers','viewCustomers')->name('viewCustomers');
    Route::post('getCustomers','getCustomers');
    Route::post('savCustomers','savCustomers');
    Route::post('updatCustomers','updatCustomers');
    Route::post('deletCustomers','deletCustomers');
});
