<?php
require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/searchQuery.html.php';
?>

<div class="d-flex justify-content-between mt-5">
    <h2>Vendas</h2>
    <p>
        <a href="create.php" class="btn btn-success">Registrar</a>
    </p>
</div>
<table class="table ">
    <thead>
        <tr>
            <th scope="col" class="title">Anexo</th>
            <th scope="col" class="title">Tipo de Pagamento</th>
            <th scope="col" class="title">Data da Venda</th>
            <th scope="col" class="title">Número da Nota</th>
            <th scope="col" class="title">Observação</th>
            <th scope="col" class="title">Data de Registro</th>
            <th scope="col" class="title">Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (empty($vendas)) : ?>
            <tr>
                <td colspan="7">Nâo há nenhum registro cadastrado</td>
            </tr>
        <?php else : ?>
            <?php foreach ($vendas as $venda) : ?>
                <tr> 
                    <td> <?php 
                            if ($venda['anexo_venda']) : ?>
                            <img src="<?=$venda['anexo_venda'] ?>" class="img-thumbnail image" alt="anexo_venda">
                        <?php else : ?>
                            <img src="https://via.placeholder.com/120" class="img-thumbnail image" alt="anexo_venda">
                        <?php endif; ?>
                    </td>
                    <td class="title"><?=$venda['tipo_pagamento'] ?></td>
                    <td class="title"><?=$venda['data_venda'] ?></td>
                    <td class="title"><?=$venda['num_nota'] ?></td>
                    <td class="title"><?=$venda['obs'] ?></td>
                    <td class="title"><?=$venda['data_registro'] ?></td>
                    <td class="d-flex justify-content-between">
                        <a href="update.php?id=<?=$venda['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                        <form method="post" action="delete.php">
                            <input type="hidden" name="id" value="<?=$venda['id'] ?>">
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
            </tr>
        </thead>
        <tbody>
            <?php
            if (empty($produtos)) : ?>
                <tr>
                    <td colspan="7">Nenhum produto registrado</td>
                </tr>
            <?php else : ?>
                <?php foreach ($produtos as $i => $produto) : ?>
                    <tr>
                        <td class="d-flex justify-content-start ">
                            <?php if (isset($produto['anexo_produto'])) : ?>
                                <img src="<?=$produto['anexo_produto'] ?>" class="img-thumbnail image"> <?php else : ?> <img src="https://via.placeholder.com/120" class="img-thumbnail image" alt="anexo_produto"><?php endif; ?>
                        </td>
                        <td class="title"><?=$produto['nome'] ?></td>
                        <td class="title"><?=$produto['preco'] ?></td>
                        <td class="title"><?=$produto['quantidade'] ?></td>
                    </tr>
                    <input type="hidden" name="id" value="<?=$produto['id'] ?>">
                    <input type="hidden" name="id_venda" value="<?=$produto['id_venda'] ?>">
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>