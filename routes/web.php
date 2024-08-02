<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PHPMailerController;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('index');
});

Route::get('/admin/dashboard', function () {
    return view('/admin/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('/admin/article',ArticleController::class);
Route::post('/admin/article/status/{id}', [ArticleController::class, 'updateStatus'])->name('admin.article.status');


Route::resource('/admin/category',CategoryController::class);
Route::post('/admin/category/status/{id}', [CategoryController::class, 'updateStatus'])->name('admin.category.status');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('send-email',[PHPMailerController::class, 'index'])->name('send.email');
Route::post('send-email',[PHPMailerController::class, 'store'])->name('send.email.post');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
