<?php
function generateRandomDirectoryName($n)
{
    $characters =
        "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $str = "";
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }
    return $str;
}

function sanitizeInput($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars(stripslashes(trim($value)));
        }
    } else if (is_string($data)) {
        $data = htmlspecialchars(stripslashes(trim($data)));
    }
    return $data;
}

function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}


function addSale($pdo, $tipo_pagamento, $data_venda, $num_nota, $obs, $anexo_vendaPath, $produtos) {
    $errors = [];

    if (empty($errors)) {
        $statementVendas = $pdo->prepare("INSERT INTO vendas (tipo_pagamento, data_venda, num_nota, obs, anexo_venda, data_registro)
            VALUES (:tipo_pagamento, :data_venda, :num_nota, :obs, :anexo_venda, :date)");

        $statementVendas->bindValue(':tipo_pagamento', $tipo_pagamento);
        $statementVendas->bindValue(':data_venda', $data_venda);
        $statementVendas->bindValue(':num_nota', $num_nota);
        $statementVendas->bindValue(':obs', $obs);
        $statementVendas->bindValue(':anexo_venda', $anexo_vendaPath);
        $statementVendas->bindValue(':date', date('Y-m-d H:i:s'));
        $statementVendas->execute();

        $id_venda = $pdo->lastInsertId();
        foreach ($produtos  as $produto) {
            $statementProdutos = $pdo->prepare("INSERT INTO produtos (nome, preco, quantidade, anexo_produto, id_venda)
            VALUES (:nome, :preco, :quantidade, :anexo_produto, :id_venda)");

            $statementProdutos->bindValue(':nome', $produto['nome']);
            $statementProdutos->bindValue(':preco', $produto['preco']);
            $statementProdutos->bindValue(':quantidade', $produto['quantidade']);
            $statementProdutos->bindValue(':anexo_produto', $produto['anexo_produto']);
            $statementProdutos->bindValue(':id_venda', $id_venda);
            $statementProdutos->execute();
        }
        header('Location: index.php');
    }
}

function fetchVenda($pdo, $id) {
    $statement = $pdo->prepare("SELECT * FROM vendas WHERE id = :id");
    $statement->bindValue(":id", $id);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}