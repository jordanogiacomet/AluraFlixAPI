<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Obtém todos os vídeos do banco de dados e retorna-os em formato JSON.
     */
    public function index()
    {
        // Obtém todos os vídeos do banco de dados paginados, com 5 vídeos por página
        $videos = Video::paginate(5);

        // Retorna os vídeos em formato JSON
        return response()->json($videos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * Cria um novo vídeo no banco de dados com base nos dados recebidos na requisição.
     * Retorna uma resposta de sucesso em formato JSON contendo os dados validados do vídeo.
     */
    public function store(Request $request)
    {
        try {
            // Valida os dados recebidos na requisição
            $validatedData = $request->validate([
                'categoriaId' => 'sometimes|required|exists:categories,id',
                'titulo' => 'required|max:30',
                'descricao' => 'required|max:255',
                'url' => 'required|url'
            ]);

            // Se o campo 'categoriaId' não estiver presente na requisição, define o valor padrão como 1
            if (!$request->has('categoriaId')) {
                $validatedData['categoriaId'] = 1;
            }

            // Cria um novo vídeo no banco de dados com os dados validados
            $video = Video::create($validatedData);

            // Retorna os dados validados em formato JSON
            return response()->json($validatedData, 200);
        } catch (ValidationException $e) {
            // Captura a exceção de validação e retorna a resposta com os erros
            return response()->json([
                'errors' => $e->errors(),
            ], 422); // Código HTTP 422 Unprocessable Entity indica erro de validação
        }
    }

    /**
     * Display the specified resource.
     *
     * Busca um vídeo específico com base no ID fornecido no banco de dados.
     * Retorna o vídeo encontrado em formato JSON.
     */
    public function show(string $id)
    {
        // Busca o vídeo com base no ID fornecido no banco de dados
        $video = DB::table('videos')
            ->where('id', $id)
            ->get();

        // Verifica se o vídeo não foi encontrado
        if ($video->isEmpty()) {
            return response()->json([
                'message' => 'Não encontrado.'
            ]);
        }

        // Retorna o vídeo encontrado em formato JSON
        return response()->json($video);
    }

    /**
     * Update the specified resource in storage.
     *
     * Atualiza os campos de um vídeo específico com base nos dados recebidos na requisição.
     * Retorna o vídeo atualizado em formato JSON.
     */
    public function update(Request $request, string $id)
    {
        // Verifica se pelo menos um campo (título, descrição, URL ou categoriaId) foi preenchido para a edição
        if ((!$request->filled('titulo')) && (!$request->filled('descricao')) && (!$request->filled('url'))) {
            return response()->json([
                'message' => 'Pelo menos um campo deve ser preenchido para a edição'
            ], 400);
        }

        // Valida os dados recebidos na requisição
        $validatedData = $request->validate([
            'categoriaId' => 'sometimes|required|exists:categories,id',
            'titulo' => 'max:30',
            'descricao' => 'max:255',
            'url' => 'url'
        ]);

        // Se o campo 'categoriaId' não estiver presente na requisição, define o valor padrão como 1
        if (!$request->has('categoriaId')) {
            $validatedData['categoriaId'] = 1;
        }

        // Busca o vídeo com base no ID fornecido no banco de dados
        $video = Video::find($id);

        // Verifica se o vídeo não foi encontrado
        if ($video === null) {
            return response()->json([
                'message' => 'Não encontrado.'
            ], 404);
        } else {
            // Atualiza os campos do vídeo com base nos dados validados
            if (array_key_exists('categoriaId', $validatedData)) {
                $video->categoriaId = $validatedData['categoriaId'];
            }
            if (array_key_exists('titulo', $validatedData)) {
                $video->titulo = $validatedData['titulo'];
            }
            if (array_key_exists('descricao', $validatedData)) {
                $video->descricao = $validatedData['descricao'];
            }
            if (array_key_exists('url', $validatedData)) {
                $video->url = $validatedData['url'];
            }
            $video->save();

            // Retorna o vídeo atualizado em formato JSON
            return response()->json($video, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * Remove um vídeo específico com base no ID fornecido no banco de dados.
     * Retorna uma resposta de sucesso em formato JSON.
     */
    public function destroy(string $id)
    {
        // Busca o vídeo com base no ID fornecido no banco de dados
        $video = Video::find($id);

        // Verifica se o vídeo não foi encontrado
        if ($video === null) {
            return response()->json([
                'message' => 'Não encontrado.'
            ]);
        } else {
            // Deleta o vídeo do banco de dados
            $video->delete();

            // Retorna uma resposta de sucesso em formato JSON
            return response()->json([
                'message' => 'Success'
            ]);
        }
    }

    /**
     * Search videos by name.
     *
     * Busca vídeos no banco de dados com base no nome fornecido na requisição.
     * Retorna uma lista de vídeos encontrados em formato JSON.
     */
    public function searchVideos(Request $request)
    {
        // Obtém o nome a ser pesquisado a partir dos parâmetros da requisição
        $nome = $request->query('search');

        // Busca vídeos no banco de dados com base no nome fornecido, usando o operador LIKE para pesquisa parcial
        $videos = DB::table('videos')
            ->where('titulo', 'LIKE', '%' . $nome . '%')
            ->get();

        // Verifica se não foram encontrados vídeos com o nome fornecido
        if ($videos->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum vídeo encontrado'
            ], 404);
        }

        // Retorna a lista de vídeos encontrados em formato JSON
        return response()->json($videos, 200);
    }

    /**
     * Get free videos.
     *
     * Obtém uma lista de vídeos associados à categoria de ID 1 (categoria livre).
     * Retorna a lista de vídeos em formato JSON.
     */
    public function getFreeVideos()
    {
        // Busca a categoria com ID 1 (categoria livre) no banco de dados
        $category = Category::find(1);

        // Obtém uma lista de até 5 vídeos associados à categoria livre
        $videos = $category->videos()->take(5)->get();

        // Retorna a lista de vídeos em formato JSON
        return response()->json($videos);
    }
}
