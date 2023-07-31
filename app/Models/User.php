<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * Atributos que podem ser preenchidos em massa (mass assignable).
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];
}