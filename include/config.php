<?php
// Configurações gerais
$nome_barbearia = "ZeroByte Barber";
$contato = "(11) 98888-7777";

// Função para saudação baseada na hora
function saudar() {
    $hora = date('H');
    if ($hora < 12) return "Bom dia";
    if ($hora < 18) return "Boa tarde";
    return "Boa noite";
}

function calcularValor($servico) {
    if ($servico == "Corte") return 30.00;
    if ($servico == "Barba") return 25.00;
    if ($servico == "Combo") return 50.00;
    return 0.00;
}
?>