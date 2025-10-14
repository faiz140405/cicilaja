<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\SubmissionController as AdminSubmissionController;
use App\Http\Controllers\User\SubmissionController as UserSubmissionController;
use App\Http\Controllers\User\PaymentController as UserPaymentController; // Tambahkan import PaymentController
use App\Http\Controllers\Admin\PaymentVerificationController; // Tambahkan import PaymentVerificationController
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;

/*
|--------------------------------------------------------------------------
| Landing Page Route
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing'); 
Route::get('/faq-panduan', [LandingController::class, 'faq'])->name('faq');
Route::get('/syarat-ketentuan', [LandingController::class, 'terms'])->name('terms');
Route::get('/products', [LandingController::class, 'allProducts'])->name('products.index');



/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // ------------------------------------
    // 1. PROFILE MANAGEMENT (Breeze Default)
    // ------------------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // ------------------------------------
    // 2. ROUTE USER (PELANGGAN)
    // ------------------------------------
    
    // Dashboard User: Menampilkan riwayat pengajuan
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->middleware('role:user')->name('user.dashboard');
    
    // GROUP USER ROUTES
    Route::prefix('user')->name('user.')->group(function () {
        
        // Pengajuan Kredit
        Route::get('submissions/create/{product}', [UserSubmissionController::class, 'create'])->name('submissions.create');
        Route::post('submissions', [UserSubmissionController::class, 'store'])->name('submissions.store');
        
        // Pembayaran Cicilan
        Route::get('payments', [UserPaymentController::class, 'index'])->name('payments.index');
        Route::post('payments/{submission}', [UserPaymentController::class, 'store'])->name('payments.store');
        Route::post('payments/accelerated/{submission}', [UserPaymentController::class, 'acceleratedStore'])->name('payments.accelerated');
        
    }); // <-- Penutup GROUP USER (prefix/name)


    // ------------------------------------
    // 3. ROUTE ADMIN (PROTECTED)
    // ------------------------------------
    Route::middleware(['auth','role:admin'])->group(function () {
        
        // Dashboard Admin
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // CRUD Manajemen Produk
        Route::resource('admin/products', ProductController::class)->names('admin.products');
        
        // Manajemen Pengajuan Kredit
        Route::resource('admin/submissions', AdminSubmissionController::class)
            ->only(['index', 'update'])
            ->names('admin.submissions');
            
        // Update Status Pengajuan (Setujui/Tolak)
        Route::patch('admin/submissions/{submission}/status', [AdminSubmissionController::class, 'updateStatus'])->name('admin.submissions.update');
        
        // Verifikasi Pembayaran
        Route::get('admin/payments/verify', [PaymentVerificationController::class, 'index'])->name('admin.payments.verify.index');
        Route::patch('admin/payments/verify/{payment}', [PaymentVerificationController::class, 'update'])->name('admin.payments.verify.update');

        Route::get('admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('admin/reports/export', [ReportController::class, 'export'])->name('admin.reports.export');
    }); // <-- Penutup GROUP ADMIN


    // ------------------------------------
    // 4. FALLBACK DASHBOARD (Default Breeze)
    // ------------------------------------
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->middleware(['verified'])->name('dashboard');
    
}); // <-- Penutup GROUP AUTH UTAMA (middleware('auth'))

require __DIR__.'/auth.php';
