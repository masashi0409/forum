<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\InstagramController;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

// お問い合わせ
Route::get('contact/create', [ContactController::class, 'create'])->name('contact.create');
Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');

Route::middleware(['verified'])->group(function(){
    // 投稿
    Route::get('poat/mypost', [PostController::class, 'mypost'])->name('post.mypost');
    Route::get('post/mycomment', [PostController::class, 'mycomment'])->name('post.mycomment');
    Route::resource('post', PostController::class);
    Route::post('post/comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware(['auth', 'can:admin'])->group(function () {
        Route::get('/profile/index', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('profile/adminedit/{user}', [ProfileController::class, 'adminedit'])->name('profile.adminedit');
        Route::patch('profile/adminupdate/{user}', [ProfileController::class, 'adminupdate'])->name('profile.adminupdate');
        Route::patch('roles/{user}/attach', [RoleController::class, 'attach'])->name('role.attach');
        Route::patch('roles/{user}/detach', [RoleController::class, 'detach'])->name('role.detach');
    });
});

// instagram
Route::get('/instagram', [InstagramController::class, 'index'])->name('instagram.index');
