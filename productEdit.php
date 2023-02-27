<?php
$id = $_GET["id"] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

$venda = getVenda($pdo, $id);
$id_venda = $venda["id"];

    //delete Produto
if (isset($_POST['delete-produto'])) {
    $id = $_POST['delete-produto'];
    $statement = $pdo->prepare('DELETE FROM produtos WHERE id = :id');
    $statement->bindValue(':id', $id);
    $statement->execute();
    header("Location: update.php?id=$id_venda");
    exit();

    
}


$tipo_pagamento = sanitizeInput($venda["tipo_pagamento"]);
$data_venda = sanitizeInput($venda["data_venda"]);
$num_nota = sanitizeInput($venda["num_nota"]);
$obs = sanitizeInput($venda["obs"]);

$produtos = getProdutosByVendaId($pdo, $id);


foreach ($produtos as $index => $value) {
    $nome[$index] = $value["nome"];
    $preco[$index] = $value["preco"];
    $quantidade[$index] = $value["quantidade"];
    $anexo_produto[$index] = $value["anexo_produto"];
    $id_produto[$index] = $value["id"];
    $id_Venda[$index] = $value["id_venda"];
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once __DIR__ . "/validate.php";

    if (empty($errors)) {

        updateVenda(
            $pdo,
            $id,
            $tipo_pagamento,
            $data_venda,
            $num_nota,
            $obs,
            $anexo_vendaPath
        );

        $campos = ["nome", "quantidade", "preco", "id", "id_venda"];
        $produtos_editados = [];
        foreach ($campos as $campo) {
            if (!array_key_exists($campo, $_POST)) {
                continue;
            }
            foreach ($_POST[$campo] as $index => $value) {
                $produtos_editados[$index][$campo] = $value;
                $produtos_editados[$index]["anexo_produto"] =
                    $_FILES["anexo_produto"]["tmp_name"][$index];
            }
        }

        foreach ($produtos_editados as $index => $produtos_editado) {
            $anexo_produtoPath = $produtos_editado["anexo_produto"];

            $statement_produtos = $pdo->prepare(
                "UPDATE produtos SET nome = :nome, preco = :preco, quantidade = :quantidade, anexo_produto = :anexo_produto, id_venda = :id_venda WHERE id = :id"
            );
            $statement_produtos->bindValue(":nome", $produtos_editado["nome"]);
            $statement_produtos->bindValue(":preco", $produtos_editado["preco"]);
            $statement_produtos->bindValue(":quantidade",$produtos_editado["quantidade"]);
            $statement_produtos->bindValue(":anexo_produto", $xy[$index]);
            $statement_produtos->bindValue(":id_venda", $id_venda);
            $statement_produtos->bindValue(":id", $produtos_editado["id"]);
            $statement_produtos->execute();
        }
        header("Location: index.php");
    }
}
