<?php

use App\Http\Controllers\AHPController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\DssSessionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/spk', [PageController::class, 'spk'])->name('spk');
    Route::get('/spk/{session}/alternative', [PageController::class, 'alternative'])->name('alternative');

    Route::get('/weight/{sessionId}', [PageController::class, 'weight'])->name('weight.form');
    Route::post('/ahp/calculate', [AHPController::class, 'calculate'])->name('ahp.calculate');
    Route::post('/spk/{session}/alternative', [AlternativeController::class, 'store'])->name('alternative.store');
    Route::post('/spk/{sessionId}/calculate', [RankingController::class, 'calculate'])->name('ranking.calculate');
    Route::post('/dss-sessions', [DssSessionController::class, 'store'])->name('dss-sessions.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
