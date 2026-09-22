<?php require_once __DIR__ . '/include/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $nome_barbearia; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php 
        // Inclui o visual do cabeçalho
        include_once __DIR__ . '/include/cabecalho.php'; 
    ?>

   <div class="container">
        <div class="card shadow-sm p-4 mx-auto" style="max-width: 500px;">
            <h4 class="text-center mb-4">Agende seu Horário</h4>
            
            <form action="confirmacao.php" method="POST">
                
                <div class="mb-3">
                    <label class="form-label">Seu Nome:</label>
                    <input type="text" name="nome_cliente" class="form-control" minlength="3" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefone</label>
                    <input type="tel" name="telefone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hora</label>
                    <input type="time" name="hora" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Escolha o Serviço:</label>
                    <select name="servico" class="form-select" required>
                        <?php foreach ($servicos as $servico => $valor): ?>
                            <option value="<?php echo htmlspecialchars($servico); ?>"><?php echo htmlspecialchars($servico); ?> - R$ <?php echo number_format($valor, 2, ',', '.'); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Data:</label>
                    <input type="date" name="data_agendamento" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-dark w-100">Finalizar Agendamento</button>
            </form>
        </div>
    </div>
</body>
</html>