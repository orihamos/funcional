<select name="tipo_pagamento" id="tipo_pagamento" class="form-control form-select" required>
    <option disabled <?php if (!isset($venda["tipo_pagamento"])) echo 'selected'; ?> value=""> -- escolha uma opção -- </option>
    <?php
    $options = ["Dinheiro", "Cartão de Crédito", "Cartão de Débito", "PIX","Outro"];
    if (isset($venda["tipo_pagamento"]) && !in_array($venda["tipo_pagamento"], $options)) {
        array_push($options, $venda["tipo_pagamento"]);
    }
    $selected = isset($venda["tipo_pagamento"]) ? $venda["tipo_pagamento"] : null;
    foreach ($options as $option) {
        if ($option === $selected) {
            echo '<option value="' . $option . '" selected>' . $option . '</option>';
        } else {
            echo '<option value="' . $option . '">' . $option . '</option>';
        }
    }
    ?>
</select>
<input type="text" name="outro_tipo_pagamento" id="outro_tipo_pagamento" class="form-control" placeholder="Descreva">
