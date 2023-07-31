<!DOCTYPE html>
<html>
<head>
    <title>Teste a AluraFlix API</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
            text-align: center;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        code {
            background-color: #f2f2f2;
            padding: 3px;
            font-family: Courier, monospace;
        }

        ul {
            list-style-type: square;
            margin-left: 30px;
        }

        .note {
            color: #4CAF50;
            font-style: italic;
        }

        .api-link {
            color: #007bff;
        }

        .center {
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .api-link {
            color: #007bff;
            font-weight: bold;
            text-decoration: none;
        }

        .api-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="center">Teste a AluraFlix API</h1>
        <p>Seja bem-vindo(a) à AluraFlix API, a plataforma que permite gerenciar categorias e vídeos para compartilhar conteúdo multimídia. Aproveite os recursos da API para criar, atualizar, excluir e visualizar categorias e vídeos de forma simples e rápida. Abaixo estão os passos para testar a API:</p>
        <ol>
            <li><strong>Registro de Usuário:</strong>
                <ul>
                    <li>Comece registrando um novo usuário na API através da rota <code>POST /register</code>.</li>
                    <li>Envie uma solicitação POST para <code>https://7c226xuu6dijldckl3broltmnu0kryki.cell-1-lambda-url.us-east-1.on.aws/api/register</code> com os campos <code>name</code>, <code>email</code> e <code>password</code>.</li>
                    <li>Após o registro, você estará pronto para fazer login.</li>
                </ul>
            </li>
            <li><strong>Login de Usuário:</strong>
                <ul>
                    <li>Faça login na API usando a rota <code>POST /login</code>.</li>
                    <li>Envie uma solicitação POST para <code>https://7c226xuu6dijldckl3broltmnu0kryki.cell-1-lambda-url.us-east-1.on.aws/api/login</code> com os campos <code>email</code> e <code>password</code>.</li>
                    <li>Anote o token de autenticação retornado na resposta.</li>
                </ul>
            </li>
            <li><strong>Autenticação em Rotas Protegidas:</strong>
                <ul>
                    <li>Para acessar rotas protegidas, inclua o token de autenticação no cabeçalho da solicitação com a chave <code>Authorization</code> e o valor <code>Bearer SEU_TOKEN</code>.</li>
                    <li>O token deve ser incluído em todas as solicitações para rotas protegidas.</li>
                </ul>
            </li>
            <li><strong>Listar Vídeos Gratuitos:</strong>
                <ul>
                    <li>Obtenha uma lista de até 5 vídeos gratuitos usando a rota <code>GET /videos-free</code>.</li>
                    <li>Envie uma solicitação GET para <code>https://7c226xuu6dijldckl3broltmnu0kryki.cell-1-lambda-url.us-east-1.on.aws/api/videos-free</code>.</li>
                </ul>
            </li>
            <!-- Restante do conteúdo -->
        </ol>
        <p class="note"><strong>Nota:</strong> Certifique-se de fornecer os parâmetros corretos em cada solicitação. O token de autenticação é obrigatório para acessar rotas protegidas.</p>
        <p class="center"><strong>Teste a API usando o Postman:</strong>
            <ul>
                <li>Você também pode testar a API usando o <a href="https://www.postman.com/" class="api-link">Postman</a>.</li>
            </ul>
        </p>
        <p class="center"><strong>A API está em produção!</strong></p>
        <p>A AluraFlix API está implantada em produção e pode ser acessada em <a href="https://7c226xuu6dijldckl3broltmnu0kryki.cell-1-lambda-url.us-east-1.on.aws/" class="api-link">https://7c226xuu6dijldckl3broltmnu0kryki.cell-1-lambda-url.us-east-1.on.aws/</a>.</p>
        <p class="center">
            <a href="https://7c226xuu6dijldckl3broltmnu0kryki.cell-1-lambda-url.us-east-1.on.aws/" class="btn">Testar Agora!</a>
        </p>
    </div>
</body>
</html>
