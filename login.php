<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login OOP</title>
</head>
<body style="text-align: center; padding-top: 50px;">
    <h2>Acesso ao Sistema</h2>
    
    <?php if (!empty($erro)): ?>
        <p style="color: red;"><?= $erro ?></p>
    <?php endif; ?>

    <form method="POST" action="/login">
        <input type="text" name="usuario" placeholder="Usuário" required><br><br>
        <input type="password" name="senha" placeholder="Senha" required><br><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>