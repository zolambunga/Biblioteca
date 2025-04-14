<?php include('../includes/db.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Livro</title>
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
                <li class="nav-item"><a class="nav-link" href="cadastrar-livro.php">Cadastrar Livro</a></li>
                <li class="nav-item"><a class="nav-link" href="consultar-livro.php">Consultar Livro</a></li>
                <li class="nav-item"><a class="nav-link" href="registro-livro.php">Registro de Livro</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Cadastrar Livro</h1>

        <?php
        // Fetch categories for dropdown
        $stmt = $pdo->prepare("SELECT * FROM categoria");
        $stmt->execute();
        $categorias = $stmt->fetchAll();

        // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //     $titulo = $_POST['titulo'];
        //     $autor = $_POST['autor'];
        //     $categoria_id = $_POST['categoria_id'];

        //     // Prepare the SQL statement to insert the new book
        //     $stmt = $pdo->prepare("INSERT INTO livro (titulo, autor, categoria_id, created_at) VALUES (?, ?, ?, NOW())");
        //     $stmt->execute([$titulo, $autor, $categoria_id]);

        //     echo "<div class='alert alert-success'>Livro cadastrado com sucesso!</div>";
        // }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titulo = trim($_POST['titulo']);
            $autor = trim($_POST['autor']);
            $categoria_id = $_POST['categoria_id'];
        
            // Verificar se o livro já existe
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM livro WHERE titulo = ? AND autor = ?");
            $stmt->execute([$titulo, $autor]);
            $livroExiste = $stmt->fetchColumn();
        
            if ($livroExiste > 0) {
                echo "<div class='alert alert-danger'>Erro: O livro já está cadastrado!</div>";
            } else {
                // Inserir novo livro
                $stmt = $pdo->prepare("INSERT INTO livro (titulo, autor, categoria_id, created_at) VALUES (?, ?, ?, NOW())");
                $stmt->execute([$titulo, $autor, $categoria_id]);
        
                echo "<div class='alert alert-success'>Livro cadastrado com sucesso!</div>";
            }
        }
        ?>

        <form action="cadastrar-livro.php" method="post">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título do Livro</label>
                <input type="text" name="titulo" id="titulo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" name="autor" id="autor" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="categoria_id" class="form-label">Categoria</label>
                <select name="categoria_id" id="categoria_id" class="form-control" required>
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id']; ?>"><?= $categoria['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <!-- Rodapé -->
    <footer class="footer bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Biblioteca. Todos os direitos reservados.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>
</html>



