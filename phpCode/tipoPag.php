<?php
$options = ["Dinheiro", "Cartão de Crédito", "Cartão de Débito","PIX"];
$selected = "";
if (isset($_POST["tipo_pagamento"])) {
    $selected = $_POST["tipo_pagamento"];
}
foreach ($options as $option) {
    if ($option == $selected) {
        echo '<option value="' .
            $option .
            '" selected>' .
            $option .
            "</option>";
    } else {
        echo '<option value="' . $option . '">' . $option . "</option>";
    }
}
