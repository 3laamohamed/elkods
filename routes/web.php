<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomersPriceController;
use App\Http\Controllers\MilkSupplyController;
use App\Http\Controllers\customerMoneyController;
use App\Http\Controllers\customersBorrowController;
use App\Http\Controllers\followSuppliersController;
use App\Http\Controllers\PendingPeriodsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;

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
    return view('auth.login');
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

################################## Customers Price Routes ###########################
Route::group(['controller'=>CustomersPriceController::class],function(){
    Route::get('viewCustomersPrice','index')->name('viewCustomersPrice');
    Route::post('getLocationsPrice','getLocationsPrice');
    Route::post('getCustomersInLocation','getCustomersInLocation');
    Route::post('updateCustomerPrice','updateCustomerPrice');
});

######################################### Sales ###################################
Route::group(['controller'=>MilkSupplyController::class],function(){
    Route::get('viewMilkSupply','index')->name('viewMilkSupply');
    Route::post('getSupplyMilk','getSupplyMilk');
    Route::post('getCustomersInLocationSupply','getCustomersInLocationSupply');
    Route::post('changeShift','changeShift');
    Route::post('saveOrderSupply','saveOrderSupply');
});

################################## Customer Money ##############################
Route::group(['controller'=>customerMoneyController::class],function (){
    Route::get('viewCustomerMoney','index')->name('viewCustomerMoney');
    Route::post('getCustomersMoney','fetchData');
    Route::post('saveCustomersMoney','addMoney');
    Route::post('deletCustomersMoney','deleteMoney');
    Route::post('updateCustomersMoney','updateMoney');
});

################################## customersBorrowController ##############################
Route::group(['controller'=>customersBorrowController::class],function (){
    Route::get('viewCustomerBorrow','index')->name('viewCustomerBorrow');
    Route::post('getCustomersBorrow','fetchData');
    Route::post('saveCustomersBorrow','addMoney');
    Route::post('deleteCustomersBorrow','deleteMoney');
    Route::post('updateCustomersBorrow','updateMoney');
});

############################################ follow suppliers ############################
Route::group(['controller'=>followSuppliersController::class],function (){
    Route::get('viewFollowSuppliers','index')->name('viewFollowSuppliers');
    Route::post('getCustomersPeriod','fetchData');
    Route::post('getCustomersPeriodLocation','fetchDataLocation');
    Route::get('detailsSupplier/supplier/{user}','detailsSupplier');
    Route::post('closePeriod','closePeriod');
    Route::post('getCustomerDetails','getCustomerDetails')->name('getCustomerDetails');
});

########################################## Pending Periods ####################################
Route::group(['controller'=>PendingPeriodsController::class],function (){
    Route::get('viewCustomerPending','index')->name('viewCustomerPending');
    Route::post('getCustomerPending','fetchData');
    Route::post('getCustomerPendingLocation','fetchDataLocation');
    Route::get('detailsSupplierPending/supplier/{user}','detailsSupplier');
    Route::post('closePeriodPending','closePeriod');
});

########################################### Products ######################################
Route::group(['controller'=>ProductsController::class],function(){
    Route::get('viewProducts','index')->name('viewProducts');
    Route::post('getProducts','getProducts');
    Route::post('savProducts','savProducts');
    Route::post('deleteProduct','deleteProduct');
    Route::post('updateProduct','updateProduct');
});

########################################### Products ######################################
Route::group(['controller'=>SalesController::class],function(){
    Route::get('viewSales','index')->name('viewSales');
});


