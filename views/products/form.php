<?php require_once __DIR__ . '/../../phpCode/foreachErrors.php'; ?>
<form class='needs-validation' novalidate method='post' enctype='multipart/form-data'>
  <h3>Venda</h3>
  <table class='table'>
    <thead>
      <tr>
        <th scope='col'>Anexo</th>
        <th scope='col'>Tipo de pagamento</th>
        <th scope='col'>Data da venda</th>
        <th scope='col'>Número da nota</th>
        <th scope='col'>Observação</th>
        <th scope='col'><?php echo $data_registro ?? 'Data Atual'; ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <?php if ($venda['anexo_venda']) : ?>
            <img src='<?= $venda['anexo_venda']; ?>' class='img-thumbnail image'>
            <div class='col-md-3'>
              <label for='anexo_venda' class='form-label'>Mudar anexo</label>
              <input type='file' id='anexo_venda' name='anexo_venda'>
              <div class='valid-feedback'>Valido.</div>
            </div>
          <?php else : ?>
            <div class='col-md-3'>
              <label for='anexo_venda' class='form-label'>Anexo</label>
              <input type='file' id='anexo' name='anexo_venda'>
              <div class='valid-feedback'>Valido.</div>
            </div>
          <?php endif; ?>
        </td>
        <td>
          <select name="tipo_pagamento" id="tipo_pagamento" class="form-control form-select" required>
            <option disabled selected value> -- escolha uma opção -- </option>
            <?php include_once __DIR__ . "/../../phpCode/tipoPag.php" ?>
          </select>
          <div class='valid-feedback'>Valido.</div>
        </td>
        <td>
          <input type='date' class='form-control' id='data_venda' name='data_venda' value='<?= $data_venda; ?>'>
          <div class='valid-feedback'>Valido.</div>
        </td>
        <td>
          <input type='number' class='form-control' id='num_nota' name='num_nota' value='<?= $num_nota; ?>' required>
          <div class='valid-feedback'>Valido.</div>
        </td>
        <td>
          <input type='text' class='form-control' id='obs' name='obs' value='<?= $obs; ?>'>
          <div class='valid-feedback'>Valido.</div>
        </td>
        <td>
          <?php if (isset($venda['data_registro'])) {
            echo $venda['data_registro'];
          } else {
            echo date('Y-m-d H');
          } ?>
        </td>
      </tr>
    </tbody>
  </table>
  <table class='table'>
    <h3>Produto</h3>
    <thead>
      <tr>
        <th scope='col'>Anexo</th>
        <th scope='col'>Nome</th>
        <th scope='col'>Preço</th>
        <th scope='col'>Quantidade</th>
      </tr>
    </thead>
    <tbody id="formulario-produto">
      <?php foreach ($produtos as $index => $produto) : ?>
        <?php if (isset($produto['id'])) : ?>
          <input type='hidden' name='id_venda[]' value="<?=$produto['id_venda'] ?>">
          <input type='hidden' name='id[]' value="<?=$produto['id'] ?>">
        <?php endif; ?>
        <tr>
          <td>
            <?php if ($produto['anexo_produto']) : ?>
              <img src='<?=$produto['anexo_produto']; ?>' class='img-thumbnail image'>
              <div class='col-md-3'>
                <label for='anexo_produto'>Mudar anexo</label>
                <input type='file' id='anexo_produto' name='anexo_produto[]'>
                <div class='valid-feedback'>Valido.</div>
              </div>
            <?php else : ?>
              <div class='col-md-3'>
                <label for='anexo_produto'>Adicionar anexo</label>
                <input type='file' id='anexo_produto' name='anexo_produto[]'>
                <div class='valid-feedback'>Valido.</div>
              </div>
            <?php endif; ?>
          </td>
          <td>
            <input type='text' class='form-control' name='nome[]' value="<?=$produto['nome'] ?>" required>
            <div class='valid-feedback'>Valido.</div>
          </td>
          <td>
            <input type='number' step="0.1" class='form-control' id='preco' name='preco[]' value="<?=$produto['preco'] ?>" required>
            <div class='valid-feedback'>Valido.</div>
          </td>
          <td>
            <input type='number' class='form-control' id='quantidade' name="quantidade[]" value="<?=$produto['quantidade'] ?>" required>
            <div class='valid-feedback'>Valido.</div>
          </td>
          <td>
            <?php if (count($produtos) > 1) : ?>
              <button type="submit" name="delete-produto" value="<?php echo  $produto['id'] ?? '' ?>">Delete</button>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      <button type="button" id="add-button" class="btn btn-primary">+</button>
<!--       <button type="button" id="remove-button" class="btn btn-danger mx-1 remove-button">-</button>
 -->    </tbody>
  </table>
  <div class="container-fluid  d-flex">
    <div class="container-fluid  d-flex justify-content-end">
      <button type="submit" class="btn btn-lg btn-primary ">Salvar</button>
    </div>
  </div>
</form>