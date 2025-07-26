<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\CustomRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\{AdminController, DokterManagementController, DokterOnlineController as AdminDokterOnlineController, PaymentController as AdminPaymentController};
use App\Http\Controllers\Dokter\{DokterController, DokterProfileController, OnlineStatusController, ConsultationController as DokterConsultationController, PaymentApprovalController, PendingController};
use App\Http\Controllers\Pengguna\{PenggunaController, DokterController as PenggunaDokterController, ConsultationController as PenggunaConsultationController};

// Welcome page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Dashboard redirect route
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    // Redirect ke dashboard yang sesuai berdasarkan role
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'dokter') {
        if (!$user->is_approved) {
            return redirect()->route('dokter.pending');
        }
        return redirect()->route('dokter.dashboard');
    } else {
        return redirect()->route('pengguna.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================
// CUSTOM REGISTRATION ROUTES
// ========================

// Custom Registration Routes (Updated - hanya data dasar)
Route::get('/register-dokter', [CustomRegisterController::class, 'showDokterForm'])->name('register.dokter');
Route::post('/register-dokter', [CustomRegisterController::class, 'registerDokter'])->name('register.dokter.submit');

// ========================
// ADMIN ROUTES
// ========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Dokter Management Routes dengan nama route tanpa prefix admin
    Route::get('dokter', [DokterManagementController::class, 'index'])->name('dokter.index');
    Route::get('dokter/create', [DokterManagementController::class, 'create'])->name('dokter.create');
    Route::post('dokter', [DokterManagementController::class, 'store'])->name('dokter.store');
    Route::get('dokter/{dokter}', [DokterManagementController::class, 'show'])->name('dokter.show');
    Route::get('dokter/{dokter}/edit', [DokterManagementController::class, 'edit'])->name('dokter.edit');
    Route::put('dokter/{dokter}', [DokterManagementController::class, 'update'])->name('dokter.update');
    Route::patch('dokter/{dokter}', [DokterManagementController::class, 'update'])->name('dokter.patch');
    Route::delete('dokter/{dokter}', [DokterManagementController::class, 'destroy'])->name('dokter.destroy');
    Route::get('dokter/pending-count', [DokterManagementController::class, 'getPendingCount'])->name('admin.dokter.pending-count');
    
    // Approval & Rejection routes
    Route::patch('dokter/{id}/approve', [DokterManagementController::class, 'approve'])->name('dokter.approve');
    Route::patch('dokter/{id}/reject', [DokterManagementController::class, 'reject'])->name('dokter.reject');
    
    // Profile Changes Approval Routes (BARU)
    Route::post('dokter/profile-change/{changeId}/approve', [DokterManagementController::class, 'approveProfileChange'])->name('admin.dokter.approve-profile-change');
    Route::post('dokter/profile-change/{changeId}/reject', [DokterManagementController::class, 'rejectProfileChange'])->name('admin.dokter.reject-profile-change');
    Route::get('dokter/profile-change/{changeId}/detail', [DokterManagementController::class, 'getProfileChangeDetail'])->name('admin.dokter.profile-change-detail');
    
    // Jadwal & Harga Management
    Route::get('dokter/{dokter}/set-jadwal-harga', [DokterManagementController::class, 'showJadwalHargaForm'])->name('dokter.setJadwalHargaForm');
    Route::post('dokter/{dokter}/set-jadwal-harga', [DokterManagementController::class, 'saveJadwalHarga'])->name('dokter.setJadwalHargaSave');

    // Online Status Management
    Route::patch('dokter/{id}/toggle-online', [DokterManagementController::class, 'toggleOnline'])->name('admin.dokter.toggle-online');

    // Payment Management  
    Route::get('payments', [AdminPaymentController::class, 'index'])->name('admin.payments.index');
    Route::patch('payments/{id}/approve', [AdminPaymentController::class, 'approve'])->name('admin.payments.approve');
    Route::patch('payments/{id}/reject', [AdminPaymentController::class, 'reject'])->name('admin.payments.reject');
});

// ========================
// DOKTER PENDING ROUTES - TANPA MIDDLEWARE APPROVAL CHECK
// ========================
Route::middleware(['auth'])->group(function () {
    // Route pending - bisa diakses semua dokter yang belum approved
    Route::get('dokter/pending', [PendingController::class, 'index'])->name('dokter.pending');
    
    // Route update profile - Langsung dari halaman pending (BARU)
    Route::put('dokter/update-profile', [PendingController::class, 'updateProfile'])->name('dokter.update-profile');
});

// ========================
// DOKTER ROUTES - APPROVED ONLY
// ========================
Route::middleware(['auth', 'role:dokter', 'check.dokter.approval'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/', [DokterController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [DokterProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [DokterProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [DokterProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete-photo', [DokterProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
    Route::delete('/profile/delete-certificate', [DokterProfileController::class, 'deleteCertificate'])->name('profile.delete-certificate');

    // Online Status
    Route::patch('toggle-online', [OnlineStatusController::class, 'toggle'])->name('toggle-online');

    // Payment Approval
    Route::get('payments', [PaymentApprovalController::class, 'index'])->name('payments.index');
    Route::patch('payments/{id}/approve', [PaymentApprovalController::class, 'approve'])->name('payments.approve');

    // Consultation Management
    Route::get('consultations', [DokterConsultationController::class, 'index'])->name('consultations.index');
    Route::get('consultations/{id}', [DokterConsultationController::class, 'show'])->name('consultations.show');
    Route::get('consultations/{id}/chat', [DokterConsultationController::class, 'chat'])->name('consultations.chat');
    Route::patch('consultations/{id}/diagnose', [DokterConsultationController::class, 'diagnose'])->name('consultations.diagnose');
});

// ========================
// PENGGUNA ROUTES
// ========================
Route::middleware(['auth', 'role:pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/syarat-ketentuan', function () {
        return view('pengguna.syarat');
    })->name('syarat');
    
    Route::get('/', [PenggunaController::class, 'index'])->name('dashboard');

    // Doctors (keeping original naming: dokters)
    Route::get('dokters', [PenggunaDokterController::class, 'index'])->name('dokters.index');
    Route::get('dokters/{id}', [PenggunaDokterController::class, 'show'])->name('dokters.show');

    // Consultations
    Route::get('consultations', [PenggunaConsultationController::class, 'index'])->name('consultations.index');
    Route::get('consultations/create/{dokter_id}', [PenggunaConsultationController::class, 'create'])->name('consultations.create');
    Route::post('consultations', [PenggunaConsultationController::class, 'store'])->name('consultations.store');
    Route::get('consultations/{id}/payment', [PenggunaConsultationController::class, 'payment'])->name('consultations.payment');
    Route::post('consultations/{id}/payment', [PenggunaConsultationController::class, 'processPayment'])->name('consultations.process-payment');
    Route::get('consultations/{id}', [PenggunaConsultationController::class, 'show'])->name('consultations.show');
    Route::get('consultations/{id}/chat', [PenggunaConsultationController::class, 'chat'])->name('consultations.chat');
});

Route::get('/test-edit', function() {
    $user = auth()->user();
    dd([
        'user_id' => $user->id,
        'name' => $user->name,
        'role' => $user->role,
        'approval_status' => $user->approval_status,
        'is_approved' => $user->is_approved
    ]);
})->middleware(['auth']);

// Include default Laravel Breeze auth routes
require __DIR__.'/auth.php';