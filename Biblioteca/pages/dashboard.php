<?php
session_start();
include('../includes/db.php');

// Verificar se o usuário está logado

// Buscar dados do usuário logado
try {
    

    $usuarioId = $_SESSION['usuario_id'];

    // Supondo que $pdo seja sua conexão PDO
    $stmtUser = $pdo->prepare("SELECT numero_registro FROM usuarios WHERE id = ?");
    $stmtUser->execute([$usuarioId]);

    $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);
    $usuarioNome = $usuario ? $usuario['numero_registro'] : 'Usuário não encontrado';

    echo "Usuário logado: " . htmlspecialchars($usuarioNome);
    //echo "coooler";
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}

// Get total number of books
$stmtBooks = $pdo->prepare("SELECT COUNT(id) AS total_books FROM livro");
$stmtBooks->execute();
$totalBooks = $stmtBooks->fetch(PDO::FETCH_ASSOC)['total_books'];

// Get total number of students
$stmtStudents = $pdo->prepare("SELECT COUNT(id) AS total_students FROM alunos");
$stmtStudents->execute();
$totalStudents = $stmtStudents->fetch(PDO::FETCH_ASSOC)['total_students'];

// Fetch books grouped by category
$stmt = $pdo->prepare("SELECT c.nome as categoria, COUNT(l.id) as num_livros FROM livro l JOIN categoria c ON l.categoria_id = c.id GROUP BY c.nome");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for chart
$categorias = [];
$quantidade = [];
foreach ($data as $row) {
    $categorias[] = $row['categoria'];
    $quantidade[] = $row['num_livros'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema | Biblioteca</title>
    <link rel="shortcut icon" href="ipiz.jpg" type="image/ipiz.jpg">
    <!-- Integrando Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Integrando Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Integrando Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

    <!-- Barra de Navegação com Bootstrap e Materialize -->
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
                <li class="nav-item"><a class="nav-link" href="cadastrar-categoria.php">Cadastrar Categoria</a></li>
                <li class="nav-item"><a class="nav-link" href="registro-alunos.php">Registro de Alunos</a></li>
                <li class="nav-item"><a class="nav-link" href="Encerrar.php">Sair</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Bem-vindo, à BIBLIOTECA <?php echo htmlspecialchars($usuarioNome); ?>!</h1>

        <?php
        // Display Registered Books and Students Count
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total de Livros</h5>
                        <p class="card-text"><?php echo $totalBooks; ?> livros registrados.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total de Alunos</h5>
                        <p class="card-text"><?php echo $totalStudents; ?> alunos registrados.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart for Books by Category -->
        <h3 class="mt-4">Livros por Categoria</h3>
        <canvas id="grafico"></canvas>
        <script>
            var ctx = document.getElementById('grafico').getContext('2d');
            var grafico = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($categorias); ?>,
                    datasets: [{
                        label: 'Número de Livros',
                        data: <?php echo json_encode($quantidade); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                }
            });
        </script>
    </div>

    <!-- Scripts do Bootstrap e Materialize -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>
</html>
