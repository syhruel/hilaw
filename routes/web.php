<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\CustomRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\{AdminController, DokterManagementController, DokterOnlineController as AdminDokterOnlineController, PaymentController as AdminPaymentController};
use App\Http\Controllers\Dokter\{DokterController, DokterProfileController, OnlineStatusController, ConsultationController as DokterConsultationController, PaymentApprovalController};
use App\Http\Controllers\Pengguna\{PenggunaController, DokterController as PenggunaDokterController, ConsultationController as PenggunaConsultationController};

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Custom Registration Routes
Route::get('/register-dokter', [CustomRegisterController::class, 'showDokterForm'])->name('register.dokter');
Route::post('/register-dokter', [CustomRegisterController::class, 'registerDokter'])->name('register.dokter.submit');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('dokter', DokterManagementController::class);
    Route::patch('dokter/{id}/approve', [DokterManagementController::class, 'approve'])->name('dokter.approve');
    Route::get('dokter/{id}/set-jadwal-harga', [DokterManagementController::class, 'showJadwalHargaForm'])->name('dokter.setJadwalHargaForm');
    Route::post('dokter/{id}/set-jadwal-harga', [DokterManagementController::class, 'saveJadwalHarga'])->name('dokter.setJadwalHargaSave');

    // Online Status Management
    Route::patch('dokter/{id}/toggle-online', [AdminDokterOnlineController::class, 'toggleOnline'])->name('admin.dokter.toggle-online');

    // Payment Management
    Route::get('payments', [AdminPaymentController::class, 'index'])->name('admin.payments.index');
    Route::patch('payments/{id}/approve', [AdminPaymentController::class, 'approve'])->name('admin.payments.approve');
    Route::patch('payments/{id}/reject', [AdminPaymentController::class, 'reject'])->name('admin.payments.reject');
});

// Dokter Routes
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/', [DokterController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [DokterProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [DokterProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [DokterProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete-photo', [DokterProfileController::class, 'deletePhoto'])->name('profile.delete-photo');

    // Online Status
    Route::patch('toggle-online', [OnlineStatusController::class, 'toggle'])->name('toggle-online');

    // Payment Approval
    Route::get('payments', [PaymentApprovalController::class, 'index'])->name('payments.index');
    Route::patch('payments/{id}/approve', [PaymentApprovalController::class, 'approve'])->name('payments.approve');

    // Consultation Management
    Route::get('dokter/consultations/{id}/chat', [App\Http\Controllers\Dokter\ConsultationController::class, 'chat'])
    ->middleware(['auth', 'role:dokter'])->name('dokter.consultations.chat');
    Route::get('consultations/{id}/chat', [DokterConsultationController::class, 'chat'])->name('consultations.chat');

    // Consultations
    Route::get('consultations', [DokterConsultationController::class, 'index'])->name('consultations.index');
    Route::get('consultations/{id}', [DokterConsultationController::class, 'show'])->name('consultations.show');
    Route::patch('consultations/{id}/diagnose', [DokterConsultationController::class, 'diagnose'])->name('consultations.diagnose');
});

// Pengguna Routes
Route::middleware(['auth', 'role:pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/syarat-ketentuan', function () {
        return view('pengguna.syarat');
    })->name('syarat');
    Route::get('/', [PenggunaController::class, 'index'])->name('dashboard');

    // Doctors
    Route::get('dokters', [PenggunaDokterController::class, 'index'])->name('dokters.index');
    Route::get('dokters/{id}', [PenggunaDokterController::class, 'show'])->name('dokters.show');

    // Consultations
    Route::get('consultations', [PenggunaConsultationController::class, 'index'])->name('consultations.index');
    Route::get('consultations/create/{dokter_id}', [PenggunaConsultationController::class, 'create'])->name('consultations.create');
    Route::post('consultations', [PenggunaConsultationController::class, 'store'])->name('consultations.store');
    Route::get('consultations/{id}/payment', [PenggunaConsultationController::class, 'payment'])->name('consultations.payment');
    Route::post('consultations/{id}/payment', [PenggunaConsultationController::class, 'processPayment'])->name('consultations.process-payment');
    Route::get('consultations/{id}', [PenggunaConsultationController::class, 'show'])->name('consultations.show');

    Route::get('consultations/{id}/chat', [PenggunaConsultationController::class, 'chat'])
    ->name('consultations.chat');
    Route::get('consultations/{id}/chat', [PenggunaConsultationController::class, 'chat'])->name('consultations.chat');

});

require __DIR__.'/auth.php';
