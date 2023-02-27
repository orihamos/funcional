<?php

$errors = [];

$tipo_pagamento = $data_venda = $num_nota = $obs = '';

$venda = [
  'anexo_venda' => ''
];

$produtos[] = array(
  'anexo_produto' => '',
  'nome' => '',
  'preco' => '',
  'quantidade' => '',
  'data_registro' => date('Y-m-d H')
);

$produto = [
  'anexo_produto' => ''
];
  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  require_once __DIR__ . '/validate.php';

  addRegistro($pdo, $tipo_pagamento, $data_venda, $num_nota, $obs, $anexo_vendaPath, $produtos);
}
