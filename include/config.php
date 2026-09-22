<?php
// Configurações gerais
$nome_barbearia = "ZeroByte Barber";
$contato = "(11) 98888-7777";
$servicos = [
    'Corte' => 30.00,
    'Barba' => 25.00,
    'Combo' => 50.00,
];

// Função para saudação baseada na hora
function saudar() {
    $hora = date('H');
    if ($hora < 12) return "Bom dia";
    if ($hora < 18) return "Boa tarde";
    return "Boa noite";
}

function calcularValor($servico) {
    global $servicos;
    return $servicos[$servico] ?? 0.00;
}