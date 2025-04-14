<?php include('../includes/db.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Categoria</title>
    <link rel="shortcut icon" href="ISPK.ico" type="image/x-icon">
    <!-- Integrando Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Integrando Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <!-- Barra de Navegação com Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Biblioteca</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastrar-categoria.php">Cadastrar Categoria</a></li>
                <li class="nav-item"><a class="nav-link" href="consultar-categoria.php">Consultar Categoria</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastrar-livro.php">Cadastrar Livro</a></li>
                <li class="nav-item"><a class="nav-link" href="consultar-livro.php">Consultar Livro</a></li>
                <li class="nav-item"><a class="nav-link" href="registro-livro.php">Registro de Livro</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Cadastrar Categoria</h1>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $created_at = date('Y-m-d H:i:s'); // Capture the current date and time

            // Insert category into the database
            $stmt = $pdo->prepare("INSERT INTO categoria (nome, descricao, created_at) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $descricao, $created_at]);

            echo "<div class='alert alert-success'>Categoria cadastrada com sucesso!</div>";
        }
        ?>

        <form action="cadastrar-categoria.php" method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Categoria</label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea name="descricao" id="descricao" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <!-- Rodapé -->
    <footer class="footer bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 Biblioteca. Todos os direitos reservados.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>
</html>
