<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;

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

Route::get('/', [ContactController::class, 'create'])->name('contact.create');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/thanks', [ContactController::class, 'store'])->name('contact.store');
Route::get('/thanks', fn() => view('contact.thanks'))->name('contact.thanks');

// 仮ルート（ 管理画面(Blade) 作成後に置き換え ）
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminContactController::class, 'index'])->name('admin.index');
    Route::get('/reset', [AdminContactController::class, 'reset'])->name('admin.reset');
    Route::get('/search', [AdminContactController::class, 'search'])->name('admin.search');
    Route::delete('/delete/{contact}', [AdminContactController::class, 'destroy'])->name('admin.delete');
});