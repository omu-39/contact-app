<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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

Route::get('/', [ContactController::class, 'create']);
Route::post('/', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/confirm', [ContactController::class, 'store'])->name('contact.store');

// 仮ルート（ 管理画面(Blade) 作成後に置き換え ）
Route::middleware('auth')->group(function () {
    Route::get('/admin', fn() => view('admin.contacts'))->name('admin');
});