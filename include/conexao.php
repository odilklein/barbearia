<?php
$host = "db";
$dbname = "barbearia";
$user = "barbearia";
$pass = "root123";

try {
    // DSN (Data Source Name)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

    // Ativa o modo de erro para exceções (ajuda no debug)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}
?>