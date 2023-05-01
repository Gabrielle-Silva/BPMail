<?php
//TODO: alterar para config e checar se precisa
require_once('../../lib/config.php');
require_once(__ABS_DIR__ . 'src/model/email.class.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require(__ABS_DIR__ . '/lib/PHPMailer/src/Exception.php');
require(__ABS_DIR__ . '/lib/PHPMailer/src/PHPMailer.php');
require(__ABS_DIR__ . '/lib/PHPMailer/src/SMTP.php');
//TODO:colocar na config
//require('/lib/PHPMailer/src/Exception.php');
//require('/lib/PHPMailer/src/PHPMailer.php');
//require('/lib/PHPMailer/src/SMTP.php');

//instanciar objeto
$objEmail = new emailModel();
//$mail = new PHPMailer(true);


//Colocando valores dos campos dentro do objeto
if (isset($_REQUEST['id'])) {
    $objEmail->setId($_REQUEST['id']);
}

if (isset($_REQUEST['Nome'])) {
    $objEmail->setNome($_REQUEST['Nome']);
    $nome = $_REQUEST['Nome'];
}

if (isset($_REQUEST['Email'])) {
    $objEmail->setEmail($_REQUEST['Email']);
    $email = $_REQUEST['Email'];
}

if (isset($_REQUEST['arrFunc'])) {
    $objEmail->setArrFunc($_REQUEST['arrFunc']);
}


if (isset($_REQUEST['arquivosGeral'])) {
    $arquivosGeral[] = $_REQUEST['arquivosGeral'];
}
$arquivos = [];
if (isset($_REQUEST['arquivos'])) {
    $arquivos = $_REQUEST['arquivos'];
}
if (isset($_REQUEST['arquivosPasta'])) {
    $arquivosPasta = $_REQUEST['arquivosPasta'];
}
if (isset($_REQUEST['assunto'])) {
    $assunto = $_REQUEST['assunto'];
}
if (isset($_REQUEST['copias'])) {
    $copias = $_REQUEST['copias'];
}
if (isset($_REQUEST['mensagem'])) {
    $mensagem = $_REQUEST['mensagem'];
}


$mail = new PHPMailer(true);

$action = $_REQUEST['action'];
switch ($action) {


    case 'read':

        //array com informações dos funcionarios selecionados banco de dados

        $result = $objEmail->read();
        //array com todos os nomes de arquivos na pasta
        $filesName = [];
        foreach (glob(__ABS_DIR__ . __PATH_FILE__ . '/*' . __EXT_FILE__) as $filename) {
            $p = pathinfo(urldecode($filename));
            $filesName[] = $p['filename'];
        }


        require_once(__ABS_DIR__ . 'src/view/emailsList.php');

        break;

    case 'validate':


        $currentPage = $_REQUEST['currentPage'];
        $objValidar = json_decode($_REQUEST['objValidar']);

        require_once(__ABS_DIR__ . 'src/view/validacao.php');


        break;

    case 'preview':


        $email;
        $nome;
        $assunto;
        $copias;
        $mensagem; //criar corpo de mensagem    
        if ($arquivosPasta != "") {
            $arrarquivosPasta = explode(",", $arquivosPasta);
        }
        $_FILES;

        require_once(__ABS_DIR__ . 'src/view/previa.php');


        break;






    case 'sendEmail':
        try {

            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            // Configurações do servidor
            $mail->isSMTP();        //Devine o uso de SMTP no envio
            $mail->SMTPAuth = true; //Habilita a autenticação SMTP
            $mail->Username   = __EMAIL_REMETENTE__;
            $mail->Password   = __EMAIL_SENHA__;
            // Criptografia do envio SSL também é aceito
            $mail->SMTPSecure = 'tls';
            // Informações específicadas
            $mail->Host = 'smtp-mail.outlook.com';
            $mail->Port = 587;
            // Define o remetente                  
            $mail->setFrom(__EMAIL_REMETENTE__, __NOME_ASSINATURA__);
            // Define o destinatário
            //NOTE: ALTERAR PARA --- $mail->addAddress( $email;, $nome;) --- SOMENTE APÓS ESTAR FINALIZADO
            $mail->addAddress('magaligames@hotmail.com', $nome);
            // Conteúdo da mensagem
            $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
            $mail->Subject = $assunto;
            $mail->AddEmbeddedImage(__ABS_DIR__ . '/assets/LogoBPLUS_Branca.png', 'BPlusLogo');
            ob_start();                      // start capturing output
            include(__ABS_DIR__ . 'css/mensagem.php');   // execute the file
            $cssContent = ob_get_contents();    // get the contents from the buffer
            ob_end_clean();
            $texto = '<head>
            ' . $cssContent . '
            
        </head>
        
        <body>
            <table id="MensagemHtml">
                <div id="mensagemLayout">
                    <div id="corpoMensagem">
        
                        ' . $mensagem . '


                        <!-- FIXME: linha abaixo inserida apenas para teste -->
                <p> ( EMAIL TESTE -> O email final iria para:' . $email . ' )</p>
                    </div>
        
                    <div id="imgBPlus"><img src="cid:BPlusLogo" /></div>
        
                    <div id="assinatura">
                        <p>' . __NOME_ASSINATURA__ . '</p>
        
                        <p>' . __EMAIL_ASSINATURA__ . ' | ' . __TELEFONE_ASSINATURA__ . '</p>
                    </div>
                </div>
            </table>
        </body>';
            $mail->Body = $texto;
            $mail->AltBody = strip_tags($texto);
            // Assunto
            $mail->Subject = $assunto;
            // Cópias
            if ($copias) {
                foreach (explode(";", str_replace(" ", "", $copias)) as $copia) {
                    $mail->AddCC($copia, "");
                }
            }
            //Anexos

            $arrDelete = [];
            $arrDeleteErrorTodos = [];
            $arrDeleteErrorFunc = [];

            if ($arquivosPasta != "") {
                if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y"))) {
                    mkdir(__ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y"));
                }
                $arrarquivosPasta = explode(",", $arquivosPasta);
                foreach ($arrarquivosPasta as $ap) {
                    $strFile = $ap . ".pdf";

                    $statusAttachment = $mail->AddAttachment(__ABS_DIR__ . __PATH_FILE__ . $strFile, $strFile);
                    if ($statusAttachment) {
                        copy(__ABS_DIR__ . __PATH_FILE__ . $strFile, __ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y") . '/' . $strFile);
                        $arrDelete[] = $strFile;
                    }
                }
            }

            foreach ($_FILES as $key => $value) {
                for ($i = 0; $i < count($_FILES); $i++) {

                    if (isset($value['name'][$i])) {
                        $statusAttachment =  $mail->AddAttachment($value['tmp_name'][$i], $value['name'][$i]);
                        if (($statusAttachment) && (str_contains($key, 'arquivosGeral'))) {
                            $strPath = 'Enviados' . date("d-m-Y") . '/.Geral';
                            if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . $strPath)) {
                                mkdir(__ABS_DIR__ . __PATH_FILE__ . $strPath);
                            }
                            if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . $strPath . '/' . $value['name'][$i])) {
                                copy($value['tmp_name'][$i], __ABS_DIR__ . __PATH_FILE__ . $strPath . '/' . $value['name'][$i]);
                            }
                        }
                        if (($statusAttachment) && (str_contains($key, 'arquivos' . str_replace(' ', '-', $nome)))) {
                            $strPath = 'Enviados' . date("d-m-Y") . '/' . str_replace(' ', '-', $nome);
                            if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . $strPath)) {
                                mkdir(__ABS_DIR__ . __PATH_FILE__ . $strPath);
                            }

                            copy($value['tmp_name'][$i], __ABS_DIR__ . __PATH_FILE__ . $strPath . '/' . $value['name'][$i]);

                            $arrDeleteErrorFunc[] = $strPath . '/' . $value['name'][$i];
                        }
                    }
                }
            }

            $mail->Priority = 1;

            // Enviar
            $statusSendMail = $mail->send();

            $msgResult = 'Email enviado com sucesso';

            if (($statusSendMail) && (isset($arrDelete))) {
                foreach ($arrDelete as $arq) {

                    unlink(__ABS_DIR__ . __PATH_FILE__ .  $arq);
                }
            }
        } catch (Exception $e) {

            $msgResult = 'O envio do email não foi concluido. Erro: ' . $mail->ErrorInfo;
            if (isset($arrDeleteErrorFunc)) {
                foreach ($arrDeleteErrorFunc as $arqF) {
                    unlink(__ABS_DIR__ . __PATH_FILE__ . $arqF);
                }
            }
        }

        echo '<div>Destinatario: ' . $email . '<br>' . 'Assunto: ' . $assunto . '<br>' . $msgResult . '<br>Data/Hora do envio: ' . date('d/m/Y H:i') . '</div><hr>';

        break;




    default:
        echo 'Erro: Action "' . $action . '" não existe';
        break;
}
