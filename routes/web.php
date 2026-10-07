<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Auth;

Auth::routes();


Route::get('/', [GuestController::class, 'index'])->name('guest.index');


Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:user'])->prefix('user')->group(function () {
        Route::get('/home', [UserController::class, 'home'])->name('user.home');

        # INI BAGIAN TA
        // MENAMPILKAN
        Route::get('/tugas-akhir/kumpulkan', [UserController::class, 'createTa'])->name('user.ta.create');
        // MENAMBAHKAN
        Route::post('/tugas-akhir/kumpulkan', [UserController::class, 'storeTa'])->name('user.ta.store');
        // MENAMPILKAN HISTORY
        Route::get('/history/tugas-akhir', [UserController::class, 'historyTa'])->name('user.history.ta');
        // EDIT
        Route::get('/history/tugas-akhir/{id}/edit', [UserController::class, 'editTa'])->name('user.ta.edit');
        // UPDATE
        Route::post('/history/tugas-akhir/{id}/update', [UserController::class, 'updateTa'])->name('user.ta.update');
        // DELETE
        Route::delete('/history/tugas-akhir/{id}', [UserController::class, 'destroyTa'])->name('user.ta.destroy');
        // REVISI
        Route::get('/history/tugas-akhir/{id}/revisi', [UserController::class, 'revisiTa'])->name('user.ta.revisi');
        // REVISI UPDATE
        Route::post('/history/tugas-akhir/{id}/revisi', [UserController::class, 'updateRevisiTa'])->name('user.ta.update_revisi');


        # INI BAGIAN KP
        // MENAMPILKAN
        Route::get('/kerja-praktik/kumpulkan', [UserController::class, 'createKp'])->name('user.kp.create');
        // MENAMBAHKAN
        Route::post('/kerja-praktik/kumpulkan', [UserController::class, 'storeKp'])->name('user.kp.store');
        // MENAMPILKAN HISTORY
        Route::get('/history/kerja-praktik', [UserController::class, 'historyKp'])->name('user.history.kp');
        // EDIT
        Route::get('/history/kerja-praktik/{id}/edit', [UserController::class, 'editKp'])->name('user.kp.edit');
        // UPDATE
        Route::post('/history/kerja-praktik/{id}/update', [UserController::class, 'updateKp'])->name('user.kp.update');
        // DELETE
        Route::delete('/history/kerja-praktik/{id}', [UserController::class, 'destroyKp'])->name('user.kp.destroy');
        // REVISI 
        Route::get('/history/kerja-praktik/{id}/revisi', [UserController::class, 'revisiKp'])->name('user.kp.revisi');
        // REVISI UPDATE
        Route::post('/history/kerja-praktik/{id}/revisi', [UserController::class, 'updateRevisiKp'])->name('user.kp.update_revisi');


        # NOTIFICATION
        Route::get('/notifications', [UserController::class, 'notifications'])->name('user.notifications');
    });


    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/get-student-list', [AdminController::class, 'getStudentDetails'])->name('admin.student.details');
        // TUGAS AKHIR
        Route::get('/data-tugas-akhir', [AdminController::class, 'indexTa'])->name('admin.ta.index');
        Route::get('/data-tugas-akhir/{id}/review', [AdminController::class, 'reviewTa'])->name('admin.ta.review');
        Route::post('/data-tugas-akhir/{id}/review', [AdminController::class, 'updateStatusTa'])->name('admin.ta.updateStatus');
        Route::delete('/data-tugas-akhir/{id}', [AdminController::class, 'destroyTa'])->name('admin.ta.destroy');

        // KERJA PRAKTIK
        Route::get('/data-kerja-praktik', [AdminController::class, 'indexKp'])->name('admin.kp.index');
        Route::get('/data-kerja-praktik/{id}/review', [AdminController::class, 'reviewKp'])->name('admin.kp.review');
        Route::post('/data-kerja-praktik/{id}/review', [AdminController::class, 'updateStatusKp'])->name('admin.kp.updateStatus');
        Route::delete('/data-kerja-praktik/{id}', [AdminController::class, 'destroyKp'])->name('admin.kp.destroy');

        // KELOLA USER
        Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    });
});


Route::get('/home', function() {
    if (Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.home');
})->middleware('auth');