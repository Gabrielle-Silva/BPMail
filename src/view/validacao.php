<html>

<?php

foreach ($objValidar as $key => $obj) {

    //$json = json_encode($objValidar);
    if ($obj->nome[1]) {
        $validateNome = '<i class="fa-solid fa-circle-check" style="color: #118f00;"></i>';
    } else {
        $validateNome = '<i class="fa-solid fa-triangle-exclamation" style="color: #b80000;"></i>';
    }
    if ($obj->sobrenome[1]) {
        $validateSobrenome = '<i class="fa-solid fa-circle-check" style="color: #118f00;"></i>';
    } else {
        $validateSobrenome = '<i class="fa-solid fa-triangle-exclamation" style="color: #b80000;"></i>';
    }
?>


    <div>Conteudo pagina <?= $key ?>: <div class="validaNome"><?= $obj->nome[0] ?> <?= $validateNome ?> </div>
        <div class="validaSobrenome"><?= $obj->sobrenome[0] ?> <?= $validateSobrenome ?></div>
    </div>


<?php }
?>


</html>