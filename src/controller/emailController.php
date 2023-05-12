<?php
require_once('../../lib/config.php');
require_once(__ABS_DIR__ . 'src/model/email.class.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//new boj
$objEmail = new emailModel();
if (isset($_REQUEST['arrFunc'])) {
    $objEmail->setArrFunc($_REQUEST['arrFunc']);
}

//normalize string
$transliterator = Transliterator::createFromRules(':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: Lower(); :: NFC;', Transliterator::FORWARD);


if (isset($_REQUEST['Nome'])) {
    $nome = $_REQUEST['Nome'];
}

if (isset($_REQUEST['Email'])) {
    $email = $_REQUEST['Email'];
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
        $result = $objEmail->read();
        //array containig every file on the folder
        $filesName = [];
        foreach (glob(__ABS_DIR__ . __PATH_FILE__ . '/*' . __EXT_FILE__) as $filename) {
            $p = pathinfo(urldecode($filename));
            $filesName[] = $p['filename'];
        }
        require_once(__ABS_DIR__ . 'src/view/emailsList.php');

        break;

        //for file validation - show if contains name and last name inside pdf file attached from folder
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
        $mensagem;
        if ($arquivosPasta != "") {
            $arrarquivosPasta = explode(",", $arquivosPasta);
        }
        $_FILES;
        require_once(__ABS_DIR__ . 'src/view/previa.php');

        break;



    case 'sendEmail':
        try {
            //new obj
            $preview = false;
            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            // server config - set in config file
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
            $mail->addAddress('', $nome);

            //--------email message content
            $mail->isHTML(true);  // set to html
            //image logo on email message body
            $mail->AddEmbeddedImage(__ABS_DIR__ . __REL_LOGO_PATH__, 'Logo');
            //get the content message from file
            ob_start();
            include(__ABS_DIR__ . 'src/view/mensagem.php');
            $msgContent = ob_get_contents();
            ob_end_clean();
            $text = $msgContent;
            //set the content email message
            $mail->Body = $text;
            //strip tags in case doesn't accept html format
            $mail->AltBody = strip_tags($text);

            // subject and priority
            $mail->Subject = $assunto;
            $mail->Priority = 1;
            // Cc
            if ($copias) {
                foreach (explode(";", str_replace(" ", "", $copias)) as $copia) {
                    $mail->AddCC($copia, "");
                }
            }

            //---------attachments
            $arrDelete = [];
            $arrDeleteErrorFunc = [];
            //PDF files from folder
            if ($arquivosPasta != "") {
                //create a folder for emails sent successfully if it doesn't already exist
                if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y"))) {
                    mkdir(__ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y"));
                }

                $arrarquivosPasta = explode(",", $arquivosPasta);
                foreach ($arrarquivosPasta as $ap) {
                    $strFile = $ap . ".pdf";
                    //attach each file in the array
                    $statusAttachment = $mail->AddAttachment(__ABS_DIR__ . __PATH_FILE__ . $strFile, $strFile);
                    //array to keep files names and change folder after email sent
                    if ($statusAttachment) {
                        $arrDelete[] = $strFile;
                    }
                }
            }
            //Uploaded files
            foreach ($_FILES as $key => $value) {
                //create a folder for emails sent successfully if it doesn't already exist
                if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y"))) {
                    mkdir(__ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y"));
                }
                if (isset($value['name'])) {
                    $statusAttachment =  $mail->AddAttachment($value['tmp_name'], $value['name']);
                    //Files attached for everyone
                    if (($statusAttachment) && (str_contains($key, 'arquivosGeral'))) {
                        //create folder and copy file
                        $strPath = 'Enviados' . date("d-m-Y") . '/.Geral';
                        if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . $strPath)) {
                            mkdir(__ABS_DIR__ . __PATH_FILE__ . $strPath);
                        }
                        if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . $strPath . '/' . $value['name'])) {
                            copy($value['tmp_name'], __ABS_DIR__ . __PATH_FILE__ . $strPath . '/' . $value['name']);
                        }
                    }
                    //Files attached individually
                    //create folder and copy file
                    if (($statusAttachment) && (str_contains($key, str_replace(' ', '-', $nome)))) {
                        $strPath = 'Enviados' . date("d-m-Y") . '/' . str_replace(' ', '-', $nome);
                        if (!file_exists(__ABS_DIR__ . __PATH_FILE__ . $strPath)) {
                            mkdir(__ABS_DIR__ . __PATH_FILE__ . $strPath);
                        }
                        copy($value['tmp_name'], __ABS_DIR__ . __PATH_FILE__ . $strPath . '/' . $value['name']);
                        //array with files, to delete from sent folder in case of error to send email
                        $arrDeleteErrorFunc[] = $strPath . '/' . $value['name'];
                    }
                }
            }
            //SEND
            $statusSendMail = $mail->send();

            //If send sucesss
            $msgResult = 'Email enviado com sucesso!';
            if (($statusSendMail) && (isset($arrDelete))) {
                foreach ($arrDelete as $arq) {
                    //copy file to sent folder and delete from origin
                    $statusCopy = copy(__ABS_DIR__ . __PATH_FILE__ .  $arq, __ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y") . '/' . $arq);
                    if ($statusCopy && file_exists(__ABS_DIR__ . __PATH_FILE__ . 'Enviados' . date("d-m-Y") . '/' . $strFile)) {
                        unlink(__ABS_DIR__ . __PATH_FILE__ .  $arq);
                    }
                }
            }
        } catch (Exception $e) {

            if (isset($statusSendMail) && $statusSendMail) {
                //Email was send, but with a error
                $msgResult = 'Email enviado, mas foi encontrado um erro: ' . $mail->ErrorInfo;
            } else {
                //Email wasn't send
                $msgResult = 'O EMAIL NÃO FOI ENVIADO! ERRO: ' . $mail->ErrorInfo;
                //Delete the individual copys file from sent folder
                if (isset($arrDeleteErrorFunc)) {
                    foreach ($arrDeleteErrorFunc as $arqF) {
                        unlink(__ABS_DIR__ . __PATH_FILE__ . $arqF);
                    }
                }
            }
        }

        //Dislayed final status        
        echo '<div>Destinatario: ' . $email . '<br>' . 'Assunto: ' . $assunto . '<br>' . $msgResult . '<br>Data/Hora: ' . date('d/m/Y H:i') . '</div><hr>';
        break;


    default:
        echo 'Erro: Action "' . $action . '" não existe';
        break;
}
