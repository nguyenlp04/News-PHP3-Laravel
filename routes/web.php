<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;

Route::get('/', [HomeController::class, 'index']);

// Route::get('/article', [ArticleController::class, 'index']);
Route::get('/article/{id}', [ArticleController::class, 'articleDetail']);

