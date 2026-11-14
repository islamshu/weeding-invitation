<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\PublicInvitationController;
use App\Http\Controllers\WeddingInvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketingController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/invitations/create', [WeddingInvitationController::class, 'create'])->name('invitations.create');
    Route::post('/invitations', [WeddingInvitationController::class, 'store'])->name('invitations.store');
    Route::get('/invitations/{invitation}/edit', [WeddingInvitationController::class, 'edit'])->name('invitations.edit');
    Route::put('/invitations/{invitation}', [WeddingInvitationController::class, 'update'])->name('invitations.update');
    Route::delete('/invitations/{invitation}', [WeddingInvitationController::class, 'destroy'])->name('invitations.destroy');
    Route::get('/invitations/{invitation}/preview', [WeddingInvitationController::class, 'preview'])->name('invitations.preview');
    Route::post('/invitations/{invitation}/publish', [WeddingInvitationController::class, 'publish'])->name('invitations.publish');
    Route::post('/invitations/{invitation}/unpublish', [WeddingInvitationController::class, 'unpublish'])->name('invitations.unpublish');
});

Route::get('/w/{slug}/calendar.ics', [PublicInvitationController::class, 'calendar'])
    ->where('slug', '[A-Za-z0-9-]+')
    ->name('invitations.calendar');

Route::get('/w/{slug}', [PublicInvitationController::class, 'show'])
    ->where('slug', '[A-Za-z0-9-]+')
    ->name('invitations.public');
