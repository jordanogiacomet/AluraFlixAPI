# AluraFlix API

Este é um repositório contendo o código-fonte da AluraFlix API, uma API desenvolvida em Laravel que permite gerenciar categorias e vídeos para uma plataforma de compartilhamento de conteúdo multimídia. A API é construída para ser implantada no Laravel Vapor, fornecendo um ambiente escalável e flexível na nuvem.

## Configuração do Ambiente

Para executar a AluraFlix API localmente ou implantá-la no Laravel Vapor, você precisará configurar o ambiente. Siga as etapas abaixo para configurar o ambiente de desenvolvimento local:

1. **Pré-requisitos:**
   - PHP 8.2 ou superior
   - Composer
   - Docker (caso deseje utilizar o Laravel Vapor com ambientes de contêiner)

2. **Clonando o Repositório:**
   ```
   git clone https://github.com/seu-usuario/aluraflix-api.git
   cd aluraflix-api
   ```

3. **Instalando Dependências:**
   ```
   composer install --no-dev
   ```

4. **Configurando o Banco de Dados:**
   A API utiliza um banco de dados MySQL. Certifique-se de configurar suas credenciais de acesso ao banco de dados no arquivo `.env`:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=aluraflix
   DB_USERNAME=seu-usuario
   DB_PASSWORD=sua-senha
   ```

5. **Executando as Migrações:**
   ```
   php artisan migrate
   ```

6. **Iniciando o Servidor de Desenvolvimento:**
   ```
   php artisan serve
   ```

Agora, a AluraFlix API está em execução localmente e você pode acessar a API em `http://localhost:8000`.

## Utilização do Docker

Para executar a AluraFlix API com o Docker, siga as etapas abaixo:

1. **Pré-requisitos:**
- Docker instalado na máquina

2. **Clonando o Repositório:**
    ```
    git clone https://github.com/seu-usuario/aluraflix-api.git
    cd aluraflix-api
    ```
3. **Construindo a Imagem Docker:**
    ```
   docker-compose up -d --build
    ```
Agora, a AluraFlix API está em execução localmente em um contêiner Docker e você pode acessar a API em `http://localhost:8000`.

## Implantação no Laravel Vapor

Para implantar a AluraFlix API no Laravel Vapor, você precisa seguir as etapas a seguir:

1. **Certifique-se de ter configurado a conta do Laravel Vapor corretamente e ter instalado o Vapor CLI**.

2. **Execute o seguinte comando para implantar a API**:
   ```
   vapor deploy docker-container
   ```

3. **Siga as instruções do Vapor CLI para configurar a implantação no ambiente desejado**.

A API será implantada em um ambiente escalável no Laravel Vapor.

## Testes

O projeto contém testes unitários e de integração. Para executar os testes, use o seguinte comando:

```
php artisan test
```

## Documentação da API

A API possui a seguinte documentação:

- **Categorias:**
  - `GET /api/categories`: Listar todas as categorias
  - `GET /api/categories/{id}`: Obter detalhes de uma categoria específica
  - `POST /api/criar-categoria`: Criar uma nova categoria
  - `PUT /api/atualizar-categoria/{id}`: Atualizar uma categoria existente
  - `DELETE /api/deletar-categoria/{id}`: Excluir uma categoria

- **Vídeos:**
  - `GET /api/videos`: Listar todos os vídeos
  - `GET /api/videos/{id}`: Obter detalhes de um vídeo específico
  - `POST /api/criar-video`: Criar um novo vídeo
  - `PUT /api/atualizar-video/{id}`: Atualizar um vídeo existente
  - `DELETE /api/deletar-video/{id}`: Excluir um vídeo

## Contribuição

Contribuições são bem-vindas! Se você encontrar algum problema ou tiver melhorias para propor, sinta-se à vontade para abrir uma [issue](https://github.com/seu-usuario/aluraflix-api/issues) ou enviar um [pull request](https://github.com/seu-usuario/aluraflix-api/pulls).

## Licença

Este projeto é licenciado sob a [MIT License](https://opensource.org/licenses/MIT). Sinta-se à vontade para usá-lo e modificá-lo de acordo com suas necessidades.
