<i class="fa-solid fa-envelope icon-page"></i>
<button id="btnBackEmp" type="button" class="btnFixLeft" title="VOLTAR"><i class="fa-solid fa-chevron-left"></i> <i class="fa-solid fa-users-line"></i></button>

<hr>
<div class="titulo">
    <h2>CONFIGURAÇÕES GERAIS</h2>
</div>
<button type="button" id="btn-reload" class="btnLow" title="RECARREGAR"><i class="fa-solid fa-rotate-right"></i></button>
<div class="h4">
    <h4>Mensagem</h4>
</div>
<div class="sessao">
    <div class="h5">
        <h5>Inicio do Email</h5>
    </div>
    <div id="inicioEmail">
        <input type="text" name="saudacao" id="saudacao" class="fisrt"> <button type="button" name="switch" id="btnSwitch" class="btnLow" title="Inverter ordem"><i class="fa-solid fa-arrow-right-arrow-left"></i></button> <input type="text" id="tempNome" value="**Nome**" readonly> <span class="btnLow">=</span> <input type="text" id="saudacaoResult" readonly>
    </div>
    <div class="h5">
        <h5>Mensagem</h5>
    </div>
    <textarea name="mensagemGeral" id="mensagemGeral" cols="30" rows="10"></textarea>
    <div class="h5">
        <h5>Assunto</h5>
    </div>
    <input type="text" name="assuntoGeral" id="assuntoGeral" value="">
    <P class="instrucoes">Clique em "APLICAR A TODOS" para adicionar as definições acima nos campos de emails de todos os funcionários selecionados. Voce também pode alterar as definições individualmente abaixo.</P>
    <P class="instrucoes">Ao clicar em "LIMPAR TODOS" serão esvaziados todos os campos de mensagem e assunto de cada funcionário individualmente.</P>
    <div class="buttons">
        <button type="button" id="limpaTodos" class="btnLow">Limpar todas Mensagens</button>
        <button type="button" id="aplicaTodos" class="btnLow">Aplicar a todas as mensagens</button>
    </div>
</div>
<form enctype="multipart/form-data" method="post" id="FormGeral">

    <div class="sessao">
        <div class="h4">
            <h4>Cópias</h4>
        </div>
        <input type="text" name="copias" id="copias" value="">
        <P class="instrucoes">Insira aqui emails que deseja adicionar como cópia separando-os com ";"</P>
    </div>
    <div class="sessao">
        <div class="h4">
            <h4>Anexos Gerais</h4>
        </div>
        <label for="arquivosGeral" id="arquivosGeralLabel"><a class="btn-sec" role="button" aria-disabled="false"><i class="fa-solid fa-paperclip"></i> Anexar para todos</a></label>
        <input type="file" name="arquivosGeral[]" id="arquivosGeral" value="" class="hideIputFiles" multiple>
        <p id="files-area">
            <span id="filesList">
                <span id="files-names" class="todos"></span>
            </span>
        </p>
        <P class="instrucoes">Os arquivos inseridos aqui serão enviados como anexo para todos os funcionários selecionados abaixo</P>
    </div>


</form>
<div class="sessao validarTodos">
    <button type="button" id="btnValidaTodos">VALIDAR TODOS ARQUIVOS AUTOMATICOS</button>
    <P class="instrucoes">Valida todos os documentos incluidos automaticamente através da pasta "Arquivos"</P>
</div>
<hr>
<div class="titulo">
    <h2>CONFIGURAÇÕES INDIVIDUAIS</h2>
</div>

<?php
//Verifica se SQL retornou resultado. Caso contrario, nenhum funcionário foi selecionado
if (!$result) { ?>
    <h2 style="color: red;text-align: center;">ERRO! NENHUM FUNCIONARIO SELECIONADO</h2>

    <?php
} else {
    //Cria um form para cada funcionário selecionado 
    while ($rows = odbc_fetch_object($result)) { ?>
        <form action="" method="post" id="FormEmail" class="<?= $rows->Id ?>" enctype="multipart/form-data">
            <input name="Nome" id="Nome" class="<?= $rows->Id ?>" value="<?= $rows->Nome ?>" readonly>
            <input name="Email" id="Email" class="<?= $rows->Id ?>" value="<?= $rows->Email ?>" readonly>
            <input type="text" name="assunto" id="assunto" class="<?= $rows->Id ?>" placeholder="Assunto" value="">
            <div class="h5">
                <h5>Mensagem</h5>
            </div>
            <textarea id="mensagem" name="mensagem" class="<?= $rows->Id ?>" rows="10"></textarea>
            <div class="h5">
                <h5>Arquivos</h5>
            </div>
            <div id="ArquivosPasta" class="<?= $rows->Id ?>">
                <?php
                //Divide nome e sobrenome
                $primeiroNome = explode(" ", $rows->Nome)[0];
                $sobrenome = explode(" ", $rows->Nome)[1];
                //Cria um array para colocar nomes dos pdfs encontrados na pasta de arquivos
                $Files = [];

                foreach ($filesName as $fileName) {

                    // Para cada documento encontrado, verifica se há Nome e Sobrenome do funcionário no nome do arquivo - Se sim, insere o nome no array $Files[] para ser enviado
                    if ((str_contains(strtoupper($fileName), strtoupper($primeiroNome))) && (str_contains(strtoupper($fileName), strtoupper($sobrenome)))) {
                ?>
                        <div id="ArquivoPdfPasta" class="<?= $rows->Id ?> <?= str_replace(' ', '', $fileName) ?> sessao" data-id="<?= $rows->Id ?>" data-nomeArquivo="<?= $fileName ?>" data-nome="<?= $primeiroNome ?>" data-sobrenome="<?= $sobrenome ?>">
                            <div class="nomeArquivo"> <?= $fileName ?>.pdf </div>
                            <div id="oblvalidar" style="display: none;">
                                <div class="paginas <?= str_replace(' ', '', $fileName) ?>">?<span>Paginas</span></div>
                                <div class="conteudopg <?= str_replace(' ', '', $fileName) ?>"></div>
                            </div>
                        </div>



                <?php

                        $Files[] = $fileName;
                    }
                }
                //transforma array em string para ser enviado através de js ajax
                $FilesStr = implode(",", $Files);
                ?>


            </div>
            <div class="sessao" style="margin: 3px;">
                <label for="arquivos<?= $rows->Id ?>" id="arquivosLabel" data-id="<?= $rows->Id ?>" data-nome="<?= $rows->Nome ?>"><a class="btn-sec" role="button" aria-disabled="false"><i class="fa-solid fa-file-circle-plus"></i> Anexar para <?= $primeiroNome ?></a></label>
                <input type="file" name="arquivos[]" id="arquivos<?= $rows->Id ?>" value="" class="<?= $rows->Id ?> N<?= str_replace(' ', '', $rows->Nome) ?> hideIputFiles" multiple>
                <p id="files-area">
                    <span id="filesList">
                        <span id="files-names" class="N<?= str_replace(' ', '', $rows->Nome) ?>"></span>
                    </span>
                </p>
            </div>
            <input type="text" id="emailsData" style="Display:none;" data-id="<?= $rows->Id ?>" data-nome="<?= $rows->Nome ?>" data-listaArquivos="<?= $FilesStr ?>">
        </form>


<?php }
} ?>
<button id="submitPrevia" type="button" class="btnFix" title="PRÉVIA"><i class="fa-solid fa-eye"></i><i class="fa-solid fa-chevron-right"></i></button>


<script>