<?php
// config.php

// Configuração do banco de dados
$host = 'localhost';
$dbname = 'biblioteca';
$username = 'root'; // Substitua pelo usuário do banco de dados
$password = ''; // Substitua pela senha do banco de dados

try {
    // Criação da conexão com o banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Exibe uma mensagem de erro em caso de falha na conexão
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}


// Configurações adicionais podem ser adicionadas aqui
?>
