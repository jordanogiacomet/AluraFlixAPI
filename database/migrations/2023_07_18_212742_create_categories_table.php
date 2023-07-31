<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Definindo uma nova classe de migração anônima que estende a classe Migration do Laravel
return new class extends Migration
{
    /**
     * Executa as migrações para criar a tabela "categories".
     */
    public function up(): void
    {
        // Utiliza o Schema Builder do Laravel para criar a tabela "categories"
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Cria um campo de ID autoincrementável
            $table->string('titulo'); // Cria um campo de texto para o título da categoria
            $table->string('cor'); // Cria um campo de texto para a cor da categoria
            $table->timestamps(); // Cria campos "created_at" e "updated_at" para controlar as datas de criação e atualização
        });
    }

    /**
     * Reverte as migrações, removendo a tabela "categories".
     */
    public function down(): void
    {
        // Utiliza o Schema Builder do Laravel para remover a tabela "categories", caso ela exista
        Schema::dropIfExists('categories');
    }
};

