<h4 class="nomePrevia"><?= $nome ?></h4>
<form action="" method="post" id="previaForm">

    <label for="emailPrevia" class="previa">Para</label><input type="text" name="emailPrevia" id="emailPrevia" value="<?= $email ?>" readonly>
    <label for="copiasPrevia" class="previa">Cc</label><input type="text" name="copiasPrevia" id="copiasPrevia" value="<?= $copias ?>" readonly>
    <label for="assuntoPrevia" class="previa">Assunto</label><input type="text" id="assuntoPrevia" name="assuntoPrevia" value="<?= $assunto ?>" readonly>
    <label for="anexos" class="previa">Anexos</label>
    <div id="anexos" name="anexos">

        <?php if (isset($arrarquivosPasta)) {
            foreach ($arrarquivosPasta as $ap) { ?>

                <input type="text" class="anexo" value="<?= $ap ?>.pdf">
            <?php }
        }
        foreach ($_FILES as $key => $value) {

            if (str_contains($key, 'arquivosGeral')) {
            ?>

                <input type="text" class="anexo" value="<?= $value['name']; ?>">

            <?php
            }
            if (str_contains($key, 'arquivos' . str_replace(' ', '-', $nome))) {
            ?>

                <input type="text" class="anexo" value="<?= $value['name']; ?>">

        <?php
            }
        }
        ?>
    </div>



    <div id="mensagem"><?php require_once(__ABS_DIR__ . 'src/view/mensagem.php'); ?></div>

</form>
<hr>