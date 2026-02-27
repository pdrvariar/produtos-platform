<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProdutoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui são registradas as rotas da API da aplicação.
| Todas as rotas neste arquivo recebem automaticamente o prefixo /api
| definido no RouteServiceProvider.
|
*/

Route::prefix('v1')->group(function () {

    // Rota pública para listar produtos (útil para debug ou leitura pública)
    Route::get('produtos', [ProdutoController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Rotas protegidas pelo Keycloak
    |--------------------------------------------------------------------------
    */

    Route::middleware(['keycloak'])->group(function () {

        // CRUD completo de produtos (exclui index pois já está exposto publicamente)
        Route::apiResource('produtos', ProdutoController::class)->except(['index']);

    });

});
