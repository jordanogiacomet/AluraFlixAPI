<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Definindo uma nova classe de migração anônima que estende a classe Migration do Laravel
return new class extends Migration
{
    /**
     * Executa as migrações para criar a tabela "videos".
     */
    public function up(): void
    {
        // Utiliza o Schema Builder do Laravel para criar a tabela "videos"
        Schema::create('videos', function (Blueprint $table) {
            $table->id(); // Cria um campo de ID autoincrementável
            $table->unsignedBigInteger('categoriaId'); // Cria um campo inteiro sem sinal para a chave estrangeira "categoriaId"
            $table->foreign('categoriaId')->references('id')->on('categories')->onDelete('cascade');
            // Define uma chave estrangeira para a coluna "categoriaId" que faz referência à coluna "id" da tabela "categories" e 
            // define a ação de cascata "onDelete('cascade')", o que significa que, se uma categoria for excluída, 
            // todos os vídeos associados a ela também serão excluídos.
            
            $table->string('titulo'); // Cria um campo de texto para o título do vídeo
            $table->text('descricao'); // Cria um campo de texto longo para a descrição do vídeo
            $table->string('url'); // Cria um campo de texto para a URL do vídeo
            $table->timestamps(); // Cria campos "created_at" e "updated_at" para controlar as datas de criação e atualização
        });
    }

    /**
     * Reverte as migrações, removendo a tabela "videos".
     */
    public function down(): void
    {
        // Utiliza o Schema Builder do Laravel para remover a chave estrangeira "categoriaId"
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['categoriaId']);
        });

        // Utiliza o Schema Builder do Laravel para remover a tabela "videos", caso ela exista
        Schema::dropIfExists('videos');
    }
};
