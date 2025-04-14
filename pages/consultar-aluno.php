<?php include('../includes/db.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Aluno</title>
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
                <li class="nav-item"><a class="nav-link" href="cadastrar-aluno.php">Cadastrar Aluno</a></li>
                <li class="nav-item"><a class="nav-link" href="consultar-aluno.php">Consultar Aluno</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastrar-livro.php">Cadastrar Livro</a></li>
                <li class="nav-item"><a class="nav-link" href="consultar-livro.php">Consultar Livro</a></li>
                <li class="nav-item"><a class="nav-link" href="registro-alunos.php">Registro de Alunos</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Consultar Aluno</h1>

        <form action="consultar-aluno.php" method="get">
            <div class="mb-3">
                <label for="consulta" class="form-label">Buscar Aluno</label>
                <input type="text" name="consulta" id="consulta" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <?php
        if (isset($_GET['consulta'])) {
            $consulta = $_GET['consulta'];

            // Query to fetch students data from the database
            if ($consulta == '*')
            {
                $stmt = $pdo->prepare("SELECT * FROM alunos");
                $stmt->execute();
            }
            else
            {
                $stmt = $pdo->prepare("SELECT * FROM alunos WHERE nome LIKE ?");
                $stmt->execute(['%' . $consulta . '%']);
            }

            $alunos = $stmt->fetchAll();

            if ($alunos)
            {
                // Display the students' data in a table
                echo "<table class='table table-striped mt-4'><thead><tr><th>ID</th><th>Nome</th><th>Matrícula</th><th>Curso</th><th>Email</th><th>Telefone</th><th>Criado em</th></tr></thead><tbody>";
                foreach ($alunos as $aluno) {
                    echo "<tr><td>{$aluno['id']}</td><td>{$aluno['nome']}</td><td>{$aluno['matricula']}</td><td>{$aluno['curso']}</td><td>{$aluno['email']}</td><td>{$aluno['telefone']}</td><td>{$aluno['criado_em']}</td></tr>";
                }
                echo "</tbody></table>";
            }
            else
            {
                echo "<p class='alert alert-danger mt-4'>Nenhum aluno encontrado.</p>";
            }
        }
        ?>
    </div>

    <!-- Script do Bootstrap e Materialize -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>
</html>

