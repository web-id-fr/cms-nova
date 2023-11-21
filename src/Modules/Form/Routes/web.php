<?php

use Illuminate\Support\Facades\Route;
use Webid\CmsNova\Modules\Form\Http\Controllers\CsrfController;
use Webid\CmsNova\Modules\Form\Http\Controllers\FormController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/csrf', [CsrfController::class, 'index'])->name('csrf.index');

Route::group([
    'prefix' => '{lang}/form',
    'middleware' => ['anti-spam', 'language', 'check-language-exist'],
], function () {
    Route::post('/send', [FormController::class, 'handle'])->name('send.form');
});
