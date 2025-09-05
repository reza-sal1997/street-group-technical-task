<?php

use App\Http\Controllers\HomeownerExportController;
use Illuminate\Support\Facades\Route;

Route::post('/upload', [HomeownerExportController::class, 'import'])->name('homeowners.import');
Route::get('/', function (){
    return view('welcome');
});
