<?php
$errors = [];

$tipo_pagamento = $data_venda = $num_nota = $obs = '';


$produtos = array();
$produtos[] = array(
  'anexo_produto' => '',
  'nome' => '',
  'preco' => '',
  'quantidade' => '',
  'data_registro' => date('Y-m-d H')
);
$venda = [
  'anexo_venda' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once __DIR__ . '/validate.php';

  addSale($pdo, $tipo_pagamento, $data_venda, $num_nota, $obs, $anexo_vendaPath, $produtos);
}
