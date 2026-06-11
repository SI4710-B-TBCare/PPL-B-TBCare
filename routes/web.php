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
	JadwalPemeriksaanController,
	PerkembanganKesehatanController
};

Route::redirect('/', '/login');

Route::group([
    'middleware' => 'auth',
    'prefix' => 'panel',
    'as' => 'admin.'
], function () {

    // diagnosa menu
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/diagnosa', [DiagnosaController::class, 'index'])
        ->name('diagnosa');

    Route::post('/diagnosa', [DiagnosaController::class, 'diagnosa'])
        ->name('diagnosa');


    // logs
    Route::get('/logs', [DashboardController::class, 'activity_logs'])
        ->name('logs');

    Route::post('/logs/delete', [DashboardController::class, 'delete_logs'])
        ->name('logs.delete');


    // menu riwayat diagnosa
    Route::get('/riwayat', [RiwayatController::class, 'index'])
        ->name('riwayat.daftar');

    Route::get('/riwayat/detail/{riwayat}', [RiwayatController::class, 'show'])
        ->name('riwayat');


    // member menu
    Route::get('/member', [UserController::class, 'index'])
        ->name('member');

    Route::get('/member/create', [UserController::class, 'create'])
        ->name('member.create');

    Route::post('/member/create', [UserController::class, 'store'])
        ->name('member.create');

    Route::get('/member/{id}/edit', [UserController::class, 'edit'])
        ->name('member.edit');

    Route::post('/member/{id}/update', [UserController::class, 'update'])
        ->name('member.update');

    Route::post('/member/{id}/delete', [UserController::class, 'destroy'])
        ->name('member.delete');


    // menu fasilitas kesehatan
    Route::get('/fasilitasKesehatan', [FasilitasKesehatanController::class, 'index'])
        ->name('fasilitasKesehatan');

    Route::post('/fasilitasKesehatan', [FasilitasKesehatanController::class, 'store'])
        ->name('fasilitasKesehatan.store');

    Route::get('/fasilitasKesehatan/json', [FasilitasKesehatanController::class, 'json'])
        ->name('fasilitasKesehatan.json');

    Route::post('/fasilitasKesehatan/update', [FasilitasKesehatanController::class, 'update'])
        ->name('fasilitasKesehatan.update');

    Route::post('/fasilitasKesehatan/{fasilitasKesehatan}/destroy', [FasilitasKesehatanController::class, 'destroy'])
        ->name('fasilitasKesehatan.destroy');


    // menu artikel
    Route::get('/artikel', [ArtikelController::class, 'index'])
        ->name('artikel');

    Route::post('/artikel', [ArtikelController::class, 'store'])
        ->name('artikel.store');

    Route::get('/artikel/json', [ArtikelController::class, 'json'])
        ->name('artikel.json');

    Route::post('/artikel/update', [ArtikelController::class, 'update'])
        ->name('artikel.update');

    Route::post('/artikel/{artikel}/destroy', [ArtikelController::class, 'destroy'])
        ->name('artikel.destroy');


    // menu feedback
    Route::get('/feedback', [FeedbackController::class, 'index'])
        ->name('feedback');

    Route::post('/feedback', [FeedbackController::class, 'store'])
        ->name('feedback.store');

    Route::get('/feedback/json', [FeedbackController::class, 'json'])
        ->name('feedback.json');

    Route::post('/feedback/update', [FeedbackController::class, 'update'])
        ->name('feedback.update');

    Route::post('/feedback/{feedback}/destroy', [FeedbackController::class, 'destroy'])
        ->name('feedback.destroy');

    // MONITORING 
    Route::get('/monitoring', [MonitoringController::class, 'index'])
        ->name('monitoring');

    Route::get('/monitoring/history', [MonitoringController::class, 'history'])
        ->name('monitoring.history');
	
	Route::get('/monitoring/download/{id}', [MonitoringController::class, 'download'])
		->name('monitoring.download');

    Route::post('/monitoring', [MonitoringController::class, 'store'])
        ->name('monitoring.store');

    Route::get('/monitoring/json', [MonitoringController::class, 'json'])
        ->name('monitoring.json');

    Route::post('/monitoring/update', [MonitoringController::class, 'update'])
        ->name('monitoring.update');

    Route::post('/monitoring/{monitoring}/destroy', [MonitoringController::class, 'destroy'])
        ->name('monitoring.destroy');

	//Perkembangan
	Route::get('/monitoring/{monitoring_id}/perkembangan', [PerkembanganKesehatanController::class, 'index']) 
		->name('perkembangan');

	Route::post('/perkembangan/store', [PerkembanganKesehatanController::class, 'store'])
		->name('perkembangan.store');

	Route::get('/perkembangan/json', [PerkembanganKesehatanController::class, 'json'])
		->name('perkembangan.json');

	Route::post('/perkembangan/update', [PerkembanganKesehatanController::class, 'update'])
		->name('perkembangan.update');

	Route::post('/perkembangan/{perkembangan}/destroy', [PerkembanganKesehatanController::class, 'destroy'])
		->name('perkembangan.destroy');

    // menu rules
    Route::get('/rules/{id}', [RuleController::class, 'index'])
        ->name('rules');

    Route::post('/rules/{id}/update', [RuleController::class, 'update'])
        ->name('rules.update');


	// Jadwal Pemeriksaan
	Route::get('/jadwal', [JadwalPemeriksaanController::class, 'index'])
    	->name('jadwal');

	Route::post('/jadwal', [JadwalPemeriksaanController::class, 'store'])
    	->name('jadwal.store');

	Route::get('/jadwal/json', [JadwalPemeriksaanController::class, 'json'])
    	->name('jadwal.json');

	Route::post('/jadwal/update', [JadwalPemeriksaanController::class, 'update'])
    	->name('jadwal.update');

	Route::post('/jadwal/{id}/destroy', [JadwalPemeriksaanController::class, 'destroy'])
    	->name('jadwal.destroy');

    // profile
    Route::view('/profile', 'admin.profile')
        ->name('profile');

    Route::post('/profile', [DashboardController::class, 'profile_update'])
        ->name('profile');

    Route::post('/profile/upload', [DashboardController::class, 'upload_avatar'])
        ->name('profile.upload');


    Route::get('/tes', function () {
    })->name('test');
});

require __DIR__ . '/auth.php';