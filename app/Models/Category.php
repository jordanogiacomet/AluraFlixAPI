<?php

namespace App\Models;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * Atributos que podem ser preenchidos em massa (mass assignable).
     *
     * @var array
     */
    protected $fillable = ['id', 'titulo', 'cor'];

    /**
     * Define o relacionamento entre a categoria e os vídeos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        // Retorna a relação "hasMany" entre a categoria e os vídeos,
        // onde a chave estrangeira 'categoriaId' na tabela de vídeos
        // corresponde ao atributo 'id' na tabela de categorias.
        return $this->hasMany(Video::class, 'categoriaId', 'id');
    }
}