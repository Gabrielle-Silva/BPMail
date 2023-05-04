<head>
    <?php
    ob_start();                      // start capturing output
    include(__ABS_DIR__ . 'css/mensagem.php');   // execute the file
    $cssContent = ob_get_contents();    // get the contents from the buffer
    ob_end_clean();
    echo $cssContent; //traz o css da mensagem
    ?>

</head>

<body id="bodymensagem">

    <table id="mensagemLayout">
        <thead>
            <tr id="corpoMensagem">

                <td>
                    <?= $mensagem ?>
                </td>

            </tr>
            <?php
            if ($preview) {
                echo '<tr id="imgLogo"><td><img src="/' . __REL_LOGO_PATH__  . '" alt="Logo" /></td></tr>';
            } else {
                echo '<tr id="imgLogo"><td><img src="cid:Logo" alt="Logo" /></td></tr>';
            } ?>
        </thead>
        <tr class="linhaHr">
            <td>
                <hr>
            </td>
        </tr>

        <tbody id="assinatura">
            <tr>
                <td class="nomeAssinatura">
                    <p><?= __NOME_ASSINATURA__ ?></p>
                </td>
            </tr>

            <tr>
                <td class="contatoAssinatura">
                    <p><?= __EMAIL_ASSINATURA__ ?> | <?= __TELEFONE_ASSINATURA__ ?></p>
                </td>

            </tr>
        </tbody>

    </table>

</body>