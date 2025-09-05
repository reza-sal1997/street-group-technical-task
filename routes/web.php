<?php

use App\Http\Controllers\HomeownerImportController;
use Illuminate\Support\Facades\Route;

Route::post('/upload', [HomeownerImportController::class, 'import']);
Route::get('/', function (){
    return view('welcome');
});
