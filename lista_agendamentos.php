<?php
    require_once __DIR__ . '/include/config.php';
    require_once __DIR__ . '/include/conexao.php';
// 1. Buscamos os dados ordenados por data e hora (os mais próximos primeiro)
$sql = "SELECT * FROM agendamentos ORDER BY data_agendamento ASC, hora ASC";
$stmt = $pdo->query($sql);
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC); //Cria um Array com elemnetos
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $nome_barbearia; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once __DIR__ . '/include/cabecalho.php'; ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Próximos Agendamentos</h2>
            <a href="index.php" class="btn btn-primary btn-sm">+ Novo Agendamento</a>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Cliente</th>
                            <th>Serviço</th>
                            <th>Contato</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($agendamentos) > 0): ?>
                            <?php foreach ($agendamentos as $row): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($row['data_agendamento'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($row['hora'])); ?></td>
                                    <td><strong><?php echo htmlspecialchars($row['cliente']); ?></strong></td>
                                    <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars($row['servico']); ?></span></td>
                                    <td>
                                        <a href="https://wa.me/<?php echo $row['telefone']; ?>" target="_blank" class="text-decoration-none">
                                            📲 <?php echo htmlspecialchars($row['telefone']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Editar</a>
                                        <a href="excluir.php?id=<?php echo (int) $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja cancelar?')">Excluir</a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center p-4 text-muted">Nenhum agendamento encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>