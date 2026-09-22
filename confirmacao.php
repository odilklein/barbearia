<?php
    // 1. OBRIGATÓRIO: Carregar as configurações e a conexão antes de tudo
    require_once __DIR__ . '/include/config.php';
    require_once __DIR__ . '/include/conexao.php';

    // Ativamos erros para sabermos se algo falhar no banco
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
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

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Captura dos dados (incluindo o novo campo do exercício)
                    $cliente = $_POST['nome_cliente'];
                    $servico = $_POST['servico'];
                    $data = $_POST['data_agendamento'];
                    $telefone = $_POST['telefone'];
                    $hora = $_POST['hora'];

                    if (strlen($cliente) < 3) {
                        echo "<div class='alert alert-danger'>O nome deve ter pelo menos 3 letras.</div>";
                        echo "<a href='index.php' class='btn btn-secondary'>Voltar</a>";
                        exit;
                    }

                    try {
                        // Inserção no Banco de Dados
                        $sql = "INSERT INTO agendamentos (cliente, servico, data_agendamento, telefone, hora)
                                VALUES (:cli, :ser, :dat, :tel, :hor)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            ':cli' => $cliente,
                            ':ser' => $servico,
                            ':dat' => $data,
                            ':tel' => $telefone,
                            ':hor' => $hora
                        ]);
                ?>

                        <h2 class="text-success mb-3">Agendamento Confirmado!</h2>
                        <p class="lead">Olá, <strong><?php echo $cliente; ?></strong>. Tudo pronto para o seu serviço.</p>
                        <hr>
                        <div class="text-start bg-light p-3 rounded">
                            <p><strong>Serviço:</strong> <?php echo $servico; ?></p>
                            <p><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($data)); ?></p>
                        </div>
                        <a href="index.php" class="btn btn-dark mt-4">Fazer novo agendamento</a>
                    </div>
                </div>

                <?php
                    } catch (PDOException $e) {
                        echo "<div class='alert alert-danger'>Erro ao salvar: " . $e->getMessage() . "</div>";
                    }
                } else {
                    // Proteção caso acessem a página direto pela URL
                    echo "<div class='alert alert-warning'>Nenhum dado recebido. Volte para a página inicial.</div>";
                    echo "<a href='index.php' class='btn btn-secondary'>Voltar</a>";
                }
                ?>

            </div>
        </div>
    </div>
</body>
</html>