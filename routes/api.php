<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\RowController;
use Illuminate\Support\Facades\Broadcast;

Route::post('/upload-excel', [ExcelController::class, 'upload'])->name('api.excel.upload');
Route::get('/rows', action: [RowController::class, 'index']);