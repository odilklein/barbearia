<?php
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/conexao.php';

$erro = null;
$dados = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente = trim($_POST['nome_cliente'] ?? '');
    $servico = $_POST['servico'] ?? '';
    $data = $_POST['data_agendamento'] ?? '';
    $telefone = trim($_POST['telefone'] ?? '');
    $hora = $_POST['hora'] ?? '';

    if (mb_strlen($cliente) < 3) {
        $erro = 'O nome deve ter pelo menos 3 caracteres.';
    } elseif (!array_key_exists($servico, $servicos)) {
        $erro = 'Selecione um serviço válido.';
    } elseif (!$data || !$hora || !$telefone) {
        $erro = 'Preencha todos os campos obrigatórios.';
    } else {
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO agendamentos (cliente, servico, valor, data_agendamento, telefone, hora)
                 VALUES (:cliente, :servico, :valor, :data, :telefone, :hora)'
            );
            $stmt->execute([
                ':cliente' => $cliente,
                ':servico' => $servico,
                ':valor' => calcularValor($servico),
                ':data' => $data,
                ':telefone' => $telefone,
                ':hora' => $hora,
            ]);
            $dados = compact('cliente', 'servico', 'data', 'hora', 'telefone');
        } catch (PDOException $exception) {
            $erro = 'Não foi possível salvar o agendamento.';
        }
    }
} else {
    $erro = 'Nenhum agendamento foi enviado.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação - <?php echo $nome_barbearia; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php
        // 3. OBRIGATÓRIO: Incluir o visual da Nav
        include_once __DIR__ . '/include/cabecalho.php';
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <?php if ($erro): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
                    <a href="index.php" class="btn btn-secondary">Voltar</a>
                <?php elseif ($dados): ?>
                    <h2 class="text-success mb-3">Agendamento confirmado!</h2>
                    <p class="lead">Olá, <strong><?php echo htmlspecialchars($dados['cliente']); ?></strong>. Tudo pronto para o seu serviço.</p>
                    <hr>
                    <div class="text-start bg-light p-3 rounded">
                        <p><strong>Serviço:</strong> <?php echo htmlspecialchars($dados['servico']); ?></p>
                        <p><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($dados['data'])); ?></p>
                        <p><strong>Hora:</strong> <?php echo date('H:i', strtotime($dados['hora'])); ?></p>
                    </div>
                    <a href="index.php" class="btn btn-dark mt-4">Fazer novo agendamento</a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</body>
</html>