<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Registra um novo usuário no sistema.
     *
     * Recebe os dados do novo usuário através da requisição e valida-os.
     * Se os dados forem válidos, cria um novo registro de usuário no banco de dados.
     * Retorna uma resposta de sucesso em formato JSON.
     */
    public function register(Request $request)
    {
        try {
            // Valida os dados recebidos na requisição
            $credentials = $request->validate([
                'name' => ['required', Rule::unique('users', 'name')],
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => 'required'
            ]);

            // Criptografa a senha do usuário antes de armazená-la no banco de dados
            $credentials['password'] = bcrypt($credentials['password']);

            // Cria um novo registro de usuário no banco de dados com os dados validados
            $user = User::create($credentials);

            // Realiza o login do usuário recém-criado
            auth()->login($user);

            // Retorna uma resposta de sucesso em formato JSON
            return response()->json([
                'message' => 'Success'
            ], 200);
        } catch (ValidationException $e) {
            // Retorna uma resposta com erros de validação em caso de falha na validação
            return response()->json([
                'errors' => $e->errors()
            ]);
        }
    }

    /**
     * Efetua o login de um usuário no sistema.
     *
     * Recebe os dados de login do usuário através da requisição e valida-os.
     * Se os dados de login forem válidos, tenta autenticar o usuário no sistema.
     * Em caso de sucesso na autenticação, retorna uma resposta de sucesso em formato JSON.
     * Em caso de falha na autenticação, retorna uma resposta de erro em formato JSON.
     */
    public function login(Request $request)
    {
        try {
            // Valida os dados de login recebidos na requisição
            $credentials = $request->validate([
                'name' => 'required',
                'password' => 'required'
            ]);

            // Tenta autenticar o usuário com base nos dados de login fornecidos
            if (auth()->attempt([
                'name' => $credentials['name'],
                'password' => $credentials['password']
            ])) {
                // Regenera o ID da sessão para aumentar a segurança
                $request->session()->regenerate();

                // Retorna uma resposta de sucesso em formato JSON
                return response()->json([
                    'message' => 'Success'
                ], 200);
            } else {
                // Retorna uma resposta de erro em formato JSON caso a autenticação falhe
                return response()->json([
                    'message' => 'Error'
                ], 404);
            }
        } catch (ValidationException $e) {
            // Retorna uma resposta com erros de validação em caso de falha na validação
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Efetua o logout de um usuário autenticado no sistema.
     *
     * Realiza o logout do usuário autenticado, encerrando a sessão.
     * Retorna uma resposta de sucesso em formato JSON.
     */
    public function logout()
    {
        // Realiza o logout do usuário autenticado
        auth()->logout();

        // Retorna uma resposta de sucesso em formato JSON
        return response()->json([
            'Message' => 'Success'
        ], 200);
    }
}
