<?php
require_once __DIR__ . '/../functions.php';

$search = $_GET['search'] ?? '';
if ($search) {
    $statementQuery = $pdo->prepare('SELECT DISTINCT vendas.*  FROM vendas 
        INNER JOIN produtos ON vendas.id = produtos.id_venda 
        WHERE vendas.id LIKE :search OR vendas.tipo_pagamento LIKE :search OR vendas.data_venda LIKE :search OR vendas.num_nota LIKE :search OR vendas.obs LIKE :search OR produtos.nome LIKE :search OR produtos.preco LIKE :search OR produtos.quantidade LIKE :search');
    $statementQuery->bindValue(':search', "%$search%");
    $statementQuery->execute();
    $query = $statementQuery->fetchAll(PDO::FETCH_ASSOC);

    $vendas = [];
    $produtos = [];

    foreach ($query as $q) {
        $statementVendasQuery = $pdo->prepare("SELECT * FROM vendas WHERE id = :id");
        $statementProdutosQuery = $pdo->prepare("SELECT * FROM produtos WHERE id_venda = :id");

        $statementVendasQuery->bindValue(':id', $q['id']);
        $statementProdutosQuery->bindValue(':id', $q['id']);

        $statementVendasQuery->execute();
        $vendas = array_merge($vendas, $statementVendasQuery->fetchAll(PDO::FETCH_ASSOC));

        $statementProdutosQuery->execute();
        $produtos = array_merge($produtos, $statementProdutosQuery->fetchAll(PDO::FETCH_ASSOC));
    }
} else {
    $vendas = getSales($pdo);
    $produtos = getProducts($pdo);
}
?>
<div class ="col-12 d-flex justify-content-end">
<form class="form-inline d-inline-flex">
    <input class="form-control mr-sm-2" type="text" placeholder="Buscar" aria-label="Search" name="search" value="<?php echo $search ?>">
    <button class="btn btn-secondary" type="submit">Buscar</button>
</form>
</div>
<!-- <div id="search-results"></div> -->
<div class="d-flex justify-content-between mt-5">
    <h2>Vendas</h2>
    <p>
        <a href="create.php" class="btn btn-success">Registrar</a>
    </p>
</div>
<table class="table table-hover ">
    <thead>
        <tr>
            <th scope="col" class="title">Anexo</th>
            <th scope="col" class="title">Tipo de Pagamento</th>
            <th scope="col" class="title">Data da Venda</th>
            <th scope="col" class="title">Número da Nota</th>
            <th scope="col" class="title">Observação</th>
            <th scope="col" class="title">Data de Registro</th>
            <th scope="col" class="title" >Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (empty($vendas)) : ?>
            <tr>
                <td colspan="7">Nada</td>
            </tr>
        <?php else : ?>

            <?php foreach ($vendas as $i => $venda) : ?>
                <tr> <?php /* dd($vendas); */ ?>
                    <td> <?php //if there's image echo it,if not echo a default image
                            if ($venda['anexo_venda']) : ?>
                            <img src="<?php echo $venda['anexo_venda'] ?>" class="img-thumbnail image" alt="anexo_venda">
                        <?php else : ?>
                            <img src="https://via.placeholder.com/120" class="img-thumbnail img" alt="anexo_venda">
                        <?php endif; ?>
                    </td>
                    <td class="title"><?php echo $venda['tipo_pagamento'] ?></td>
                    <td class="title"><?php echo $venda['data_venda'] ?></td>
                    <td class="title"><?php echo $venda['num_nota'] ?></td>
                    <td class="title"><?php echo $venda['obs'] ?></td>
                    <td class="title"><?php echo $venda['data_registro'] ?></td>
                    <td class="d-flex justify-content-between">
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
<div class="container-fluid">
<table class="table table-hover produtos-table">
    <thead>
        <tr>
            <th scope="col" class="title">Anexo</th>
            <th scope="col" class="title">Nome</th>
            <th scope="col" class="title">Preço</th>
            <th scope="col" class="title">Quantidade</th>
            <th scope="col" class="title">Data de Registro</th>
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
                    <td class="d-flex justify-content-start ">
                    <?php if(isset($produto['anexo_produto'])) : ?>
                        <img src="<?php echo $produto['anexo_produto'] ?>" class="img-thumbnail image"> <?php else : ?>  <img src="https://via.placeholder.com/120" class="img-thumbnail img" alt="anexo_produto"><?php endif; ?>
                    </td>
                    <td class="title"><?php echo $produto['nome'] ?></td>
                    <td class="title"><?php echo $produto['preco'] ?></td>
                    <td class="title"><?php echo $produto['quantidade'] ?></td>
                    <td class="title"><?php echo $venda['data_registro'] ?></td>
                </tr>
                <input type="hidden" name="id" value="<?php echo $produto['id'] ?>">
                <input type="hidden" name="id_venda" value="<?php echo $produto['id_venda'] ?>">
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
</div>