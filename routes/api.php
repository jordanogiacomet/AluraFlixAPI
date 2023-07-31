<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar as rotas da API para a sua aplicação.
| Essas rotas são carregadas pelo RouteServiceProvider e todas elas
| serão atribuídas ao grupo de middleware "api". Faça algo incrível!
|
*/

// Rota para obter informações do usuário autenticado usando o middleware Sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rota para obter todos os vídeos gratuitos
Route::get('/videos-free', [VideoController::class, 'getFreeVideos']);

// Grupo de rotas protegidas pelo middleware de autenticação
Route::middleware('auth')->group(function () {
    
    // Rotas para operações de Vídeos

    Route::get('/videos', [VideoController::class, 'index']);
    Route::get('/videos/{id}', [VideoController::class, 'show']);
    Route::post('/criar-video', [VideoController::class, 'store']);
    Route::put('/atualizar-video/{id}', [VideoController::class, 'update']);
    Route::delete('/deletar-video/{id}', [VideoController::class, 'destroy']);
    Route::get('/buscar-videos', [VideoController::class, 'searchVideos']);

    // Rotas para operações de Categorias

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::post('/criar-categoria', [CategoryController::class, 'store']);
    Route::put('/atualizar-categoria/{id}', [CategoryController::class, 'update']);
    Route::delete('/deletar-categoria/{id}', [CategoryController::class, 'destroy']);
    Route::get('/categories/{id}/videos', [CategoryController::class, 'indexVideosbyCategory']);

});

// Rotas públicas de usuários

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);

// Rota para exibir uma mensagem de erro para usuários não autenticados
Route::get('/error-message', function () {
    return response()->json([
        'message' => 'Usuário não autenticado'
    ]);
})->name('error-message');