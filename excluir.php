<?php

    require_once __DIR__ . '/include/conexao.php';

    $id = $_GET['id'] ?? null;

if ($id){
    try {
        $sql = "DELETE FROM agendamentos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    } catch (PDOException $e){
        die("Erro ao excluir: " . $e->getMessage());
    }
}

header("Location: lista_agendamentos.php");
exit;