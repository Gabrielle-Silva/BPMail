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

        $preview = true;
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
            $preview = false;
            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            // Configurações do servidor
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Username   = __EMAIL_REMETENTE__;
            $mail->Password   = __EMAIL_SENHA__;
            $mail->SMTPSecure = __SMTP_SECURE__;
            $mail->Host = __HOST__;
            $mail->Port = __PORT__;
            $mail->setFrom(__EMAIL_REMETENTE__, __NOME_ASSINATURA__);


            //$mail->SMTPDebug = 2;
            //NOTE: ALTERAR PARA --- $mail->addAddress( $email;, $nome;) --- SOMENTE APÓS ESTAR FINALIZADO
            $mail->addAddress('magaligames@hotmail.com', $nome);


            // Conteúdo da mensagem
            $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
            $mail->AddEmbeddedImage(__ABS_DIR__ . __REL_LOGO_PATH__, 'Logo');
            //Recupera conteudo do arquivo de mensagem para o corpo do email
            ob_start();
            include(__ABS_DIR__ . 'src/view/mensagem.php');
            $msgContent = ob_get_contents();
            ob_end_clean();
            $texto = $msgContent;
            $mail->Body = $texto;
            $mail->AltBody = strip_tags($texto);
            // Assunto e prioridade
            $mail->Subject = $assunto;
            $mail->Priority = 1;
            // Cópias
            if ($copias) {
                foreach (explode(";", str_replace(" ", "", $copias)) as $copia) {
                    $mail->AddCC($copia, "");
                }
            }
            //Anexos
            $arrDelete = [];
            $arrDeleteErrorFunc = [];
            //Arquivos recuperados da pasta
            if ($arquivosPasta != "") {
                if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y"))) {
                    mkdir(__ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y"));
                }
                $arrarquivosPasta = explode(",", $arquivosPasta);
                foreach ($arrarquivosPasta as $ap) {
                    $strFile = $ap . ".pdf";

                    $statusAttachment = $mail->AddAttachment(__ABS_DIR__ . __PATH_FILE__ . $strFile, $strFile);
                    if ($statusAttachment) {
                        $arrDelete[] = $strFile;
                    }
                }
            }
            //Arquivos de upload
            foreach ($_FILES as $key => $value) {
                if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y"))) {
                    mkdir(__ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y"));
                }
                if (isset($value['name'])) {
                    $statusAttachment =  $mail->AddAttachment($value['tmp_name'], $value['name']);
                    //Anexos gerais
                    if (($statusAttachment) && (str_contains($key, 'arquivosGeral'))) {
                        $strPath = 'Enviados' . date("d-m-Y") . '/.Geral';
                        if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . $strPath)) {
                            mkdir(__ABS_DIR__ . __PATH_FILE__ . $strPath);
                        }
                        if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . $strPath . '/' . $value['name'])) {
                            copy($value['tmp_name'], __ABS_DIR__ . __PATH_FILE__ . $strPath . '/' . $value['name']);
                        }
                    }
                    //Anexos individuais
                    if (($statusAttachment) && (str_contains($key, str_replace(' ', '-', $nome)))) {
                        $strPath = 'Enviados' . date("d-m-Y") . '/' . str_replace(' ', '-', $nome);
                        if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . $strPath)) {
                            mkdir(__ABS_DIR__ . __PATH_FILE__ . $strPath);
                        }
                        copy($value['tmp_name'], __ABS_DIR__ . __PATH_FILE__ . $strPath . '/' . $value['name']);
                        $arrDeleteErrorFunc[] = $strPath . '/' . $value['name'];
                    }
                }
            }


            // Enviar
            $statusSendMail = $mail->send();
            $msgResult = 'Email enviado com sucesso!';

            if (($statusSendMail) && (isset($arrDelete))) {
                foreach ($arrDelete as $arq) {
                    $statusCopy = copy(__ABS_DIR__ . __PATH_FILE__ .  $arq, __ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y") . '/' . $strFile);
                    if ($statusCopy) {
                        unlink(__ABS_DIR__ . __PATH_FILE__ .  $arq);
                    }
                }
            }
        } catch (Exception $e) {
            if (isset($statusSendMail) && $statusSendMail) {
                $msgResult = 'Email enviado, mas foi encontrado um erro: ' . $mail->ErrorInfo;
            } else {
                $msgResult = 'O EMAIL NÃO FOI ENVIADO! ERRO: ' . $mail->ErrorInfo;
                if (isset($arrDeleteErrorFunc)) {
                    foreach ($arrDeleteErrorFunc as $arqF) {
                        unlink(__ABS_DIR__ . __PATH_FILE__ . $arqF);
                    }
                }
            }
        }
        echo '<div>Destinatario: ' . $email . '<br>' . 'Assunto: ' . $assunto . '<br>' . $msgResult . '<br>Data/Hora: ' . date('d/m/Y H:i') . '</div><hr>';
        break;


    default:
        echo 'Erro: Action "' . $action . '" não existe';
        break;
}
