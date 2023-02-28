<?php
require_once __DIR__ . "/functions.php";


$tipo_pagamento = isset($_POST['tipo_pagamento']) && $_POST['tipo_pagamento'] === 'Outro' ? $_POST['outro_tipo_pagamento'] : $_POST['tipo_pagamento'];
$tipo_pagamento = sanitizeInput($tipo_pagamento);
$data_venda = sanitizeInput($_POST["data_venda"]);
$num_nota = sanitizeInput($_POST["num_nota"]);
$obs = sanitizeInput($_POST["obs"]);
$anexo_venda = $_FILES["anexo_venda"] ?? null;
$anexo_vendaPath = $venda["anexo_venda"];

$produtos = [];
$nomes = sanitizeInput($_POST["nome"]);
$precos = sanitizeInput($_POST["preco"]);
$quantidades = sanitizeInput($_POST["quantidade"]);
$anexo_produtos = $_FILES["anexo_produto"] ?? null;
$anexo_produtoPath = "";

$errors = [];

if (!is_dir(__DIR__ . "/public/products/images")) {
    mkdir(__DIR__ . "/public/products/images");
}

foreach ($nomes as $index => $nome) {
    $preco = $precos[$index];
    $quantidade = $quantidades[$index];

    $produto = [
        "nome" => $nome,
        "preco" => $preco,
        "quantidade" => $quantidade,
        "anexo_produto" => null,
    ];

    if ($anexo_produtos && $anexo_produtos["tmp_name"][$index]) {
        if ($produto["anexo_produto"]) {
            unlink(
                __DIR__ . "/public/products/" . $produto["anexo_produto"]
            );
        }

        $anexo_produtoPath =
            "images/" . generateRandomDirectoryName(8) . "/" . $anexo_produtos["name"][$index];
        mkdir(
            dirname(__DIR__ . "/public/products/" . $anexo_produtoPath),
            0777,
            true
        );
        move_uploaded_file(
            $anexo_produtos["tmp_name"][$index],
            __DIR__ . "/public/products/" . $anexo_produtoPath
        );
        $xy[] = $anexo_produtoPath;
        $produto["anexo_produto"] = $anexo_produtoPath;
    }

    $produtos[] = $produto;

    if (!$nome) {
        $errors[] = "Nome do produto é obrigatório";
    }

    if (!$preco) {
        $errors[] = "Preço do produto é obrigatório";
    }

    if (!$quantidade) {
        $errors[] = "Quantidade do produto é obrigatório";
    }
}

if ($anexo_venda && $anexo_venda["tmp_name"]) {
    if ($venda["anexo_venda"]) {
        unlink(__DIR__ . "/public/products/" . $venda["anexo_venda"]);
    }

    $anexo_vendaPath = "images/" . generateRandomDirectoryName(8) . "/" . $anexo_venda["name"];
    mkdir(dirname(__DIR__ . "/public/products/" . $anexo_vendaPath));
    move_uploaded_file($anexo_venda["tmp_name"], $anexo_vendaPath);
}

if (!$tipo_pagamento) {
    $errors[] = "Tipo de pagamento é obrigatório";
}

if (!$data_venda) {
    $errors[] = "Data da venda é obrigatório";
}

if (!$num_nota) {
    $errors[] = "Número da nota é obrigatório";
}
