<?php require_once __DIR__ . '/../../phpCode/foreachErrors.php'; ?>
<form class='needs-validation' novalidate method='post'  enctype='multipart/form-data'>
    <h2>Venda</h2>
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
              <img src='<?php echo $venda['anexo_venda']; ?>' class='img-thumbnail w-25' >
              <div class='col-md-4'>
                <label for='anexo_venda' class='form-label'>Mudar anexo</label>
                <input type='file' id='anexo_venda' name='anexo_venda' >
                <div class='valid-feedback'>Valido.</div>
              </div>
            <?php else : ?>
              <div class='col-md-4'>
                <label for='anexo_venda' class='form-label'>Anexo</label>
                <input type='file' id='anexo' name='anexo_venda' >
                <div class='valid-feedback'>Valido.</div>
              </div>
            <?php endif; ?>
          </td>
          <td>
          <select type="text" name="tipo_pagamento" id="tipo_pagamento" class="form-control form-select" required >
          <option disabled selected value> -- escolha uma opção -- </option>
         <?php include_once __DIR__ . "/../../phpCode/tipoPag.php"?>
        </select>
            <div class='valid-feedback'>Valido.</div>
          </td>
          <td>
            <input type='date' class='form-control' id='data_venda' name='data_venda' value='<?php echo $data_venda; ?>' >
            <div class='valid-feedback'>Valido.</div>
          </td>
          <td>
            <input type='number' class='form-control' id='num_nota' name='num_nota' value='<?php echo $num_nota; ?>' required  >
            <div class='valid-feedback'>Valido.</div>
          </td>
          <td>
            <input type='text' class='form-control' id='obs' name='obs' value='<?php echo $obs; ?>'>
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
    <h2>Produto</h2>
    <thead>
      <tr>
        <th scope='col'>Anexo</th>
        <th scope='col'>Nome</th>
        <th scope='col'>Preço</th>
        <th scope='col'>Quantidade</th>
        <th scope='col'><?php echo $data_registro ?? 'Data Atual'; ?></th>
      </tr>
    </thead>
    <tbody id="formulario-produto" > 
      <?php foreach ($produtos as $produto) : ?>
          <?php if (isset($produto['id'])) : ?>
            <input type='hidden' name='id[]' value="<?php echo $produto['id']?>">
          <?php endif; ?>
          <tr>
            <td>
              <?php if ($produto['anexo_produto']) : ?>
                <img src='<?php echo $produto['anexo_produto']; ?>' class='img-thumbnail w-25' >
                <div class='col-md-4'>
                  <label for='anexo_produto' >Mudar anexo</label>
                  <input type='file' id='anexo_produto' name='anexo_produto[]' >
                  <div class='valid-feedback'>Valido.</div>
                </div>
              <?php else : ?>
                <div class='col-md-4'>
                  <label for='anexo_produto' >Adicionar anexo</label>
                  <input type='file' id='anexo_produto' name='anexo_produto[]' >
                  <div class='valid-feedback'>Valido.</div>
                </div>
              <?php endif; ?>
            </td>
            <td>
              <input type='text' class='form-control'  name='nome[]' value="<?php echo $produto['nome']?>" required>
              <div class='valid-feedback'>Valido.</div>
            </td>
            <td>
              <input type='number' step="0.1" class='form-control' id='preco' name='preco[]' value="<?php echo $produto['preco']?>"  required >
              <div class='valid-feedback'>Valido.</div>
            </td>
            <td>
              <input type='number' class='form-control' id='quantidade' name="quantidade[]" value="<?php echo $produto['quantidade']?>" required > 
              <div class='valid-feedback'>Valido.</div>
            </td>
            <td>
              <?php if (isset($produto['data_registro'])) {
                echo $produto['data_registro'];
              } else {
                echo date('Y-m-d H');
              } ?>
            </td>
          </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
   <button type="button"  id="add-button" class="btn btn-primary">+</button>
        <button class='btn btn-primary' type='submit'>Salvar</button>
</form>


