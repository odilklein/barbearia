<?php
// 1. Configurações e Conexão (Essencial)
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/conexao.php';

// Ativação de erros para facilitar o seu desenvolvimento
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. Captura o ID via GET para saber QUEM vamos editar
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: lista_agendamentos.php");
    exit;
}

// 3. Busca os dados ATUAIS no banco para preencher o formulário
$stmt = $pdo->prepare("SELECT * FROM agendamentos WHERE id = :id");
$stmt->execute([':id' => $id]);
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dados) {
    die("Agendamento não encontrado no banco de dados.");
}

// 4. Lógica de Gravação (Quando clicar em Salvar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $sql = "UPDATE agendamentos SET
                cliente = :cli,
                telefone = :tel,
                servico = :ser,
                data_agendamento = :dat,
                horario = :hor
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':cli' => $_POST['nome_cliente'],
            ':tel' => $_POST['telefone_cliente'],
            ':ser' => $_POST['servico'],
            ':dat' => $_POST['data_agendamento'],
            ':hor' => $_POST['hora_agendamento'],
            ':id'  => $id
        ]);

        // Redireciona de volta com uma mensagem de sucesso
        header("Location: lista_agendamentos.php?msg=editado");
        exit;
    } catch (PDOException $e) {
        $erro_save = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Agendamento - <?php echo $nome_barbearia; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include_once __DIR__ . '/include/cabecalho.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">✏️ Editando Agendamento #<?php echo $id; ?></h4>
                </div>
                <div class="card-body">

                    <?php if(isset($erro_save)): ?>
                        <div class="alert alert-danger"><?php echo $erro_save; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nome do Cliente:</label>
                            <input type="text" name="nome_cliente" class="form-control" value="<?php echo $dados['cliente']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Telefone:</label>
                            <input type="text" name="telefone_cliente" class="form-control" value="<?php echo $dados['telefone']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Serviço:</label>
                            <select name="servico" class="form-select">
                                <option value="Corte" <?php echo ($dados['servico'] == 'Corte' ? 'selected' : ''); ?>>Corte Masculino</option>
                                <option value="Barba" <?php echo ($dados['servico'] == 'Barba' ? 'selected' : ''); ?>>Barba Terapia</option>
                                <option value="Combo" <?php echo ($dados['servico'] == 'Combo' ? 'selected' : ''); ?>>Cabelo + Barba</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data:</label>
                                <input type="date" name="data_agendamento" class="form-control" value="<?php echo $dados['data_agendamento']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hora:</label>
                                <input type="time" name="hora_agendamento" class="form-control" value="<?php echo $dados['horario']; ?>" required>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between">
                            <a href="lista_agendamentos.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>