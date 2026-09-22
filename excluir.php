<?php
require_once __DIR__ . '/include/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM agendamentos WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

header('Location: lista_agendamentos.php');
exit;