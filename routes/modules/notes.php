<?php

use App\Http\Controllers\NotesController;
use Illuminate\Support\Facades\Route;

Route::controller(NotesController::class)->group(function () {
    Route::get('', 'index');
    Route::post('/', 'store');
    Route::put('{nota}', 'update');
    Route::delete('{nota}', 'destroy');

    Route::post('{nota}/archive', 'archive');
    Route::get('archived', 'archived');
});
