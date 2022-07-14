<?php

use App\Http\Controllers\Web\AppController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\TestsController;

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
Route::get('/{any}', [AppController::class, 'index'])->where('any', '^(?!print|excel|pdf|assets|storage).*$');

Route::get('/login', function () {
    return '';
})->name('login');

/**
 * Route khusus hasil riset
 */
Route::prefix('tests')->group(function () {
    Route::get('/generatePdf', [TestsController::class, 'generatePdf']);
    Route::get('/downloadPdf', [TestsController::class, 'downloadPdf']);
    Route::get('/importExcel', [TestsController::class, 'importExcel']);
    Route::get('/exportExcel', [TestsController::class, 'exportExcel']);
    Route::get('/exportExcelMultipleSheet', [TestsController::class, 'exportExcelMultipleSheet']);
    Route::get('/print', [TestsController::class, 'print']);
    Route::get('/sendMail', [TestsController::class, 'sendMail']);
    Route::get('/generateCache', [TestsController::class, 'generateCache'])->name('generateCache');
    Route::get('/getCache', [TestsController::class, 'getCache'])->name('getCache');
});