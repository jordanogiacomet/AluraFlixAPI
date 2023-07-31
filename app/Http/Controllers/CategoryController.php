<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Retorna uma lista paginada de todas as categorias do banco de dados em formato JSON.
     */
    public function index()
    {
        // Obtém todas as categorias do banco de dados
        $categories = Category::paginate(5);

        // Retorna as categorias em formato JSON
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * Armazena uma nova categoria no banco de dados com os dados recebidos na requisição.
     * Retorna os dados validados da categoria em formato JSON.
     */
    public function store(Request $request)
    {
        try {
            // Valida os dados recebidos na requisição
            $validatedData = $request->validate([
                'titulo' => 'required|max:15',
                'cor' => 'required|max:15'
            ]);

            // Cria uma nova categoria no banco de dados com os dados validados
            $category = Category::create($validatedData);

            // Caso o ID da categoria seja 1, define o título como 'Livre' e salva a categoria
            if ($category->id == 1) {
                $category->titulo = 'Livre';
                $category->save();
            }

            // Retorna os dados validados da categoria em formato JSON
            return response()->json($validatedData);
        } catch (ValidationException $e) {
            // Retorna uma resposta com erros de validação em caso de falha na validação
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * Busca uma categoria específica com base no ID fornecido no banco de dados.
     * Retorna a categoria encontrada em formato JSON.
     */
    public function show(string $id)
    {
        // Busca a categoria com base no ID fornecido no banco de dados
        $category = DB::table('categories')
            ->where('id', $id)
            ->get();

        // Verifica se a categoria não foi encontrada
        if ($category->isEmpty()) {
            return response()->json([
                'message' => 'Não encontrado.'
            ]);
        }

        // Retorna a categoria encontrada em formato JSON
        return response()->json($category);;
    }

    /**
     * Update the specified resource in storage.
     *
     * Atualiza os campos de uma categoria específica com base nos dados recebidos na requisição.
     * Retorna a categoria atualizada em formato JSON.
     */
    public function update(Request $request, string $id)
    {
        // Verifica se a requisição não possui dados para atualização
        if (empty($request->all())) {
            return response()->json([
                'message' => 'Não foi possível editar essa categoria'
            ], 400);
        }

        try {
            // Valida os dados recebidos na requisição
            $validatedData = $request->validate([
                'titulo' => 'max:15',
                'cor' => 'max:15'
            ]);

            // Busca a categoria com base no ID fornecido no banco de dados
            $category = Category::find($id);

            // Verifica se a categoria não foi encontrada
            if ($category === null) {
                return response()->json([
                    'message' => 'Não encontrado.'
                ], 404);
            } else {
                // Atualiza os campos da categoria com base nos dados validados
                if (array_key_exists('titulo', $validatedData) && ($category->id != 1)) {
                    $category->titulo = $validatedData['titulo'];
                }
                if (array_key_exists('cor', $validatedData)) {
                    $category->cor = $validatedData['cor'];
                }
                $category->save();

                // Caso o ID da categoria seja 1, retorna uma mensagem informando que o título não pode ser atualizado
                if ($category->id == 1) {
                    return response()->json([
                        'message' => 'O título da categoria com id = 1 não pode ser atualizado',
                        'category' => $category
                    ]);
                }

                // Retorna a categoria atualizada em formato JSON
                return response()->json($category);
            }
        } catch (ValidationException $e) {
            // Retorna uma resposta com erros de validação em caso de falha na validação
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * Remove uma categoria específica com base no ID fornecido no banco de dados.
     * Retorna uma resposta de sucesso em formato JSON.
     */
    public function destroy(string $id)
    {
        // Busca a categoria com base no ID fornecido no banco de dados
        $category = Category::find($id);

        // Verifica se a categoria não foi encontrada
        if ($category === null) {
            return response()->json([
                'message' => 'Não encontrado.'
            ]);
        } else {
            // Deleta a categoria do banco de dados
            $category->delete();

            // Retorna uma resposta de sucesso em formato JSON
            return response()->json([
                'message' => 'Success'
            ]);
        }
    }

    /**
     * Display a listing of videos by category.
     *
     * Busca todos os vídeos associados a uma categoria específica com base no ID fornecido.
     * Retorna uma lista de vídeos em formato JSON.
     */
    public function indexVideosbyCategory(string $id)
    {
        // Busca a categoria com base no ID fornecido no banco de dados
        $category = Category::find($id);

        // Verifica se a categoria não foi encontrada
        if (!$category) {
            return response()->json([
                'message' => 'Categoria não encontrada.'
            ], 404);
        }

        // Obtém os vídeos associados à categoria
        $videos = $category->videos;

        // Retorna a lista de vídeos em formato JSON
        return response()->json($videos, 200);
    }
}