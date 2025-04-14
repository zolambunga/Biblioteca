<?php
include('../includes/db.php');  // Include the database connection

// Handle form submission to add new book
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : null;
    $autor = isset($_POST['autor']) ? $_POST['autor'] : null;
    $categoria_id = isset($_POST['categoria_id']) ? $_POST['categoria_id'] : null;

    // Check if all fields are filled
    if ($titulo && $autor && $categoria_id) {
        // Insert new book into 'livro' table
        $stmt = $pdo->prepare("INSERT INTO livro (titulo, autor, categoria_id) VALUES (?, ?, ?)");
        $stmt->execute([$titulo, $autor, $categoria_id]);
        $message = "Livro cadastrado com sucesso!";
    } else {
        $message = "Todos os campos são obrigatórios!";
    }
}

// Fetch all books and their categories for displaying
$stmt = $pdo->prepare("SELECT l.id, l.titulo, l.autor, c.nome AS categoria FROM livro l JOIN categoria c ON l.categoria_id = c.id");
$stmt->execute();
$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch categories for the form
$stmtCategorias = $pdo->prepare("SELECT id, nome FROM categoria");
$stmtCategorias->execute();
$categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Livros - Biblioteca</title>
    <link rel="shortcut icon" href="ISPK.ico" type="image/x-icon">
    <!-- Integrando Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Integrando Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Biblioteca</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastrar-aluno.php">Cadastrar Aluno</a></li>
                <li class="nav-item"><a class="nav-link" href="consultar-aluno.php">Consultar Aluno</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastrar-livro.php">Cadastrar Livro</a></li>
                <li class="nav-item"><a class="nav-link" href="consultar-livro.php">Consultar Livro</a></li>
                <li class="nav-item"><a class="nav-link" href="registro-alunos.php">Registro de Alunos</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Registro de Livros</h1>

        <!-- Displaying Success or Error Message -->
        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Table to Display Books -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Categoria</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livros as $livro): ?>
                    <tr>
                        <td><?php echo $livro['id']; ?></td>
                        <td><?php echo $livro['titulo']; ?></td>
                        <td><?php echo $livro['autor']; ?></td>
                        <td><?php echo $livro['categoria']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
