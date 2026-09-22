<?php
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: lista_agendamentos.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM agendamentos WHERE id = :id');
$stmt->execute([':id' => $id]);
$agendamento = $stmt->fetch();
if (!$agendamento) {
    header('Location: lista_agendamentos.php');
    exit;
}

$erro = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente = trim($_POST['nome_cliente'] ?? '');
    $servico = $_POST['servico'] ?? '';
    $data = $_POST['data_agendamento'] ?? '';
    $telefone = trim($_POST['telefone'] ?? '');
    $hora = $_POST['hora'] ?? '';

    if (mb_strlen($cliente) < 3 || !array_key_exists($servico, $servicos) || !$data || !$hora || !$telefone) {
        $erro = 'Preencha corretamente todos os campos.';
    } else {
        $stmt = $pdo->prepare('UPDATE agendamentos SET cliente = :cliente, servico = :servico, valor = :valor, data_agendamento = :data, telefone = :telefone, hora = :hora WHERE id = :id');
        $stmt->execute([':cliente' => $cliente, ':servico' => $servico, ':valor' => calcularValor($servico), ':data' => $data, ':telefone' => $telefone, ':hora' => $hora, ':id' => $id]);
        header('Location: lista_agendamentos.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar agendamento - <?php echo htmlspecialchars($nome_barbearia); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include __DIR__ . '/include/cabecalho.php'; ?>
<main class="container">
    <h1 class="h3 mb-4">Editar agendamento</h1>
    <?php if ($erro): ?><div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-sm">
        <label class="form-label">Nome<input class="form-control" name="nome_cliente" minlength="3" required value="<?php echo htmlspecialchars($agendamento['cliente']); ?>"></label>
        <label class="form-label">Telefone<input class="form-control" name="telefone" required value="<?php echo htmlspecialchars($agendamento['telefone']); ?>"></label>
        <label class="form-label">Hora<input type="time" class="form-control" name="hora" required value="<?php echo htmlspecialchars(substr($agendamento['hora'], 0, 5)); ?>"></label>
        <label class="form-label">Serviço<select class="form-select" name="servico" required><?php foreach ($servicos as $servico => $valor): ?><option value="<?php echo htmlspecialchars($servico); ?>" <?php echo $agendamento['servico'] === $servico ? 'selected' : ''; ?>><?php echo htmlspecialchars($servico); ?></option><?php endforeach; ?></select></label>
        <label class="form-label">Data<input type="date" class="form-control" name="data_agendamento" required value="<?php echo htmlspecialchars($agendamento['data_agendamento']); ?>"></label>
        <button class="btn btn-dark" type="submit">Salvar alterações</button>
    </form>
</main>
</body>
</html>