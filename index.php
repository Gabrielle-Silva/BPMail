<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once('lib/config.php'); ?>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPMail</title>
    <link rel="icon" type="image/x-icon" href="/assets/IconBPmail.png">

    <!--JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!--PDFJS -->
    <script src="/lib/pdfjs-dist/build/pdf.js"></script>
    <!--Font Awesome CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS styles -->
    <link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>

<body>
    <div id="body">


        <!-- Conteudo -->
        <div id="listaFunc"></div>
        <div id="listaEmails" style="display: none;"></div>
        <div id="previa" style="display: none;"><button id="btnBackEmail" type="button" class="btnFixLeft" title="VOLTAR"><i class="fa-solid fa-chevron-left"></i> <i class="fa-solid fa-envelope"></i></button>
            <i class="fa-solid fa-eye icon-page"></i>
            <div class="titulo">
                <h2>PRÉVIA EMAILS</h2>
                <button id="submitEnviar" type="button" class="btnFix" title="ENVIAR"><i class="fa-solid fa-paper-plane"></i> <i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
        <div id="result" style="display: none;"><i class="fa-solid fa-paper-plane icon-page"></i>
            <div class="titulo">
                <h2>RESULTADO EMAILS ENVIADOS</h2>
            </div>
            <div id="resultPrint"></div>
        </div>


        <!-- Modal -->
        <div id="modal-bg">
            <div id="myModal" class="modal">
                <!-- Modal content -->
                <div id="modal-content">
                    <div>
                        <button id="prev" class="btnLow">Previous</button>
                        <button id="next" class="btnLow">Next</button>
                        &nbsp; &nbsp;
                        <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                    </div>
                    <span class="close" on>&times;</span>
                    <div></div>
                </div>
            </div>
        </div>


    </div>

</body>


<!-- loading -->
<div id="spinner" style="display: none;">
    <span class="loader"></span>
</div>

<!-- Scripts -->
<script>
    <?php include_once(__ABS_DIR__ . 'javaScript/email.js'); ?>
    <?php include_once(__ABS_DIR__ . 'javaScript/funcionario.js'); ?>
    <?php include_once(__ABS_DIR__ . 'javaScript/pdfJs.js'); ?>
    <?php include_once(__ABS_DIR__ . 'javaScript/triggers.js'); ?>
</script>



</html>