<?php include('../includes/db.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Alunos | Dados</title>
    <link rel="shortcut icon" href="auth/ISPK.ico" type="image/x-icon">
    <!-- Integrando Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Integrando Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">

    <!-- Integrando Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                <li class="nav-item"><a class="nav-link" href="registro-alunos.php">Registro de Alunos</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Registro de Alunos</h1>

        <!-- Tabela de Alunos -->
        <?php
        // Consulta para exibir alunos
        $stmt = $pdo->query("SELECT id, nome, matricula, curso, email, telefone, criado_em FROM alunos");
        $alunos = $stmt->fetchAll();
        
        if ($alunos) {
            echo "<table class='table table-striped mt-4'><thead><tr><th>ID</th><th>Nome</th><th>Matricula</th><th>Curso</th><th>Email</th><th>Telefone</th><th>Criado em</th></tr></thead><tbody>";
            foreach ($alunos as $aluno) {
                echo "<tr><td>{$aluno['id']}</td><td>{$aluno['nome']}</td><td>{$aluno['matricula']}</td><td>{$aluno['curso']}</td><td>{$aluno['email']}</td><td>{$aluno['telefone']}</td><td>{$aluno['criado_em']}</td></tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='alert alert-warning mt-4'>Nenhum aluno registrado ainda.</p>";
        }
        ?>

        <!-- Formulário de Cadastro de Aluno -->
        
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





