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
        $videos = Video::all();

        return response()->json($videos);
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|max:30',
            'descricao' => 'required|max:255',
            'url' => 'required|url'
        ]);

        $video = Video::create($validatedData);

        return response()->json($validatedData);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $video = DB::table('videos')
                        ->where('id', $id)
                        ->get();

        if($video->isEmpty()){
            return response()->json([
                'message' => 'Não encontrado.'
            ]);
        }

            return response()->json($video);
        }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'titulo' => 'max:30',
            'descricao' => 'max:255',
            'url' => 'url'
        ]);

        $video = Video::find($id);

        if($video === null){
            return response()->json([
                'message' => 'Não encontrado.'
            ]);
            } else {
            
            if(array_key_exists('titulo', $validatedData)){
                $video->titulo = $validatedData['titulo'];
            }
            if(array_key_exists('descricao', $validatedData)){
                $video->descricao = $validatedData['descricao'];
            }
            if(array_key_exists('url', $validatedData)){
                $video->url = $validatedData['url'];
            }
            $video->save();
            return response()->json($video);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
