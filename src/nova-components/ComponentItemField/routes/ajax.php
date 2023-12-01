<?php

use Illuminate\Support\Facades\Route;
use Webid\ComponentItemField\Http\Controllers\ComponentItemFieldController;
use Webid\ComponentItemField\Http\Controllers\PreviewItemFieldController;

/*
|--------------------------------------------------------------------------
| PreviewItemField AJAX Routes
|--------------------------------------------------------------------------
|
*/

Route::post('/store-preview-data', [PreviewItemFieldController::class, 'storeTemplateData'])->name('store.preview');
Route::get('/child-component-data', [ComponentItemFieldController::class, 'getChildComponentData'])->name('get.child_component_data');
