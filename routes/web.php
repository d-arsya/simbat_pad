<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClinicFlowController;
use App\Http\Controllers\ClinicStockController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\InventoryFlowController;
use App\Http\Controllers\InventoryStockController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ManufactureController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\VendorController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;


// 'index','create','store','show','edit','update','destroy'
Route::redirect('/','/dashboard');
Route::view('/dashboard', 'pages.dashboard')->name("dashboard");

Route::controller(UserController::class)->group(function () {
    Route::match(['get','post'],'/login','login')->name('user.login');
    Route::match(['get','post'],'/forgot','forgot')->name('user.forgot');
    Route::match(['get','post'],'/settings','settings')->name('user.settings');
    Route::post("/logout",'logout')->name("user.logout");
});
Route::resource('user', UserController::class)->except(['show']);

Route::prefix("inventory")->as('inventory.')->group(function(){
    Route::post("inflows/print",[InventoryFlowController::class,"print"])->name("inflows.print");
    Route::resource('inflows',InventoryFlowController::class)->except([
        'edit','update','destroy'
    ]);
    Route::match(['get','post'],"stocks/retur/{batch}",[InventoryStockController::class,"retur"])->name('retur');
    Route::resource('stocks',InventoryStockController::class)->only([
        'index','show','destroy'
    ]);
});

Route::prefix("clinic")->as('clinic.')->group(function(){
    Route::resource('inflows',ClinicFlowController::class)->except([
        'edit','update','destroy'
    ]);
    Route::resource('stocks',ClinicStockController::class)->only([
        'index','show'
    ]);
});

Route::prefix('master')->as('master.')->group(function () {
    Route::resource('category',CategoryController::class)->except(['create','show']);
    Route::resource('vendor',VendorController::class)->except(['create','show']);
    Route::resource('variant',VariantController::class)->except(['create','show']);
    Route::resource('manufacture',ManufactureController::class)->except(['create','show']);
    Route::resource('drug',DrugController::class)->except(['show']);
});

Route::prefix("report")->as("report.")->group(function(){
    Route::controller(ReportController::class)->group(function(){
        Route::get("drugs",'drugs')->name('drugs.index');
        Route::get("drug/{id}",'drug')->name('drugs.show');
        Route::get("drug/{id}/print",'drugPrint')->name("drugs.print");
        Route::get("transactions",'transactions')->name("transactions.index");
        Route::get("transaction/{id}",'transaction')->name("transactions.show");
        Route::get("transaction/{id}/print",'transactionPrint')->name("transactions.print");
    });
});
Route::prefix('management')->group(function () {
    Route::controller(ManagementController::class)->as('management.')->group(function(){
        Route::prefix("bill")->as("bill.")->group(function () {
            Route::get("/","bills")->name("index");
            Route::get("{bill}","bill")->name("show");
            Route::get("{bill}/print", "billPrint")->name("print");
            Route::post("{bill}/pay", "billPay")->name("pay");
        });
        Route::prefix("retur")->as("retur.")->group(function () {
            Route::get("/", "returs")->name("index");
            Route::get("{retur}", "retur")->name("show");
            Route::post("{retur}/pay", "returPay")->name("pay");
            Route::get("{retur}/print", "returPrint")->name("print");
        });
    });
});
