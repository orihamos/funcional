<?php $search = $_GET['search'] ?? ''; ?>

<div class="col-12 d-flex justify-content-end">
    <form class="form-inline d-inline-flex">
        <input class="form-control mr-sm-2" type="text" placeholder="Buscar" aria-label="Search" name="search" value="<?php echo $search ?>">
        <button class="btn btn-secondary" type="submit">Buscar</button>
    </form>
</div>

<?php
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

    //show search results
    if (count($vendas) == 0) {
        echo "<h2>Não foram encontrados resultados para a busca: $search</h2>";
    }

    else{
        foreach ($vendas as $venda): ?>
            <div class="card mb-3">
                <div class="card-header">
                    <h2 class="card-title">Venda: <?= $venda['id'] ?></h2>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>Tipo de Pagamento:</strong> <?= $venda['tipo_pagamento'] ?></p>
                    <p class="card-text"><strong>Data da Venda:</strong> <?= $venda['data_venda'] ?></p>
                    <p class="card-text"><strong>Número da Nota:</strong> <?= $venda['num_nota'] ?></p>
                    <p class="card-text"><strong>Observações:</strong> <?= $venda['obs'] ?></p>
                    <p class="card-text"><strong>Anexo:</strong> <?= $venda['anexo_venda'] ?></p>
                    <h3 class="card-title">Produtos</h3>
                    <div class="row">
                        <?php foreach ($produtos as $produto): ?>
                            <?php if ($produto['id_venda'] == $venda['id']): ?>
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <p class="card-text"><strong>Nome:</strong> <?= $produto['nome'] ?></p>
                                            <p class="card-text"><strong>Preço:</strong> <?= $produto['preco'] ?></p>
                                            <p class="card-text"><strong>Quantidade:</strong> <?= $produto['quantidade'] ?></p>
                                            <p class="card-text"><strong>Anexo:</strong> <?= $produto['anexo_produto'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; 
        exit();
    }

} else {
    $vendas = getVendas($pdo);
    $produtos = getProdutos($pdo);
}
?>


