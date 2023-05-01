<!-- NOTE: Ao atualizar esta tela, apenas irá alterar a sessão de prévia do email. Para alterar a mensagem enviada no email deve-se modificar a variavel $texto em emailController > action sendEmail -->

<head>
    <?php
    ob_start();                      // start capturing output
    include(__ABS_DIR__ . 'css/mensagem.php');   // execute the file
    $cssContent = ob_get_contents();    // get the contents from the buffer
    ob_end_clean();
    echo $cssContent; //traz o css da mensagem
    ?>

</head>

<body>
    <div id="MensagemHtml">
        <div id="mensagemLayout">
            <div id="corpoMensagem">

                <?= $mensagem ?>

            </div>

            <div id="imgBPlus"><img src="/assets/LogoBPLUS_Branca.png" alt="" /></div>

            <div id="assinatura">
                <p><?= __NOME_ASSINATURA__ ?></p>

                <p><?= __EMAIL_ASSINATURA__ ?> | <?= __TELEFONE_ASSINATURA__ ?></p>
            </div>
        </div>
    </div>
</body>