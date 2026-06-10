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

Route::redirect('/', '/login');

Route::group([
	'middleware' => 'auth',
	'prefix' => 'panel',
	'as' => 'admin.'
], function(){
	// diagnosa menu
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa');
	Route::post('/diagnosa', [DiagnosaController::class, 'diagnosa'])->name('diagnosa');

	// logs
	Route::get('/logs', [DashboardController::class, 'activity_logs'])->name('logs');
	Route::post('/logs/delete', [DashboardController::class, 'delete_logs'])->name('logs.delete');

	// menu riwayat
	Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.daftar');
	Route::get('/riwayat/detail/{riwayat}', [RiwayatController::class, 'show'])->name('riwayat');

	// Member menu
	Route::get('/member', [UserController::class, 'index'])->name('member');
	Route::get('/member/create', [UserController::class, 'create'])->name('member.create');
	Route::post('/member/create', [UserController::class, 'store'])->name('member.create');
	Route::get('/member/{id}/edit', [UserController::class, 'edit'])->name('member.edit');
	Route::post('/member/{id}/update', [UserController::class, 'update'])->name('member.update');
	Route::post('/member/{id}/delete', [UserController::class, 'destroy'])->name('member.delete');

	// menu penyakit -> fasilitasKesehatan
	Route::get('/fasilitasKesehatan', [FasilitasKesehatanController::class, 'index'])->name('fasilitasKesehatan');
	Route::post('/fasilitasKesehatan', [FasilitasKesehatanController::class, 'store'])->name('fasilitasKesehatan.store');
	Route::get('/fasilitasKesehatan/json', [FasilitasKesehatanController::class, 'json'])->name('fasilitasKesehatan.json');
	Route::post('/fasilitasKesehatan/update', [FasilitasKesehatanController::class, 'update'])->name('fasilitasKesehatan.update');
	Route::post('/fasilitasKesehatan/{fasilitasKesehatan}/destroy', [FasilitasKesehatanController::class, 'destroy'])->name('fasilitasKesehatan.destroy');

	// menu gejala -> artikel
	Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');
	Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
	Route::get('/artikel/json', [ArtikelController::class, 'json'])->name('artikel.json');
	Route::post('/artikel/update', [ArtikelController::class, 'update'])->name('artikel.update');
	Route::post('/artikel/{artikel}/destroy', [ArtikelController::class, 'destroy'])->name('artikel.destroy');

	// menu feedback (new)
	Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');
	Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
	Route::get('/feedback/json', [FeedbackController::class, 'json'])->name('feedback.json');
	Route::post('/feedback/update', [FeedbackController::class, 'update'])->name('feedback.update');
	Route::post('/feedback/{feedback}/destroy', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

	// menu forum (new)
	Route::get('/forum', [App\Http\Controllers\ForumController::class, 'index'])->name('forum');
	Route::get('/forum/json', [App\Http\Controllers\ForumController::class, 'json'])->name('forum.json');
	Route::get('/forum/{forum}', [App\Http\Controllers\ForumController::class, 'show'])->name('forum.show');
	Route::post('/forum/update', [App\Http\Controllers\ForumController::class, 'update'])->name('forum.update');
	Route::post('/forum/{forum}/destroy', [App\Http\Controllers\ForumController::class, 'destroy'])->name('forum.destroy');
	Route::post('/forum/comment/{comment}/destroy', [App\Http\Controllers\ForumCommentController::class, 'destroy'])->name('forum.comment.destroy');

	// menu monitoring (new)
	Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
	Route::post('/monitoring', [MonitoringController::class, 'store'])->name('monitoring.store');
	Route::get('/monitoring/json', [MonitoringController::class, 'json'])->name('monitoring.json');
	Route::post('/monitoring/update', [MonitoringController::class, 'update'])->name('monitoring.update');
	Route::post('/monitoring/{monitoring}/destroy', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');

	// menu rules
	Route::get('/rules/{id}', [RuleController::class, 'index'])->name('rules');
	Route::post('/rules/{id}/update', [RuleController::class, 'update'])->name('rules.update');
	
	
	// Profile menu
	Route::view('/profile', 'admin.profile')->name('profile');
	Route::post('/profile', [DashboardController::class, 'profile_update'])->name('profile');
	Route::post('/profile/upload', [DashboardController::class, 'upload_avatar'])
		->name('profile.upload');

	Route::get('/tes', function() {
	})->name('test');

});

// User routes
Route::group([
	'middleware' => 'auth',
	'prefix' => 'user',
	'as' => 'user.'
], function(){
	// menu feedback for user
	Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');
	Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
	Route::get('/feedback/json', [FeedbackController::class, 'json'])->name('feedback.json');
	Route::post('/feedback/update', [FeedbackController::class, 'update'])->name('feedback.update');
	Route::post('/feedback/{feedback}/destroy', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

	// menu forum for user
	Route::get('/forum', [App\Http\Controllers\ForumController::class, 'index'])->name('forum');
	Route::post('/forum', [App\Http\Controllers\ForumController::class, 'store'])->name('forum.store');
	Route::get('/forum/json', [App\Http\Controllers\ForumController::class, 'json'])->name('forum.json');
	Route::get('/forum/{forum}', [App\Http\Controllers\ForumController::class, 'show'])->name('forum.show');
	Route::post('/forum/update', [App\Http\Controllers\ForumController::class, 'update'])->name('forum.update');
	Route::post('/forum/{forum}/destroy', [App\Http\Controllers\ForumController::class, 'destroy'])->name('forum.destroy');
	Route::post('/forum/{forum}/comment', [App\Http\Controllers\ForumCommentController::class, 'store'])->name('forum.comment.store');
	Route::post('/forum/comment/{comment}/destroy', [App\Http\Controllers\ForumCommentController::class, 'destroy'])->name('forum.comment.destroy');
});


require __DIR__.'/auth.php';
