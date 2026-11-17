<?php
// index.php
session_start();
require_once 'classes.php';

// Inicializa a conexão com o banco de dados
$database = new Database();
$db = $database->conectar();

// Captura a rota
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$metodo = $_SERVER['REQUEST_METHOD'];

$erro = "";
$mensagem = "";

switch (true) {
    case ($uri === '/'):
        header("Location: " . (isset($_SESSION['logado']) ? "/painel" : "/login"));
        exit;

    // ROTA DE LOGIN
    case ($uri === '/login' && $metodo === 'GET'):
        require 'login.php';
        break;

    case ($uri === '/login' && $metodo === 'POST'):
        $usuario_obj = new Usuario($db); // Instancia o objeto Usuario
        $dados_usuario = $usuario_obj->autenticar($_POST['usuario'], $_POST['senha']);

        if ($dados_usuario) {
            $_SESSION['logado'] = true;
            $_SESSION['nome'] = $dados_usuario['nome'];
            header("Location: /painel");
            exit;
        } else {
            $erro = "Credenciais inválidas!";
            require 'login.php';
        }
        break;

    // ROTA DO PAINEL (Exibe o formulário de cadastro)
    case ($uri === '/painel' && $metodo === 'GET'):
        if (!isset($_SESSION['logado'])) {
            header("Location: /login");
            exit;
        }
        require 'painel.php';
        break;

    // ROTA PARA SALVAR O PRODUTO
    case ($uri === '/produto/salvar' && $metodo === 'POST'):
        if (!isset($_SESSION['logado'])) {
            header("Location: /login");
            exit;
        }

        $produto_obj = new Produto($db); // Instancia o objeto Produto
        
        $nome = trim($_POST['nome']);
        $categoria = trim($_POST['categoria']);
        $descricao = trim($_POST['descricao']);
        $preco = $_POST['preco'];

        if ($produto_obj->cadastrar($nome, $categoria, $descricao, $preco)) {
            $mensagem = "<p style='color: green;'>Produto salvo com sucesso!</p>";
        } else {
            $mensagem = "<p style='color: red;'>Erro ao salvar o produto.</p>";
        }
        
        require 'painel.php'; // Recarrega o painel mostrando a mensagem
        break;

    // ROTA DE LOGOUT
    case ($uri === '/logout'):
        session_destroy();
        header("Location: /login");
        exit;

    default:
        http_response_code(404);
        echo "<h1>Página não encontrada!</h1>";
        break;
}
?>