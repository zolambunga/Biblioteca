<?php include('../includes/db.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno - Biblioteca</title>
    <link rel="shortcut icon" href="ISPK.ico" type="image/x-icon">
    <!-- Integrando Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Custom CSS for Styling -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }
        .alert {
            font-size: 16px;
        }
    </style>
</head>
<body>

    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Biblioteca IPIZ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastrar-aluno.php">Cadastrar Aluno</a></li>
                <li class="nav-item"><a class="nav-link" href="consultar-aluno.php">Consultar Aluno</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h3><i class="fas fa-user-plus"></i> Cadastro de Aluno</h3>
            </div>
            <div class="card-body">

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Get form data
                    $nome = $_POST['nome'];
                    $matricula = $_POST['matricula'];
                    $curso = $_POST['curso'];
                    $email = $_POST['email'];
                    $telefone = $_POST['telefone'];

                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM alunos WHERE nome = ? AND email = ?");
                    $stmt->execute([$nome, $email]);
                    $usuarioExiste = $stmt->fetchColumn();

                    if ($usuarioExiste > 0)
                        echo "<div class='alert alert-danger'>Erro: Aluno já foi cadastrado!</div>";
                    else
                    {
                        // Insert the student into the database
                        try {
                            $stmt = $pdo->prepare("INSERT INTO alunos (nome, matricula, curso, email, telefone, criado_em) VALUES (?, ?, ?, ?, ?, NOW())");
                            $stmt->execute([$nome, $matricula, $curso, $email, $telefone]);
                            echo "<div class='alert alert-success'>Aluno cadastrado com sucesso!</div>";
                        } catch (PDOException $e) {
                            echo "<div class='alert alert-danger'>Erro ao cadastrar aluno: " . $e->getMessage() . "</div>";
                        }
                    }
                }
                ?>

                <form action="cadastrar-aluno.php" method="post" id="formCadastro">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Aluno</label>
                        <input type="text" name="nome" id="nome" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input type="text" name="matricula" id="matricula" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="curso" class="form-label">Curso</label>
                        <input type="text" name="curso" id="curso" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" name="telefone" id="telefone" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                </form>

            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="footer bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Biblioteca ISPK. Todos os direitos reservados.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Client-side validation -->
    <script>
        document.getElementById('formCadastro').addEventListener('submit', function(event) {
            var nome = document.getElementById('nome').value;
            var matricula = document.getElementById('matricula').value;
            var email = document.getElementById('email').value;
            var telefone = document.getElementById('telefone').value;

            if (!nome || !matricula || !email || !telefone) {
                event.preventDefault();
                alert("Por favor, preencha todos os campos obrigatórios.");
            }
        });
    </script>

</body>
</html>


