<?php
$id = $_GET["id"] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

$venda = fetchVenda($pdo, $id);
$id_venda = $venda["id"];

$tipo_pagamento = sanitize_input($venda["tipo_pagamento"]);
$data_venda = sanitize_input($venda["data_venda"]);
$num_nota = sanitize_input($venda["num_nota"]);
$obs = sanitize_input($venda["obs"]);


$statement = $pdo->prepare("SELECT * FROM produtos WHERE id_venda = :id_venda");
$statement->bindValue(":id_venda", $id_venda);
$statement->execute();
$produtos = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($produtos as $index => $x) {
    $nome[$index] = $x["nome"];
    $preco[$index] = $x["preco"];
    $quantidade[$index] = $x["quantidade"];
    $anexo_produto[$index] = $x["anexo_produto"];
    $id_produto[$index] = $x["id"];
}
/* exit; */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once __DIR__ . "/validate.php";

    if (empty($errors)) {
        $statement_vendas = $pdo->prepare(
            "UPDATE vendas SET tipo_pagamento = :tipo_pagamento, data_venda = :data_venda, num_nota = :num_nota, obs = :obs, anexo_venda = :anexo_venda, data_registro = :date WHERE id = :id"
        );
        $statement_vendas->bindValue(":tipo_pagamento", $tipo_pagamento);
        $statement_vendas->bindValue(":data_venda", $data_venda);
        $statement_vendas->bindValue(":num_nota", $num_nota);
        $statement_vendas->bindValue(":obs", $obs);
        $statement_vendas->bindValue(":anexo_venda", $anexo_vendaPath);
        $statement_vendas->bindValue(":date", date("Y-m-d H:i:s"));
        $statement_vendas->bindValue(":id", $id);
        $statement_vendas->execute();

        $campos = ["nome", "quantidade", "preco", "id"];
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
            $statement_produtos->bindValue(":preco",$produtos_editado["preco"]);
            $statement_produtos->bindValue(":quantidade",$produtos_editado["quantidade"]
            );
            $statement_produtos->bindValue(":anexo_produto", $xy[$index]);
            $statement_produtos->bindValue(":id_venda", $id_venda);
            $statement_produtos->bindValue(":id", $produtos_editado["id"]);

            $statement_produtos->execute();
        }
        header("Location: index.php");
    }
}
