<?php

$search = $_GET['search'] ?? '';
if ($search) {
    $statementVendas = $pdo->prepare('SELECT DISTINCT vendas.* FROM vendas 
        INNER JOIN produtos ON vendas.id = produtos.id_venda 
        WHERE (vendas.num_nota LIKE :search OR vendas.obs LIKE :search OR produtos.nome LIKE :search) 
        ORDER BY vendas.data_registro DESC');
    $statementVendas->bindValue(':search', "%$search%");
    $statementVendas->execute();
    $vendas = $statementVendas->fetchAll(PDO::FETCH_ASSOC);
    $id_vendas = [];
    foreach ($vendas as $venda) {
        $id_vendas[] = $venda['id'];
    }
    $id_vendas = implode(',', $id_vendas);
    $statementProdutos = $pdo->prepare("SELECT * FROM produtos WHERE id_venda IN ($id_vendas) ORDER BY id_venda DESC");
    $statementProdutos->execute();
    $produtos = $statementProdutos->fetchAll(PDO::FETCH_ASSOC);
} else {
    $statementVendas = $pdo->prepare("SELECT * FROM vendas ORDER BY data_registro DESC");
    $statementProdutos = $pdo->prepare("SELECT * FROM produtos ORDER BY id_venda DESC");
    $statementVendas->execute();
    $vendas = $statementVendas->fetchAll(PDO::FETCH_ASSOC);
    $statementProdutos->execute();
    $produtos = $statementProdutos->fetchAll(PDO::FETCH_ASSOC);
}




?>

<form class="form-inline d-inline-flex">
    <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" name="search" value="<?php echo $search ?>">
    <button class="btn btn-secondary" type="submit">Buscar</button>
</form>
<div id="search-results"></div>
<h2>Vendas</h2>
<table class="table ">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Anexo</th>
            <th scope="col">Tipo de Pagamento</th>
            <th scope="col">Data da Venda</th>
            <th scope="col">Número da Nota</th>
            <th scope="col">Observação</th>
            <th scope="col">Data de Registro</th>
            <th scope="col">Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // if there's any
        if (empty($vendas)) : ?>
            <tr>
                <td colspan="7">Nada</td>
            </tr>
        <?php else : ?>

            <?php foreach ($vendas as $i => $venda) : ?>
                <tr>
                    <td scope="row"><?php echo " " . $venda['id']; ?></td>
                    <td>
                        <img src="<?php echo $venda['anexo_venda'] ?>" class="img-thumbnail w-25">
                    </td>
                    <td><?php echo $venda['tipo_pagamento'] ?></td>
                    <td><?php echo $venda['data_venda'] ?></td>
                    <td><?php echo $venda['num_nota'] ?></td>
                    <td><?php echo $venda['obs'] ?></td>
                    <td><?php echo $venda['data_registro'] ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $venda['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                        <form method="post" action="delete.php">
                            <input type="hidden" name="id" value="<?php echo $venda['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Deletar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<h2>Produtos</h2>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID </th>
            <th scope="col">Anexo</th>
            <th scope="col">Nome</th>
            <th scope="col">Preço</th>
            <th scope="col">Quantidade</th>
            <th scope="col">Data de Registro</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // if there's any
        if (empty($produtos)) : ?>
            <tr>
                <td colspan="7">Nada</td>
            </tr>
        <?php else : ?>

            <?php foreach ($produtos as $i => $produto) : ?>
                <tr>
                <td> ID produto</td>
                    <td>
                        <img src="<?php echo $produto['anexo_produto'] ?>" class="img-thumbnail w-25">
                    </td>
                    <td><?php echo $produto['nome'] ?></td>
                    <td><?php echo $produto['preco'] ?></td>
                    <td><?php echo $produto['quantidade'] ?></td>
                    <td><?php echo $venda['data_registro'] ?></td>
                    <td><?php echo $produto['id']; ?></td>
                </tr>
                <input type="hidden" name="id" value="<?php echo $produto['id'] ?>">
            <?php endforeach; ?>
        <?php endif; ?>