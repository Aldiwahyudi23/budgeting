<?php

use App\Http\Controllers\Alokasi\AllocationExController;
use App\Http\Controllers\Alokasi\AllocationInController;
use App\Http\Controllers\Assets\BpjsJhtController;
use App\Http\Controllers\Assets\SavingController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\Financial\BillController;
use App\Http\Controllers\Financial\DebtController;
use App\Http\Controllers\Financial\LoanController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MasterData\AccountBankController;
use App\Http\Controllers\MasterData\CategoryController;
use App\Http\Controllers\MasterData\DebitController;
use App\Http\Controllers\MasterData\SourceController;
use App\Http\Controllers\MasterData\SubCategoryController;
use App\Http\Controllers\MasterData\SubSourceController;
use App\Http\Controllers\Menu\AsetController;
use App\Http\Controllers\Menu\HomeContorller;
use App\Http\Controllers\Menu\LaporanController;
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

Route::get('/login-otp', [OtpController::class, 'showLoginForm'])->name('login-otp');
Route::post('/check-phone', [OtpController::class, 'checkPhone'])->name('check-phone');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('verify-otp');
Route::post('/resend-otp', [OtpController::class, 'resendOtp'])->name('resend-otp');


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
    Route::get('/dashboard', [HomeContorller::class, 'home'])->name('home');

    Route::resource('/master-data/source', SourceController::class);
    Route::get('/master-data/manage-sources', [SourceController::class, 'manage'])->name('sources.manage');
    Route::post('/master-data/manage-sources/save', [SourceController::class, 'saveSelected'])->name('sources.save');
    Route::patch('/sources/{source}/update-public', [SourceController::class, 'updatePublic'])->name('sources.update-public');

    Route::resource('/master-data/sub-sources', SubSourceController::class);
    Route::patch('/sub-sources/{sub_source}/update-public', [SubSourceController::class, 'updatePublic'])->name('sub-sources.update-public');

    Route::resource('/master-data/category', CategoryController::class);
    Route::get('/master-data/manage-categories', [CategoryController::class, 'manage'])->name('categories.manage');
    Route::post('/master-data/manage-categories/save', [CategoryController::class, 'saveSelected'])->name('categories.save');
    Route::patch('/categories/{category}/update-public', [CategoryController::class, 'updatePublic'])->name('categories.update-public');
    Route::patch('/categories/{category}/update-public', [CategoryController::class, 'updatePublic'])->name('categories.update-public');

    Route::resource('/master-data/sub-category', SubCategoryController::class);
    Route::patch('/sub-categories/{subCategory}/update-public', [SubCategoryController::class, 'updatePublic'])->name('sub-categories.update-public');

    Route::resource('/master-data/allocation-ex', AllocationExController::class);
    Route::put('/master-data/category/is-active/{id}', [AllocationExController::class, 'updateCategoryStatus'])->name('category_active');

    Route::resource('/master-data/allocation-in', AllocationInController::class);
    Route::put('/master-data/source/is-active/{id}', [AllocationInController::class, 'updateSourceStatus'])->name('source_active');

    Route::resource('/master-data/account-bank', AccountBankController::class);
    Route::get('/account-bank/{id}/mutation', [AccountBankController::class, 'mutation'])->name('account-bank.mutation'); // Route untuk mutasi
    Route::post('/account-bank/withdraw', [AccountBankController::class, 'withdraw'])->name('account-bank.withdraw');
    Route::post('/account-bank/deposit', [AccountBankController::class, 'deposit'])->name('account-bank.deposit');
    Route::post('/account-bank/topUp', [AccountBankController::class, 'topUp'])->name('account-bank.topUp');
    Route::resource('/master-data/debits', DebitController::class);

    Route::resource('/expense', ExpensesController::class);
    Route::resource('/income', IncomeController::class);

    Route::resource('/savings', SavingController::class);
    Route::resource('/bills', BillController::class);
    Route::get('/history-pembayaran/bills/{id}', [BillController::class, 'pembayaran'])->name('history_pembayaran_bill');
    Route::resource('/debts', DebtController::class);
    Route::get('/history-pembayaran/debts/{id}', [DebtController::class, 'pembayaran'])->name('history_pembayaran_debt');
    Route::resource('/loans', LoanController::class);
    Route::get('/history-pembayaran/loans/{id}', [LoanController::class, 'pembayaran'])->name('history_pembayaran_loan');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/{key}', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/setting/account-bank/saving/{key}', [SettingController::class, 'update_accountBank'])->name('setting_Account.update');
    Route::get('/sandi-botton', [SettingController::class, 'sandiBotton'])
        ->middleware(['auth'])
        ->name('sandi-botton');

    Route::put('/sandi-botton', [SettingController::class, 'updateSandiBotton'])
        ->middleware(['auth'])
        ->name('sandi-botton.update');
    Route::post('/sandi-botton', [SettingController::class, 'updateSandiBotton'])
        ->middleware(['auth'])
        ->name('sandi-botton.simpan');

    Route::get('/home', [HomeContorller::class, 'home'])->name('home');
    Route::get('/finance-summary', [HomeContorller::class, 'getFinanceSummary']);

    Route::get('/aset', [AsetController::class, 'aset'])->name('aset');
    Route::get('/laporan', [LaporanController::class, 'laporan'])->name('laporan');
    Route::get('/master-data', [MenuController::class, 'setupData'])->name('setupData');

    Route::get('/jobs', [JobController::class, 'index']);
    Route::post('/job', [JobController::class, 'store'])->name('job.store');
    Route::put('/job/{job}', [JobController::class, 'update'])->name('job.update');

    Route::resource('/aset/bpjs', BpjsJhtController::class);
});