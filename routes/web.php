<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    return redirect()->route('dashboard');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Route untuk Pengaturan
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Route untuk User
    Route::prefix('user')->group(function () {
        Volt::route('/', 'user.index')->name('user.index');
        Volt::route('/create', 'user.create')->name('user.create');
        Volt::route('/edit/{id}', 'user.edit')->name('user.edit');
    });

    // Route untuk Customer
    Route::prefix('penyewa')->group(function () {
        Volt::route('/', 'penyewa.index')->name('penyewa.index');
        Volt::route('/create', 'penyewa.create')->name('penyewa.create');
        Volt::route('/edit/{id}', 'penyewa.edit')->name('penyewa.edit');
    });

    // Route untuk iPhone Series
    Route::prefix('room')->group(function () {
        Volt::route('/', 'room.index')->name('room.index');
        Volt::route('/create', 'room.create')->name('room.create');
        Volt::route('/edit/{id}', 'room.edit')->name('room.edit');
    });

    // Route untuk Rental
    Route::prefix('transaksi')->group(function () {
        Volt::route('/', 'transaksi.index')->name('transaksi.index');
        Volt::route('/create', 'transaksi.create')->name('transaksi.create');
        Volt::route('/edit/{id}', 'transaksi.edit')->name('transaksi.edit');
    });
});

require __DIR__ . '/auth.php';