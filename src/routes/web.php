<?php

use Illuminate\Support\Facades\Route;
use Webid\CmsNova\App\Http\Controllers\PreviewController;
use Webid\CmsNova\App\Http\Controllers\SitemapController;
use Webid\CmsNova\App\Http\Controllers\PageController;

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

Route::group([], function () {
    // Redirect homepage without lang
    Route::get('/', [PageController::class, 'rootPage']);

    Route::group([
        'prefix' => '{lang}',
        'middleware' => [
            'web',
            'pages',
            'language',
            'check-language-exist',
        ],
    ], function () {
        // Homepage
        Route::get('/', [PageController::class, 'index'])->name('home');
    });
});

Route::group([
    'middleware' => ['web'],
], function () {
    Route::get('/preview/{token}', [PreviewController::class, 'preview'])->name('preview');
});

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// /!\ Cette route doit TOUJOURS être la dernière
Route::middleware([
    'web',
    'pages',
    'language',
    'redirect-to-homepage',
    'redirect-parent-child',
])->group(function () {
    Route::fallback([PageController::class, 'show']);
});
