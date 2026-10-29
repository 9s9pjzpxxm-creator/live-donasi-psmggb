<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;

// URL Utama (/) sekarang langsung menampilkan Live Dashboard & QR Code DOKU
Route::get('/', [DonationController::class, 'dashboard']);

// (Opsional) Jika masih ingin menyediakan jalur /dashboard terpisah yang mengarah ke fungsi yang sama
Route::get('/dashboard', [DonationController::class, 'dashboard'])->name('donation.dashboard');

// URL untuk menerima laporan status otomatis dari DOKU (Webhook/Callback)
Route::post('/doku-callback', [DonationController::class, 'callback']);

// Halaman setelah donasi selesai
Route::get('/donation/success/{order_id}', [DonationController::class, 'successPage'])->name('donation.success');