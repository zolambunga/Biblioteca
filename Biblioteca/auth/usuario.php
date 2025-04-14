<?php
session_start();
require 'conexao.php'; // Arquivo com a conexão PDO

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não está logado.");
}

$usuarioId = $_SESSION['usuario_id'];

// Obtém o nome do usuário
$stmtUser = $pdo->prepare("SELECT nome FROM usuarios WHERE id = ?");
$stmtUser->execute([$usuarioId]);
$usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);
$usuarioNome = $usuario ? $usuario['nome'] : 'Usuário desconhecido';

// Obtém os livros disponíveis
$stmtLivros = $pdo->query("SELECT titulo, autor FROM livros");
$livros = $stmtLivros->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - Página do Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">

<div class="container mt-5">
    <div class="card p-4 shadow-lg">
        <h2 class="text-center">Bem-vindo, <?php echo htmlspecialchars($usuarioNome); ?>!</h2>
        <p class="text-center">Aqui estão os livros disponíveis na biblioteca:</p>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livros as $livro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($livro['autor']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="logout.php" class="btn btn-danger">Sair</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
