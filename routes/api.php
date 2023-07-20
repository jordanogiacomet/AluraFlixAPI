<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Vídeos

Route::get('/videos', [VideoController::class, 'index']);
Route::get('/videos/{id}', [VideoController::class, 'show']);
Route::post('/criar-video', [VideoController::class, 'store']);
Route::put('/atualizar-video/{id}', [VideoController::class, 'update']);
Route::delete('/deletar-video/{id}', [VideoController::class, 'destroy']);
Route::get('/buscar-videos', [VideoController::class, 'searchVideos']);

// Categorias

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::post('/criar-categoria', [CategoryController::class, 'store']);
Route::put('/atualizar-categoria/{id}', [CategoryController::class, 'update']);
Route::delete('/deletar-categoria/{id}', [CategoryController::class, 'destroy']);
Route::get('/categories/{id}/videos', [CategoryController::class, 'indexVideosbyCategory']);