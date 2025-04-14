<?php
session_start();
session_destroy(); // Destrói a sessão
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encerrando Sessão | Biblioteca</title>
    <link rel="shortcut icon" href="ISPK.ico" type="image/x-icon">
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .message-container {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
            opacity: 0;
        }
    </style>
</head>
<body>

    <div class="message-container" id="messageContainer">
        <h5>Sessão encerrada com sucesso!</h5>
        <p>Aguarde, você será redirecionado para a tela de login.</p>
    </div>

    <!-- Materialize JS and Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script>
        // Função para mostrar a mensagem de sucesso com animação
        document.addEventListener('DOMContentLoaded', function() {
            var messageContainer = document.getElementById('messageContainer');

            // Efeito de fade-in
            messageContainer.style.opacity = 1;
            messageContainer.classList.add('fadeIn');

            // Redireciona após 3 segundos
            setTimeout(function() {
                window.location.href = '../auth/login.php'; // Redireciona para login.php
            }, 3000); // Redireciona após 3 segundos
        });
    </script>

</body>
</html>
