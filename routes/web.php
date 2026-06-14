<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    DiagnosaController,
    //RiwayatController,
    UserArtikelController,
    ArtikelController,
    FasilitasKesehatanController,
    FeedbackController,
    MonitoringController,
    RuleController,
    UserController,
    JadwalPemeriksaanController,
    PerkembanganKesehatanController,
    TbPredictionController,
    ChatbotController,
    ForumController,
    ForumCommentController

};
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

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

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logs aktivitas
    Route::get('/logs', [DashboardController::class, 'activity_logs'])->name('logs');
    Route::post('/logs/delete', [DashboardController::class, 'delete_logs'])->name('logs.delete');

    // Diagnosa CF (lama) — TERSEMBUNYI dari sidebar, route tetap ada
    Route::get('/diagnosa',  [DiagnosaController::class, 'index'])->name('diagnosa');
    Route::post('/diagnosa', [DiagnosaController::class, 'diagnosa'])->name('diagnosa.post');

    // Prediksi ML — Log aktivitas untuk admin
    Route::get('/prediksi', [TbPredictionController::class, 'adminIndex'])->name('prediksi');

    // Menu artikel
    Route::get('/artikel/generate-kode', [ArtikelController::class, 'generateKodeJson'])->name('artikel.generate-kode');
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/json', [ArtikelController::class, 'json'])->name('artikel.json');
    Route::post('/artikel/update', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::post('/artikel/{artikel}/destroy', [ArtikelController::class, 'destroy'])->name('artikel.destroy');
    Route::get('/artikel/{id}/detail', [ArtikelController::class, 'show'])->name('artikel.show');

    // Menu feedback
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/json', [FeedbackController::class, 'json'])->name('feedback.json');
    Route::post('/feedback/update', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::post('/feedback/{feedback}/destroy', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

    // Menu monitoring
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/json', [MonitoringController::class, 'json'])->name('monitoring.json');
    Route::post('/monitoring/update', [MonitoringController::class, 'update'])->name('monitoring.update');

    // Menu rules
    Route::get('/rules/{id}', [RuleController::class, 'index'])->name('rules');
    Route::post('/rules/{id}/update', [RuleController::class, 'update'])->name('rules.update');

    // Profile menu
    Route::view('/profile', 'admin.profile')->name('profile');
    Route::post('/profile', [DashboardController::class, 'profile_update'])->name('profile.update');
    Route::post('/profile/upload', [DashboardController::class, 'upload_avatar'])->name('profile.upload');

    Route::get('/tes', function () {})->name('test');

    // Riwayat diagnosa CF (lama)
    //Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.daftar');
    //Route::get('/riwayat/detail/{riwayat}', [RiwayatController::class, 'show'])->name('riwayat');

    // Member (manajemen user)
    Route::get('/member', [UserController::class, 'index'])->name('member');
    Route::get('/member/create', [UserController::class, 'create'])->name('member.create');
    Route::post('/member/create', [UserController::class, 'store'])->name('member.create.store');
    Route::get('/member/{id}/edit', [UserController::class, 'edit'])->name('member.edit');
    Route::post('/member/{id}/update', [UserController::class, 'update'])->name('member.update');
    Route::post('/member/{id}/delete', [UserController::class, 'destroy'])->name('member.delete');

    // Fasilitas Kesehatan
    Route::get('/fasilitasKesehatan', [FasilitasKesehatanController::class, 'index'])->name('fasilitasKesehatan');
    Route::post('/fasilitasKesehatan', [FasilitasKesehatanController::class, 'store'])->name('fasilitasKesehatan.store');
    Route::get('/fasilitasKesehatan/json', [FasilitasKesehatanController::class, 'json'])->name('fasilitasKesehatan.json');
    Route::post('/fasilitasKesehatan/update', [FasilitasKesehatanController::class, 'update'])->name('fasilitasKesehatan.update');
    Route::post('/fasilitasKesehatan/{f}/destroy', [FasilitasKesehatanController::class, 'destroy'])->name('fasilitasKesehatan.destroy');
    
    //forum
    Route::get('/forum', [ForumController::class, 'index'])->name('forum');
	Route::get('/forum/{forum}', [ForumController::class, 'show'])->name('forum.show');
	Route::post('/forum/{forum}/destroy', [ForumController::class, 'destroy'])->name('forum.destroy');
	Route::post('/forum/comment/{comment}/destroy', [ForumCommentController::class, 'destroy'])->name('forum.comment.destroy');
    
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

    // Dashboard User
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');

    // Artikel User
    Route::get('/artikel', [UserArtikelController::class, 'index'])->name('artikel.index');
    Route::get('/artikel/{id}', [UserArtikelController::class, 'show'])->name('artikel.show');

    // Prediksi ML — fitur lengkap untuk user
    Route::get('/prediksi',               [TbPredictionController::class, 'index'])->name('prediksi.index');
    Route::get('/prediksi/create',        [TbPredictionController::class, 'create'])->name('prediksi.create');
    Route::post('/prediksi',              [TbPredictionController::class, 'store'])->name('prediksi.store');
    Route::get('/prediksi/{tbPrediction}',[TbPredictionController::class, 'show'])->name('prediksi.show');
    Route::post('/prediksi/{id}/auto-recommendation', [TbPredictionController::class, 'generateAutoRecommendation'])->name('prediksi.auto-recommendation');

    // ChatBot TBC
    Route::get('/chatbot',                [ChatbotController::class, 'index'])->name('chatbot');
    Route::get('/chatbot/{predictionId}', [ChatbotController::class, 'index'])->name('chatbot.prediksi');
    Route::post('/chatbot/send',          [ChatbotController::class, 'send'])->name('chatbot.send');
    Route::post('/chatbot/reset',         [ChatbotController::class, 'reset'])->name('chatbot.reset');

    // menu feedback for user
	Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');
	Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
	Route::get('/feedback/json', [FeedbackController::class, 'json'])->name('feedback.json');
	Route::post('/feedback/update', [FeedbackController::class, 'update'])->name('feedback.update');
	Route::post('/feedback/{feedback}/destroy', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

	// menu forum for user
	Route::get('/forum', [ForumController::class, 'index'])->name('forum');
	Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
	Route::get('/forum/json', [ForumController::class, 'json'])->name('forum.json');
	Route::get('/forum/{forum}', [ForumController::class, 'show'])->name('forum.show');
	Route::post('/forum/update', [ForumController::class, 'update'])->name('forum.update');
	Route::post('/forum/{forum}/destroy', [ForumController::class, 'destroy'])->name('forum.destroy');
	Route::post('/forum/{forum}/comment', [ForumCommentController::class, 'store'])->name('forum.comment.store');
	Route::post('/forum/comment/{comment}/destroy', [ForumCommentController::class, 'destroy'])->name('forum.comment.destroy');

    // Menu Monitoring User
    Route::get('/monitoring/history', [MonitoringController::class, 'history'])->name('monitoring.history');
    Route::post('/monitoring', [MonitoringController::class, 'store'])->name('monitoring.store');
    Route::post('/monitoring/update', [MonitoringController::class, 'update'])->name('monitoring.update');
    Route::post('/monitoring/{monitoring}/destroy', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');
    Route::get('/monitoring/download/{id}', [MonitoringController::class, 'download'])->name('monitoring.download');
    
    // Perkembangan Kesehatan
    Route::get('/perkembangan',[PerkembanganKesehatanController::class, 'index'])->name('perkembangan');	Route::post('/perkembangan/store', [PerkembanganKesehatanController::class, 'store'])->name('perkembangan.store');
	Route::get('/perkembangan/json',[PerkembanganKesehatanController::class, 'json'])->name('perkembangan.json');
	Route::post('/perkembangan/update',[PerkembanganKesehatanController::class, 'update'])->name('perkembangan.update');
	Route::post('/perkembangan/{perkembangan}/destroy',[PerkembanganKesehatanController::class, 'destroy'])->name('perkembangan.destroy');

	// Jadwal Pemeriksaan
	Route::get('/jadwal',[JadwalPemeriksaanController::class, 'index'])->name('jadwal');
	Route::post('/jadwal',[JadwalPemeriksaanController::class, 'store'])->name('jadwal.store');
	Route::get('/jadwal/json',[JadwalPemeriksaanController::class, 'json'])->name('jadwal.json');
	Route::post('/jadwal/update',[JadwalPemeriksaanController::class, 'update'])->name('jadwal.update');
	Route::post('/jadwal/{id}/destroy',[JadwalPemeriksaanController::class, 'destroy'])->name('jadwal.destroy');
});

require __DIR__.'/auth.php';
