<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtém todos os vídeos do banco de dados
        $videos = Video::all();

        // Retorna os vídeos em formato JSON
        return response()->json($videos);
    }

    /**
     * Store a newly created resource in storage.
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


            if(!$request->has('categoriaId')){
                $validatedData['categoriaId'] = 1;
            }


            // Cria um novo vídeo no banco de dados com os dados validados
            $video = Video::create($validatedData);

            // Retorna os dados validados em formato JSON
            return response()->json($validatedData);
        } catch (ValidationException $e) {
            // Captura a exceção de validação e retorna a resposta com os erros
            return response()->json([
                'errors' => $e->errors(),
            ], 422); // Código HTTP 422 Unprocessable Entity indica erro de validação
        }
    }

    /**
     * Display the specified resource.
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
     */
    public function update(Request $request, string $id)
    {

        if((!$request->filled('titulo')) && (!$request->filled('descricao')) && (!$request->filled('url'))){
            return response()->json([
                'message' => 'Pelo menos um campo deve ser preenchido para a edicão'
            ], 400);
        }



        // Valida os dados recebidos na requisição
        $validatedData = $request->validate([
            'categoriaId' => 'sometimes|required|exists:categories,id',
            'titulo' => 'max:30',
            'descricao' => 'max:255',
            'url' => 'url'
        ]);

        if(!$request->has('categoriaId')){
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
     */
    public function searchVideos(Request $request)
    {

        $nome = $request->query('search');

        $videos = DB::table('videos')
            ->where('titulo', 'LIKE', '%' . $nome . '%')
            ->get();

        if ($videos->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum vídeo encontrado'
            ], 404);
        }

        return response()->json($videos, 200);
    }
}
