<?php

use App\Http\Controllers\Api\Master\BooksController;
use App\Http\Controllers\Api\Master\BorrowController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\RoleController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    /**
     * CRUD user
     */
    Route::get('/users', [UserController::class, 'index'])->middleware(['web', 'auth.api:user_view']);
    Route::get('/users/{id}', [UserController::class, 'show'])->middleware(['web', 'auth.api:user_view']);
    Route::post('/users', [UserController::class, 'store'])->middleware(['web', 'auth.api:user_create']);
    Route::put('/users', [UserController::class, 'update'])->middleware(['web', 'auth.api:user_update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware(['web', 'auth.api:user_delete']);

    /**
     * CRUD role / hak akses
     */
    Route::get('/roles', [RoleController::class, 'index'])->middleware(['web', 'auth.api']);
    Route::get('/roles/{id}', [RoleController::class, 'show'])->middleware(['web', 'auth.api:roles_view']);
    Route::post('/roles', [RoleController::class, 'store'])->middleware(['web', 'auth.api:roles_create']);
    Route::put('/roles', [RoleController::class, 'update'])->middleware(['web', 'auth.api:roles_update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->middleware(['web', 'auth.api:roles_delete']);

    /**
     * CRUD borrow
     */
    Route::get('/borrows', [BorrowController::class, 'index'])->middleware(['web', 'auth.api:borrow_view']);
    Route::get('/borrows/user', [BorrowController::class, 'getByUser'])->middleware(['web', 'auth.api:borrow_view']);
    Route::get('/borrows/{id}', [BorrowController::class, 'show'])->middleware(['web', 'auth.api:borrow_view']);
    Route::post('/borrows', [BorrowController::class, 'store'])->middleware(['web', 'auth.api:borrow_create']);
    Route::put('/borrows', [BorrowController::class, 'update'])->middleware(['web', 'auth.api:borrow_update']);
    // Route::delete('/borrows/{id}', [BorrowController::class, 'destroy'])->middleware(['web', 'auth.api:borrow_delete']);

    /**
     * CRUD books
     */
    Route::get('/books', [BooksController::class, 'index'])->middleware(['web', 'auth.api:books_view']);
    Route::get('/books/{id}', [BooksController::class, 'show'])->middleware(['web', 'auth.api:books_create']);
    Route::post('/books', [BooksController::class, 'store'])->middleware(['web', 'auth.api:books_create']);
    Route::put('/books', [BooksController::class, 'update'])->middleware(['web', 'auth.api:books_update']);
    Route::delete('/books/{id}', [BooksController::class, 'destroy'])->middleware(['web', 'auth.api:books_delete']);
    Route::put('/books/borrow', [BooksController::class, 'borrowing'])->middleware(['web', 'auth.api:books_view']);



    /**
     * Route khusus authentifikasi
     */
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile'])->middleware(['auth.api']);
        Route::get('/csrf', [AuthController::class, 'csrf'])->middleware(['web']);
    });
});

Route::get('/', function () {
    return response()->failed(['Endpoint yang anda minta tidak tersedia']);
});

/**
 * Jika Frontend meminta request endpoint API yang tidak terdaftar
 * maka akan menampilkan HTTP 404
 */
Route::fallback(function () {
    return response()->failed(['Endpoint yang anda minta tidak tersedia']);
});