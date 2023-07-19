<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // Valida os dados recebidos na requisição
        $validatedData = $request->validate([
            'titulo' => 'required|max:30',
            'descricao' => 'required|max:255',
            'url' => 'required|url'
        ]);

        // Cria um novo vídeo no banco de dados com os dados validados
        $video = Video::create($validatedData);

        // Retorna os dados validados em formato JSON
        return response()->json($validatedData);

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
        // Valida os dados recebidos na requisição
        $validatedData = $request->validate([
            'titulo' => 'max:30',
            'descricao' => 'max:255',
            'url' => 'url'
        ]);

        // Busca o vídeo com base no ID fornecido no banco de dados
        $video = Video::find($id);

        // Verifica se o vídeo não foi encontrado
        if ($video === null) {
            return response()->json([
                'message' => 'Não encontrado.'
            ]);
        } else {
            // Atualiza os campos do vídeo com base nos dados validados
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
            return response()->json($video);
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
}
