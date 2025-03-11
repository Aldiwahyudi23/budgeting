<?php

use App\Http\Controllers\Alokasi\AllocationExController;
use App\Http\Controllers\Alokasi\AllocationInController;
use App\Http\Controllers\Assets\SavingController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\MasterData\AccountBankController;
use App\Http\Controllers\MasterData\CategoryController;
use App\Http\Controllers\MasterData\DebitController;
use App\Http\Controllers\MasterData\SourceController;
use App\Http\Controllers\MasterData\SubCategoryController;
use App\Http\Controllers\MasterData\SubSourceController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SettingController;
use App\Models\MasterData\Category;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () {
    return redirect()->route('login'); // Redirect langsung ke login
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Menu/Home');
    // })->name('dashboard');
    Route::get('/dashboard', [MenuController::class, 'home'])->name('home');




    // Middleware untuk halaman setelah login
    // Route::middleware([
    //     'auth:sanctum',
    //     config('jetstream.auth_session'),
    //     'verified',
    // ])->group(function () {
    //     Route::get('/home', function () {
    //         return Inertia::render('Home'); // Ganti dengan halaman Home yang diinginkan
    //     })->name('home');


    Route::resource('/master-data/source', SourceController::class);
    Route::resource('/master-data/sub-sources', SubSourceController::class);
    Route::resource('/master-data/category', CategoryController::class);
    Route::resource('/master-data/sub-category', SubCategoryController::class);

    Route::resource('/master-data/allocation-ex', AllocationExController::class);
    Route::put('/master-data/category/is-active/{id}', [AllocationExController::class, 'updateCategoryStatus'])->name('category_active');

    Route::resource('/master-data/allocation-in', AllocationInController::class);
    Route::put('/master-data/source/is-active/{id}', [AllocationInController::class, 'updateSourceStatus'])->name('source_active');

    Route::resource('/master-data/account-bank', AccountBankController::class);
    Route::get('/account-bank/{accountBank}/mutation', [AccountBankController::class, 'mutation'])->name('account-bank.mutation'); // Route untuk mutasi
    Route::resource('/master-data/debits', DebitController::class);

    Route::resource('/expense', ExpensesController::class);
    Route::resource('/income', IncomeController::class);

    Route::resource('/savings', SavingController::class);

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/{key}', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/setting/account-bank/saving/{key}', [SettingController::class, 'update_accountBank'])->name('setting_Account.update');

    Route::get('/home', [MenuController::class, 'home'])->name('home');
    Route::get('/aset', [MenuController::class, 'aset'])->name('aset');
    Route::get('/laporan', [MenuController::class, 'laporan'])->name('laporan');
    Route::get('/master-data', [MenuController::class, 'setupData'])->name('setupData');
});