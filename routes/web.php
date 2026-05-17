<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    DiagnosaController,
    RiwayatController,
    ArtikelController,
    FasilitasKesehatanController,
    FeedbackController,
    MonitoringController,
    RuleController,
    UserController
};
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\User\DashboardController as UserDashboard;

Route::redirect('/', '/login');

// Admin Routes
Route::group([
    'middleware' => ['auth', 'isAdmin'],
    'prefix' => 'panel',
    'as' => 'admin.'
], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa');
    Route::post('/diagnosa', [DiagnosaController::class, 'diagnosa'])->name('diagnosa');

    Route::get('/logs', [DashboardController::class, 'activity_logs'])->name('logs');
    Route::post('/logs/delete', [DashboardController::class, 'delete_logs'])->name('logs.delete');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.daftar');
    Route::get('/riwayat/detail/{riwayat}', [RiwayatController::class, 'show'])->name('riwayat');

    Route::get('/member', [UserController::class, 'index'])->name('member');
    Route::get('/member/create', [UserController::class, 'create'])->name('member.create');
    Route::post('/member/create', [UserController::class, 'store'])->name('member.create');
    Route::get('/member/{id}/edit', [UserController::class, 'edit'])->name('member.edit');
    Route::post('/member/{id}/update', [UserController::class, 'update'])->name('member.update');
    Route::post('/member/{id}/delete', [UserController::class, 'destroy'])->name('member.delete');

    Route::get('/fasilitasKesehatan', [FasilitasKesehatanController::class, 'index'])->name('fasilitasKesehatan');
    Route::post('/fasilitasKesehatan', [FasilitasKesehatanController::class, 'store'])->name('fasilitasKesehatan.store');
    Route::get('/fasilitasKesehatan/json', [FasilitasKesehatanController::class, 'json'])->name('fasilitasKesehatan.json');
    Route::post('/fasilitasKesehatan/update', [FasilitasKesehatanController::class, 'update'])->name('fasilitasKesehatan.update');
    Route::post('/fasilitasKesehatan/{fasilitasKesehatan}/destroy', [FasilitasKesehatanController::class, 'destroy'])->name('fasilitasKesehatan.destroy');

    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/json', [ArtikelController::class, 'json'])->name('artikel.json');
    Route::post('/artikel/update', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::post('/artikel/{artikel}/destroy', [ArtikelController::class, 'destroy'])->name('artikel.destroy');

    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/json', [FeedbackController::class, 'json'])->name('feedback.json');
    Route::post('/feedback/update', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::post('/feedback/{feedback}/destroy', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
    Route::post('/monitoring', [MonitoringController::class, 'store'])->name('monitoring.store');
    Route::get('/monitoring/json', [MonitoringController::class, 'json'])->name('monitoring.json');
    Route::post('/monitoring/update', [MonitoringController::class, 'update'])->name('monitoring.update');
    Route::post('/monitoring/{monitoring}/destroy', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');

    Route::get('/rules/{id}', [RuleController::class, 'index'])->name('rules');
    Route::post('/rules/{id}/update', [RuleController::class, 'update'])->name('rules.update');

    Route::view('/profile', 'admin.profile')->name('profile');
    Route::post('/profile', [DashboardController::class, 'profile_update'])->name('profile');
    Route::post('/profile/upload', [DashboardController::class, 'upload_avatar'])->name('profile.upload');

    Route::get('/tes', function() {})->name('test');

    // PBI #22 - Sebaran Wilayah
    Route::get('/sebaran', [AdminDashboard::class, 'index'])->name('sebaran');
});

// User Routes
Route::prefix('user')
    ->middleware(['auth'])
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
    });

require __DIR__.'/auth.php';