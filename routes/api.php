<?php
use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\BukuController;

// Kategori Routes
Route::get('kategoris', [KategoriController::class, 'index']);
Route::post('kategoris', [KategoriController::class, 'store']);

// Buku Routes
Route::get('bukus', [BukuController::class, 'index']);
Route::post('bukus', [BukuController::class, 'store']);
Route::get('bukus/search', [BukuController::class, 'search']);
Route::get('bukus/{id}', [BukuController::class, 'show']);
Route::put('bukus/{id}', [BukuController::class, 'update']);
Route::delete('bukus/{id}', [BukuController::class, 'destroy']);

// Endpoint Route

