<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Definindo uma nova classe de migração anônima que estende a classe Migration do Laravel
return new class extends Migration
{
    /**
     * Executa as migrações para criar a tabela "users".
     */
    public function up(): void
    {
        // Utiliza o Schema Builder do Laravel para criar a tabela "users"
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Cria um campo de ID autoincrementável
            $table->string('name'); // Cria um campo de texto para o nome do usuário
            $table->string('email')->unique(); // Cria um campo de texto para o email do usuário, com valor único
            $table->string('password'); // Cria um campo de texto para a senha do usuário
            $table->timestamps(); // Cria campos "created_at" e "updated_at" para controlar as datas de criação e atualização
        });
    }

    /**
     * Reverte as migrações, removendo a tabela "users".
     */
    public function down(): void
    {
        // Utiliza o Schema Builder do Laravel para remover a tabela "users", caso ela exista
        Schema::dropIfExists('users');
    }
};
