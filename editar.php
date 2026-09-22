<?php

    require_once __DIR__ . '/include/conexao.php';
    require_once __DIR__ . '/include/config.php';

    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $id = $_GET['id'] ?? null;
    
    if (!$id){
        header("Location: lista_agendamentos.php");
        exit;
    }
    
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