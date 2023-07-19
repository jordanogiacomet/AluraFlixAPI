<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtém todas as categorias do banco de dados
        $categories = Category::all();

        // Retorna as categorias em formato JSON
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida os dados recebidos na requisição
        $validatedData = $request->validate([
            'titulo' => 'required|max:15',
            'cor' => 'required|max:15'
        ]);

        // Cria uma nova categoria no banco de dados com os dados validados
        $category = Category::create($validatedData);

        // Retorna os dados validados em formato JSON
        return response()->json($validatedData);
    }

    /**
     * Display the specified resource.
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
     */
    public function update(Request $request, string $id)
    {
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
            ]);
        } else {
            // Atualiza os campos da categoria com base nos dados validados
            if (array_key_exists('titulo', $validatedData)) {
                $category->titulo = $validatedData['titulo'];
            }
            if (array_key_exists('cor', $validatedData)) {
                $category->cor = $validatedData['cor'];
            }
            $category->save();
            
            // Retorna a categoria atualizada em formato JSON
            return response()->json($category);
        }
    }

    /**
     * Remove the specified resource from storage.
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
}
