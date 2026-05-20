<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthorizationController::class, 'dashboard'])->name('dashboard');

    Route::get('/safe/responsavel', [AuthorizationController::class, 'responsavelDashboard'])->name('safe.responsavel.index');
    Route::get('/safe/responsavel/novo', [AuthorizationController::class, 'create'])->name('safe.responsavel.create');
    Route::post('/safe/responsavel', [AuthorizationController::class, 'store'])->name('safe.responsavel.store');

    Route::get('/safe/professor', [AuthorizationController::class, 'professorDashboard'])->name('safe.professor.index');
    Route::patch('/safe/professor/{authorization}/aprovar', [AuthorizationController::class, 'approve'])->name('safe.professor.approve');
    Route::patch('/safe/professor/{authorization}/negar', [AuthorizationController::class, 'deny'])->name('safe.professor.deny');

    Route::get('/safe/portaria', [AuthorizationController::class, 'portariaDashboard'])->name('safe.portaria.index');
    Route::patch('/safe/portaria/{authorization}/confirmar', [AuthorizationController::class, 'confirm'])->name('safe.portaria.confirm');
    Route::patch('/safe/portaria/{authorization}/negar', [AuthorizationController::class, 'deny'])->name('safe.portaria.deny');
});
