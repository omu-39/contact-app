<?php

use Illuminate\Support\Facades\Route;

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

// 仮ルート（ 管理画面(Blade) 作成後に置き換え ）
Route::middleware('auth')->group(function () {
    Route::get('/admin', fn() => '管理画面準備中...')->name('admin');
});