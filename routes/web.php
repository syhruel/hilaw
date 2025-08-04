<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\CustomRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\{AdminController, DokterManagementController, DokterOnlineController as AdminDokterOnlineController, PaymentController as AdminPaymentController, InvoiceController, PenggunaManagementController};
use App\Http\Controllers\Dokter\{DokterController, DokterProfileController, OnlineStatusController, ConsultationController as DokterConsultationController, PaymentApprovalController, PendingController};
use App\Http\Controllers\Pengguna\{PenggunaController, DokterController as PenggunaDokterController, ConsultationController as PenggunaConsultationController};

// Welcome page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// ========================
// PUBLIC PAGES (Navbar & Footer Links)
// ========================
Route::get('/tentang', [PublicController::class, 'tentang'])->name('tentang');
Route::get('/ahli-hukum', [PublicController::class, 'ahliHukum'])->name('ahli-hukum');
Route::get('/kontak', [PublicController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [PublicController::class, 'kontakStore'])->name('kontak.store');
Route::get('/layanan', [PublicController::class, 'layanan'])->name('layanan');
Route::get('/bantuan', [PublicController::class, 'bantuan'])->name('bantuan');
Route::get('/syarat-ketentuan', [PublicController::class, 'syaratKetentuan'])->name('syarat-ketentuan');

// ========================
// REGISTRATION CHOICE ROUTE
// ========================
Route::get('/pilih-registrasi', function () {
    return view('auth.register-choice');
})->name('register-choice');

// ========================
// CUSTOM REGISTRATION ROUTES
// ========================

// Custom Registration Routes untuk dokter
Route::get('/register-dokter', [CustomRegisterController::class, 'showDokterForm'])->name('register.dokter');
Route::post('/register-dokter', [CustomRegisterController::class, 'registerDokter'])->name('register.dokter.submit');

// Profile routes - DENGAN EMAIL VERIFICATION
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================
// ADMIN ROUTES 
// ========================
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
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
    
    // Profile Changes Approval Routes
    Route::post('dokter/profile-change/{changeId}/approve', [DokterManagementController::class, 'approveProfileChange'])->name('admin.dokter.approve-profile-change');
    Route::post('dokter/profile-change/{changeId}/reject', [DokterManagementController::class, 'rejectProfileChange'])->name('admin.dokter.reject-profile-change');
    Route::get('dokter/profile-change/{changeId}/detail', [DokterManagementController::class, 'getProfileChangeDetail'])->name('admin.dokter.profile-change-detail');
    
    // Jadwal & Harga Management
    Route::get('dokter/{dokter}/set-jadwal-harga', [DokterManagementController::class, 'showJadwalHargaForm'])->name('dokter.setJadwalHargaForm');
    Route::post('dokter/{dokter}/set-jadwal-harga', [DokterManagementController::class, 'saveJadwalHarga'])->name('dokter.setJadwalHargaSave');

    // Online Status Management
    Route::patch('dokter/{id}/toggle-online', [DokterManagementController::class, 'toggleOnline'])->name('admin.dokter.toggle-online');

    // *** PENGGUNA MANAGEMENT ROUTES ***
    Route::get('pengguna', [PenggunaManagementController::class, 'index'])->name('admin.pengguna.index');
    Route::get('pengguna/create', [PenggunaManagementController::class, 'create'])->name('admin.pengguna.create');
    Route::post('pengguna', [PenggunaManagementController::class, 'store'])->name('admin.pengguna.store');
    Route::get('pengguna/{pengguna}', [PenggunaManagementController::class, 'show'])->name('admin.pengguna.show');
    Route::get('pengguna/{pengguna}/edit', [PenggunaManagementController::class, 'edit'])->name('admin.pengguna.edit');
    Route::put('pengguna/{pengguna}', [PenggunaManagementController::class, 'update'])->name('admin.pengguna.update');
    Route::patch('pengguna/{pengguna}', [PenggunaManagementController::class, 'update'])->name('admin.pengguna.patch');
    Route::delete('pengguna/{pengguna}', [PenggunaManagementController::class, 'destroy'])->name('admin.pengguna.destroy');
    
    // Email Verification routes for pengguna
    Route::patch('pengguna/{pengguna}/verify-email', [PenggunaManagementController::class, 'verifyEmail'])->name('admin.pengguna.verify-email');
    Route::patch('pengguna/{pengguna}/unverify-email', [PenggunaManagementController::class, 'unverifyEmail'])->name('admin.pengguna.unverify-email');
    
    // Suspend/Unsuspend routes for pengguna
    Route::patch('pengguna/{pengguna}/suspend', [PenggunaManagementController::class, 'suspendUser'])->name('admin.pengguna.suspend');
    Route::patch('pengguna/{pengguna}/unsuspend', [PenggunaManagementController::class, 'unsuspendUser'])->name('admin.pengguna.unsuspend');
    
    // Delete photo route for pengguna
    Route::delete('pengguna/{pengguna}/delete-photo', [PenggunaManagementController::class, 'deletePhoto'])->name('admin.pengguna.delete-photo');

    // *** PAYMENT MANAGEMENT - HANYA ADMIN YANG BISA APPROVE/REJECT ***
    Route::get('payments', [AdminPaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('payments/{id}', [AdminPaymentController::class, 'show'])->name('admin.payments.show');
    Route::patch('payments/{id}/approve', [AdminPaymentController::class, 'approve'])->name('admin.payments.approve');
    Route::patch('payments/{id}/reject', [AdminPaymentController::class, 'reject'])->name('admin.payments.reject');
    Route::delete('/payments/{id}', [AdminPaymentController::class, 'destroy'])->name('admin.payments.destroy');


    // Invoice routes
    Route::get('/invoices', [App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('admin.invoices.index');
    Route::get('/invoices/create', [App\Http\Controllers\Admin\InvoiceController::class, 'create'])->name('admin.invoices.create');
    Route::post('/invoices', [App\Http\Controllers\Admin\InvoiceController::class, 'store'])->name('admin.invoices.store');
    Route::get('/invoices/{invoice}', [App\Http\Controllers\Admin\InvoiceController::class, 'show'])->name('admin.invoices.show');
    Route::get('/invoices/{invoice}/download', [App\Http\Controllers\Admin\InvoiceController::class, 'downloadPdf'])->name('admin.invoices.download');
    Route::delete('/invoices/{invoice}', [App\Http\Controllers\Admin\InvoiceController::class, 'destroy'])->name('admin.invoices.destroy');
    
    // API endpoint for autocomplete
    Route::get('/api/completed-consultations', [App\Http\Controllers\Admin\InvoiceController::class, 'getCompletedConsultations'])->name('admin.api.completed-consultations');
});

// ========================
// DOKTER PENDING ROUTES - PERLU EMAIL VERIFICATION TAPI TIDAK PERLU APPROVAL
// ========================
Route::middleware(['auth', 'verified'])->group(function () {
    // Route pending - bisa diakses dokter yang sudah verified email tapi belum approved
    Route::get('dokter/pending', [PendingController::class, 'index'])->name('dokter.pending');
    
    // Route update profile - Langsung dari halaman pending
    Route::put('dokter/update-profile', [PendingController::class, 'updateProfile'])->name('dokter.update-profile');
});

// ========================
// DOKTER ROUTES - PERLU EMAIL VERIFICATION DAN APPROVAL
// ========================
Route::middleware(['auth', 'verified', 'role:dokter', 'check.dokter.approval'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/', [DokterController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [DokterProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [DokterProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [DokterProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete-photo', [DokterProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
    Route::delete('/profile/delete-certificate', [DokterProfileController::class, 'deleteCertificate'])->name('profile.delete-certificate');

    // Online Status
    Route::patch('toggle-online', [OnlineStatusController::class, 'toggle'])->name('toggle-online');

    // *** PAYMENT ROUTES - HANYA UNTUK MELIHAT, TIDAK BISA APPROVE/REJECT ***
    Route::get('payments', [PaymentApprovalController::class, 'index'])->name('payments.index');
    Route::get('payments/{id}', [PaymentApprovalController::class, 'show'])->name('payments.show');

    // Consultation Management
    Route::get('consultations', [DokterConsultationController::class, 'index'])->name('consultations.index');
    Route::get('consultations/{id}', [DokterConsultationController::class, 'show'])->name('consultations.show');
    Route::get('consultations/{id}/chat', [DokterConsultationController::class, 'chat'])->name('consultations.chat');
    Route::patch('consultations/{id}/diagnose', [DokterConsultationController::class, 'diagnose'])->name('consultations.diagnose');
});

// ========================
// PENGGUNA ROUTES - DENGAN EMAIL VERIFICATION
// ========================
Route::middleware(['auth', 'verified', 'role:pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/syarat-ketentuan', function () {
        return view('pengguna.syarat');
    })->name('syarat');
    
    Route::get('/', [PenggunaController::class, 'index'])->name('dashboard');

    // Doctors (keeping original naming: dokters)
    Route::get('dokters', [PenggunaDokterController::class, 'index'])->name('dokters.index');
    Route::get('dokters/all', [PenggunaDokterController::class, 'all'])->name('dokters.all');
    Route::get('dokters/{id}', [PenggunaDokterController::class, 'show'])->name('dokters.show');

    // Consultations
    Route::get('consultations', [PenggunaConsultationController::class, 'index'])->name('consultations.index');
    Route::get('consultations/history', [PenggunaConsultationController::class, 'history'])->name('consultations.history'); 
    Route::get('consultations/create/{dokter_id}', [PenggunaConsultationController::class, 'create'])->name('consultations.create');
    Route::post('consultations', [PenggunaConsultationController::class, 'store'])->name('consultations.store');
    Route::get('consultations/{id}/payment', [PenggunaConsultationController::class, 'payment'])->name('consultations.payment');
    Route::post('consultations/{id}/payment', [PenggunaConsultationController::class, 'processPayment'])->name('consultations.process-payment');
    Route::get('consultations/{id}', [PenggunaConsultationController::class, 'show'])->name('consultations.show');
    Route::get('consultations/{id}/chat', [PenggunaConsultationController::class, 'chat'])->name('consultations.chat');
});

// ========================
// TEST ROUTES (HAPUS DI PRODUCTION)
// ========================
Route::get('/test-edit', function() {
    $user = auth()->user();
    dd([
        'user_id' => $user->id,
        'name' => $user->name,
        'role' => $user->role,
        'email_verified_at' => $user->email_verified_at,
        'has_verified_email' => $user->hasVerifiedEmail(),
        'approval_status' => $user->approval_status,
        'is_approved' => $user->is_approved
    ]);
})->middleware(['auth']);

// Include default Laravel Breeze auth routes (sudah termasuk email verification routes)
require __DIR__.'/auth.php';