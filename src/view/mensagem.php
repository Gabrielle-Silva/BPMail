<!-- CORPO DO EMAIL A SER ENVIADO. NOTE: há uma diferença na visualização entre outlook office e navegador/mobile ou outros metodos, portanto deve-se haver cautela ao alterar os estilos da mensagem-->

<head>
    <style>
        td {
            width: 500px;
            border: 0;
        }

        p {
            font-family: sans-serif;
            margin: 4px;
        }

        tr {
            padding: 0;
        }

        #imgLogo {
            margin: 0 auto;
            text-align: center;
        }

        div {
            padding-bottom: 8px;
        }
    </style>
</head>

<body style="text-align: center">

    <table cellspacing="0" cellpadding="0" style="
				text-align: center;
				border-spacing: 0;
				border-collapse: collapse;
				margin: 30px auto;
				background-color: #0d0e1e;
				border: 20px solid rgb(238, 238, 238);
			">

        <tr>
            <td style="padding: 32px 32px 0px 32px; color: white; font-size: 16px;">
                <div> <?= $intro = explode("</p>", $mensagem)[0] . "</p>"; ?></div>

            </td>
        </tr>
        <tr>
            <td style="padding: 10px 32px 0px 32px; color: white; font-size: 16px;">
                <div> <?= str_replace($intro, "", $mensagem); ?></div>

            </td>

        </tr>

        <?php
        if ($preview) {
            echo '<tr id="imgLogo">&nbsp;<td style="padding: 32px 32px 0px 32px"><div><img src="/' . __REL_LOGO_PATH__  . '" alt="Logo" /></div></td>&nbsp;</tr>';
        } else {
            echo '<tr id="imgLogo">&nbsp;<td style="padding: 32px 32px 0px 32px"><div><img src="cid:Logo" alt="Logo" /></div></td>&nbsp;</tr>';
        } ?>
        <tr>&nbsp;
            <td padding: 3px 0px 0px 0px;>
                <div>
                    <hr size="1">
                </div>
            </td>
            &nbsp;
        </tr>
        <tr>
            <td class="nomeAssinatura" style="font-size: 16px; color: white; padding: 0px 32px 0px 32px">
                <p><?= __NOME_ASSINATURA__ ?></p>
            </td>
        </tr>
        <tr>
            <td class="contatoAssinatura" style="
							font-size: 12px;
							color: rgb(177, 177, 177);
							padding: 0px 32px 28px 32px;
						">
                <p><?= __EMAIL_ASSINATURA__ ?> | <?= __TELEFONE_ASSINATURA__ ?></p>&nbsp;
            </td>


        </tr>
    </table>


</body>