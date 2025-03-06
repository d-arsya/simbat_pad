<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClinicFlowController;
use App\Http\Controllers\ClinicStockController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\InventoryFlowController;
use App\Http\Controllers\InventoryStockController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ManufactureController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\VendorController;
use App\Models\Master\Drug;
use App\Models\Master\Variant;
use App\Models\Transaction\Transaction;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
// menambahkan excel
use Maatwebsite\Excel\Facades\Excel;



Route::get('/drug-suggestions', [DrugController::class, 'getSuggestions']);
Route::get('/drug-repack', [DrugController::class, 'getRepacks']);
Route::get('/category-search', [CategoryController::class, 'searchCategory']);
Route::get('/variant-search', [VariantController::class, 'searchVariant']);
Route::get('/manufacture-search', [ManufactureController::class, 'searchManufacture']);
Route::get('/vendor-search', [VendorController::class, 'searchVendor']);
Route::get('/drug-search', [DrugController::class, 'searchDrug']);
Route::get('/inventory-stock-search', [InventoryStockController::class, 'searchInventoryStock']);
Route::get('/clinic-stock-search', [ClinicStockController::class, 'searchClinicStock']);
Route::get('/transaction-search', [ReportController::class, 'searchTransaction']);
Route::get('/management-search', [ManagementController::class, 'searchManagement']);


Route::get('/get-drug-price/{name}/{type}', function ($name, $type) {
    $drug = Drug::where('name', $name)->first();
    match ($type) {
        "pcs" => $price = $drug->last_price,
        "box" => $price = $drug->box_price,
        "pack" => $price = $drug->pack_price,
    };
    return response()->json(['price' => $drug ? $price : 0]);
});

Route::redirect('/github', 'https://github.com/d-arsya/simbat_pad.git');
Route::redirect('/drive', 'https://drive.google.com/drive/folders/1SQLVZcn1y_XOcjy6E53WwudAiFLIaf-J');
Route::redirect('/figma', 'https://www.figma.com/design/4NIUdh1KTOoyEH3WYWPRH6/SIMBAT-PAD-24?node-id=0-1&t=bbnNvAjBdq5SYAoq-1');
// 'index','create','store','show','edit','update','destroy'

Route::controller(UserController::class)->group(function () {
    Route::match(['get', 'post'], '/login', 'login')->name('login');
    Route::match(['get', 'post'], '/forgot', 'forgot')->name('user.forgot');
    Route::get('reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('reset-password', 'resetPassword')->name('user.password');

    Route::match(['get', 'put'], '/settings', 'settings')->name('user.settings')->middleware('auth');
    Route::get("/logout", 'logout')->name("user.logout");
});

Route::middleware('auth')->group(function () {
    Route::redirect('/', '/dashboard');
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('transaction', TransactionController::class)->except(['edit', 'update', 'destroy']);
    Route::resource('user', UserController::class)->except(['show']);

    Route::prefix("inventory")->as('inventory.')->group(function () {
        Route::post("inflows/print", [InventoryFlowController::class, "print"])->name("inflows.print");
        Route::resource('inflows', InventoryFlowController::class)->except([
            'edit',
            'update',
            'destroy'
        ]);
        Route::match(['get', 'post'], "stocks/retur/{batch}", [InventoryStockController::class, "retur"])->name('retur');
        Route::match(['get', 'post'], "stocks/trash/{batch}", [InventoryStockController::class, "trash"])->name('trash');
        Route::resource('stocks', InventoryStockController::class)->only([
            'index',
            'show'
        ]);
    });

    Route::prefix("clinic")->as('clinic.')->group(function () {
        Route::resource('inflows', ClinicFlowController::class)->except([
            'edit',
            'update',
            'destroy'
        ]);
        Route::match(['get', 'post'], "stocks/retur/{batch}", [ClinicStockController::class, "retur"])->name('retur');
        Route::match(['get', 'post'], "stocks/trash/{batch}", [ClinicStockController::class, "trash"])->name('trash');
        Route::resource('stocks', ClinicStockController::class)->only([
            'index',
            'show'
        ]);
    });

    Route::prefix('master')->as('master.')->group(function () {
        Route::prefix('drug/{drug}')->group(function () {
            Route::post('repack', [DrugController::class, 'repack'])->name('drug.repack.store');
            Route::delete('repack/{repack}', [DrugController::class, 'repack'])->name("drug.repack.destroy");
        });
        Route::resource('category', CategoryController::class)->except(['create', 'show', 'edit']);
        Route::resource('vendor', VendorController::class)->except(['show']);
        Route::resource('variant', VariantController::class)->except(['create', 'show', 'edit']);
        Route::resource('manufacture', ManufactureController::class)->except(['create', 'show', 'edit']);
        Route::resource('drug', DrugController::class)->except(['show']);
    });

    Route::prefix("report")->as("report.")->group(function () {
        Route::controller(ReportController::class)->group(function () {
            Route::get("drugs", 'drugs')->name('drugs.index');
            Route::get("drug/{id}", 'drug')->name('drugs.show');
            Route::get("drug/{id}/print", 'drugPrint')->name("drugs.print");
            Route::get("transactions", 'transactions')->name("transactions.index");
            Route::get("transaction/{id}", 'transaction')->name("transactions.show");
            Route::get("transaction/{id}/print", 'transactionPrint')->name("transactions.print");
        });
    });
    Route::prefix('management')->group(function () {
        Route::controller(ManagementController::class)->as('management.')->group(function () {
            Route::prefix("bill")->as("bill.")->group(function () {
                Route::get("/", "bills")->name("index");
                Route::get("{bill}", "bill")->name("show");
                Route::get("{bill}/print", "billPrint")->name("print");
                Route::post("{bill}/pay", "billPay")->name("pay");
            });
            Route::prefix("retur")->as("retur.")->group(function () {
                Route::get("/", "returs")->name("index");
                Route::get("{retur}", "retur")->name("show");
                Route::post("{retur}/pay", "returPay")->name("pay");
                Route::get("{retur}/print", "returPrint")->name("print");
            });
            Route::prefix("trash")->as("trash.")->group(function () {
                Route::get("/", "trashes")->name("index");
                Route::get("{trash}", "trash")->name("show");
            });
        });
    });
    // menambahkan route untuk mendonwload excel
    Route::get('/inventory/export/{id}', [InventoryFlowController::class, 'export'])->name('inventory.export');

});
