# ZeroByte Barber

Sistema simples de agendamento para uma barbearia, desenvolvido em PHP, MySQL e Bootstrap. O projeto oferece cadastro, listagem, edição e exclusão de agendamentos.

## Como executar

1. Copie `.env.example` para `.env` e ajuste os valores se necessário.
2. Suba os serviços:

   ```bash
   docker compose up -d --build
   ```

3. Acesse `http://localhost:8082`. O phpMyAdmin fica em `http://localhost:8083`.

Para parar os serviços, use `docker compose down`.

## Estrutura

- `index.php`: formulário de novo agendamento.
- `confirmacao.php`: validação e gravação do agendamento.
- `lista_agendamentos.php`: consulta dos próximos horários.
- `editar.php` e `excluir.php`: operações de atualização e remoção.
- `include/`: configuração, conexão e cabeçalho compartilhados.
- `sql/`: script inicial do banco de dados.