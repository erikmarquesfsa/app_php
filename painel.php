<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel OOP</title>
</head>
<body>
    <div style="float: right;">
        Olá, <strong><?= htmlspecialchars($_SESSION['nome']) ?></strong> | 
        <a href="/logout">Sair</a>
    </div>
    
    <h2>Painel de Gestão - Cafeteria</h2>
    <hr>

    <h3>Cadastrar Novo Produto</h3>
    
    <!-- Exibe mensagem de sucesso ou erro do cadastro -->
    <?= $mensagem ?? '' ?>

    <form method="POST" action="/produto/salvar">
        <label>Nome do Produto:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Categoria:</label><br>
        <select name="categoria" required>
            <option value="Cafe">Café</option>
            <option value="Doce">Doce</option>
            <option value="Salgado">Salgado</option>
        </select><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao"></textarea><br><br>

        <label>Preço (R$):</label><br>
        <input type="number" name="preco" step="0.01" required><br><br>

        <button type="submit">Salvar Produto</button>
    </form>
</body>
</html>