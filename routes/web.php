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
    UserController,
    TbPredictionController
};

Route::redirect('/', '/login');

// ============================================================
// ADMIN ROUTES — prefix: /admin/
// Semua fitur yang diakses admin tersimpan di views/admin/
// ============================================================
Route::group([
    'middleware' => 'auth',
    'prefix'     => 'admin',
    'as'         => 'admin.',
], function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logs aktivitas
    Route::get('/logs', [DashboardController::class, 'activity_logs'])->name('logs');
    Route::post('/logs/delete', [DashboardController::class, 'delete_logs'])->name('logs.delete');

    // Diagnosa CF (lama) — TERSEMBUNYI dari sidebar, route tetap ada
    Route::get('/diagnosa',  [DiagnosaController::class, 'index'])->name('diagnosa');
    Route::post('/diagnosa', [DiagnosaController::class, 'diagnosa'])->name('diagnosa.post');

    // Prediksi ML — Log aktivitas untuk admin
    Route::get('/prediksi', [TbPredictionController::class, 'adminIndex'])->name('prediksi');

    // Riwayat diagnosa CF (lama)
    Route::get('/riwayat',               [RiwayatController::class, 'index'])->name('riwayat.daftar');
    Route::get('/riwayat/detail/{riwayat}', [RiwayatController::class, 'show'])->name('riwayat');

    // Member (manajemen user)
    Route::get('/member',              [UserController::class, 'index'])->name('member');
    Route::get('/member/create',       [UserController::class, 'create'])->name('member.create');
    Route::post('/member/create',      [UserController::class, 'store'])->name('member.create.store');
    Route::get('/member/{id}/edit',    [UserController::class, 'edit'])->name('member.edit');
    Route::post('/member/{id}/update', [UserController::class, 'update'])->name('member.update');
    Route::post('/member/{id}/delete', [UserController::class, 'destroy'])->name('member.delete');

    // Fasilitas Kesehatan
    Route::get('/fasilitasKesehatan',              [FasilitasKesehatanController::class, 'index'])->name('fasilitasKesehatan');
    Route::post('/fasilitasKesehatan',             [FasilitasKesehatanController::class, 'store'])->name('fasilitasKesehatan.store');
    Route::get('/fasilitasKesehatan/json',         [FasilitasKesehatanController::class, 'json'])->name('fasilitasKesehatan.json');
    Route::post('/fasilitasKesehatan/update',      [FasilitasKesehatanController::class, 'update'])->name('fasilitasKesehatan.update');
    Route::post('/fasilitasKesehatan/{f}/destroy', [FasilitasKesehatanController::class, 'destroy'])->name('fasilitasKesehatan.destroy');

    // Artikel
    Route::get('/artikel',              [ArtikelController::class, 'index'])->name('artikel');
    Route::post('/artikel',             [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/json',         [ArtikelController::class, 'json'])->name('artikel.json');
    Route::post('/artikel/update',      [ArtikelController::class, 'update'])->name('artikel.update');
    Route::post('/artikel/{a}/destroy', [ArtikelController::class, 'destroy'])->name('artikel.destroy');

    // Feedback
    Route::get('/feedback',              [FeedbackController::class, 'index'])->name('feedback');
    Route::post('/feedback',             [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/json',         [FeedbackController::class, 'json'])->name('feedback.json');
    Route::post('/feedback/update',      [FeedbackController::class, 'update'])->name('feedback.update');
    Route::post('/feedback/{f}/destroy', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

    // Monitoring
    Route::get('/monitoring',              [MonitoringController::class, 'index'])->name('monitoring');
    Route::post('/monitoring',             [MonitoringController::class, 'store'])->name('monitoring.store');
    Route::get('/monitoring/json',         [MonitoringController::class, 'json'])->name('monitoring.json');
    Route::post('/monitoring/update',      [MonitoringController::class, 'update'])->name('monitoring.update');
    Route::post('/monitoring/{m}/destroy', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');

    // Rules
    Route::get('/rules/{id}',        [RuleController::class, 'index'])->name('rules');
    Route::post('/rules/{id}/update',[RuleController::class, 'update'])->name('rules.update');

    // Profile
    Route::view('/profile', 'admin.profile')->name('profile');
    Route::post('/profile',          [DashboardController::class, 'profile_update'])->name('profile.update');
    Route::post('/profile/upload',   [DashboardController::class, 'upload_avatar'])->name('profile.upload');
});

// ============================================================
// USER ROUTES — prefix: /users/
// Semua fitur user tersimpan di views/users/
// ============================================================
Route::group([
    'middleware' => 'auth',
    'prefix'     => 'users',
    'as'         => 'users.',
], function () {

    // Prediksi ML — fitur lengkap untuk user
    Route::get('/prediksi',               [TbPredictionController::class, 'index'])->name('prediksi.index');
    Route::get('/prediksi/create',        [TbPredictionController::class, 'create'])->name('prediksi.create');
    Route::post('/prediksi',              [TbPredictionController::class, 'store'])->name('prediksi.store');
    Route::get('/prediksi/{tbPrediction}',[TbPredictionController::class, 'show'])->name('prediksi.show');
});


require __DIR__.'/auth.php';
