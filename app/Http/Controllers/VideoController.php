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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
