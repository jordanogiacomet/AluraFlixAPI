<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    /**
     * Atributos que podem ser preenchidos em massa (mass assignable).
     *
     * @var array
     */
    protected $fillable = ['categoriaId', 'titulo', 'descricao', 'url'];
}