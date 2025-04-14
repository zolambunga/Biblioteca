<?php
$host = 'localhost'; // ou o endereço do seu servidor de banco de dados
$dbname = 'biblioteca';
$username = 'root';  // ou o seu usuário do banco de dados
$password = '';      // ou a sua senha do banco de dados

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro ao conectar: ' . $e->getMessage();
}
?>
