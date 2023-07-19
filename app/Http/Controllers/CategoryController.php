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
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $validatedData = $request->validate([
            'titulo' => 'required|max:15',
            'cor' => 'required|max:15'
        ]);

        $category = Category::create($validatedData);

        return response()->json($validatedData);
    }

    /**
     * Display the specified resource.
     */

     public function show(string $id){
        $category = DB::table('categories')
                        ->where('id', $id)
                        ->get();


        if($category->isEmpty()){
            return response()->json([
                'message' => 'Não encontrado.'
            ]);
        }

        return response()->json($category);;
     }

}
