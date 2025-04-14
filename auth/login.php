<?php 
session_start();
include('../includes/db.php');

// Verificar se o usuário já está logado
if (isset($_SESSION['usuario_id'])) {
    // Verifica o tipo de acesso e redireciona para o painel correspondente
    if ($_SESSION['tipo_acesso'] == 'bibliotecario') {
        header('Location: ../pages/dashboard.php'); // Redireciona para o painel do bibliotecário
    } else {
        header('Location: ../pages/dashboard.php'); // Redireciona para o painel de administrador
    }
    exit();
}

// Cadastrar novo usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar_usuario'])) {
    $numero_registro = $_POST['numero_registro'];
    $senha = $_POST['senha'];  // No password hashing, just plain text
    $tipo_acesso = $_POST['tipo_acesso'];

    // Verificar se o número de registro já existe
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE numero_registro = ?");
    $stmt->execute([$numero_registro]);
    if ($stmt->rowCount() > 0) {
        $erro = "Número de registro já existe!";
    } else {
        // Cadastrar novo usuário
        $stmt = $pdo->prepare("INSERT INTO usuarios (numero_registro, senha, tipo_acesso) VALUES (?, ?, ?)");
        $stmt->execute([$numero_registro, $senha, $tipo_acesso]);
        $sucesso = "Usuário cadastrado com sucesso! Agora você pode fazer login.";
    }
}

// Realizar login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $numero_registro = $_POST['numero_registro'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE numero_registro = ?");
    $stmt->execute([$numero_registro]);
    $usuario = $stmt->fetch();

    if ($usuario && $senha == $usuario['senha']) {  // Direct comparison without password hashing
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['tipo_acesso'] = $usuario['tipo_acesso'];
        
        // Redireciona dependendo do tipo de acesso
        if ($_SESSION['tipo_acesso'] == 'bibliotecario') {
            header('Location: ../pages/dashboard_bibliotecario.php'); // Redireciona para o painel do bibliotecário
        } else {
            header('Location: ../pages/dashboard.php'); // Redireciona para o painel do administrador
        }
        exit();
    } else {
        $erro = "Número de registro ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binlioteca | login</title>
    <link rel="shortcut icon" href="../auth/ipiz.jpg" type="image/x-icon">
    <!-- Integrando Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/auth/estilo.css">
    <!-- Integrando Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-login">

    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Biblioteca</a>
    </nav>

    <!-- Login Formulário -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Sistema | Acesso</h4>
                        
                        <!-- Adicionando a imagem -->
                        <div class="text-center">
                            <img src="ipiz.jpg" alt="Logo da Biblioteca" class="img-fluid" style="max-width: 100px; margin-bottom: 15px;">
                        </div>

                        <?php if (isset($erro)): ?>
                            <div class="alert alert-danger"><?= $erro; ?></div>
                        <?php endif; ?>

                        <?php if (isset($sucesso)): ?>
                            <div class="alert alert-success"><?= $sucesso; ?></div>
                        <?php endif; ?>

                        <!-- Formulário de Login -->
                        <form action="login.php" method="POST" id="login-form">
                            <div class="mb-3">
                                <label for="numero_registro" class="form-label">Número de Registro</label>
                                <input type="text" name="numero_registro" id="numero_registro" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" name="senha" id="senha" class="form-control" required>
                            </div>

                            <button type="submit" name="login" class="btn btn-primary w-100">Entrar</button>
                        </form>

                        <!-- Cadastrar Novo Usuário -->
                        <div class="mt-3 text-center">
                            <button id="cadastro-btn" class="btn btn-link">Cadastrar Novo Usuário</button>
                        </div>

                        <!-- Formulário de Cadastro de Usuário -->
                        <form action="login.php" method="POST" id="cadastro-form" class="mt-4" style="display: none;">
                            <div class="mb-3">
                                <label for="numero_registro" class="form-label">Número de Registro</label>
                                <input type="text" name="numero_registro" id="numero_registro" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" name="senha" id="senha" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="tipo_acesso" class="form-label">Tipo de Acesso</label>
                                <select name="tipo_acesso" id="tipo_acesso" class="form-select">
                                    <option value="admin">Admin</option>
                                    <option value="bibliotecario">Bibliotecário</option>
                                </select>
                            </div>

                            <button type="submit" name="cadastrar_usuario" class="btn btn-success w-100">Cadastrar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="footer bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Biblioteca. Todos os direitos reservados.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script>
        // Alternar entre o formulário de login e o de cadastro
        document.getElementById('cadastro-btn').addEventListener('click', function() {
            var loginForm = document.getElementById('login-form');
            var cadastroForm = document.getElementById('cadastro-form');
            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                cadastroForm.style.display = 'none';
            } else {
                loginForm.style.display = 'none';
                cadastroForm.style.display = 'block';
            }
        });
    </script>
</body>
</html>

