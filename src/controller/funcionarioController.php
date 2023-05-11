<?php
require_once('../../lib/config.php');
require_once(__ABS_DIR__ . 'src/model/funcionario.class.php');

//new obj
$objFuncionario = new funcionarioModel();

if (isset($_REQUEST['id'])) {
    $objFuncionario->setId($_REQUEST['id']);
}

if (isset($_REQUEST['Contrato'])) {
    $objFuncionario->setContrato($_REQUEST['Contrato']);
}

if (isset($_REQUEST['Nome'])) {
    $objFuncionario->setNome($_REQUEST['Nome']);
}

if (isset($_REQUEST['Email'])) {
    $objFuncionario->setEmail($_REQUEST['Email']);
}



$action = $_REQUEST['action'];
switch ($action) {

    case 'insert':
        if ($objFuncionario->createFuncionario() === true) {
            $msgResultPositive = 'Funcionário adicionado com sucesso';
        } else {
            $msgResultNegative = 'Erro: não foi possivel inserir o funcionario';
        }
        require_once(__ABS_DIR__ . 'src/view/statusMessage.php');

        break;

    case 'read':
        $result = $objFuncionario->readFuncionario();
        require_once(__ABS_DIR__ . 'src/view/funcionariosList.php');

        break;

    case 'edit':
        if ($objFuncionario->updateFuncionario() === true) {
            $msgResultPositive = 'Dados alterados com sucesso';
        } else {
            $msgResultNegative = 'Erro: Não foi possivel alterar os dados';
        }

        break;


    case 'delete':
        if ($objFuncionario->deleteFuncionario() === true) {
            $msgResultPositive = 'Dados de funcionário excluidos com sucesso';
        } else {
            $msgResultNegative = 'Erro: Não foi possivel excluir o funcionário';
        }

        break;

    default:
        echo 'Erro: Action "' . $action . '" não existe';
        break;
}
