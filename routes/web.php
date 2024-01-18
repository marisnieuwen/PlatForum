<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\ThreadController::class, 'index'])->name('threads.index');

Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/threads/{thread}/like', [LikeController::class, 'like'])->name('threads.like');
    Route::delete('/threads/{thread}/unlike', [LikeController::class, 'unlike'])->name('threads.unlike');
    Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('threads.edit');
    Route::put('/threads/{thread}', [ThreadController::class, 'update'])->name('threads.update');
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/categories', [AdminController::class, 'manageCategories'])->name('admin.categories');
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
});
