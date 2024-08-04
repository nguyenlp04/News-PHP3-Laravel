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
use App\Http\Controllers\CommentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;



Route::get('/', [HomeController::class, 'index']);
Route::get('/category', [CategoryController::class,'showPageCategory']);
// Route::get('/Categories',[CategoryController::class,'index']);

Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::get('/article/{id}', [ArticleController::class, 'articleDetail'])->name('article.detail');

Route::post('/Comment',[CommentController::class,'addComment'])->name('comment');




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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');



Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');



Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware(['admin', 'auth', 'verified'])->prefix('admin')->group(function () {

    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    
    Route::resource('/article', ArticleController::class);
    Route::post('/article/status/{id}', [ArticleController::class, 'updateStatus'])->name('admin.article.status');
    
    Route::resource('/category', CategoryController::class);
    Route::post('/category/status/{id}', [CategoryController::class, 'updateStatus'])->name('admin.category.status');
    
    Route::resource('/comment', CommentController::class);
});
