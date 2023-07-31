<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * Obtém o caminho para o qual o usuário deve ser redirecionado quando não estiver autenticado.
     * 
     * Esse método é chamado quando o middleware determina que o usuário não está autenticado e tenta acessar
     * uma rota que requer autenticação. Ele verifica se a requisição é uma requisição JSON, e se for, não faz
     * o redirecionamento, permitindo que o cliente decida como lidar com a situação. Caso contrário, retorna o
     * caminho para a rota "error-message", que deve ser configurada no arquivo de rotas da aplicação.
     * 
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('error-message');
    }
}