<?php
//TODO: alterar para config e checar se precisa
require_once('../../lib/config.php');
require_once(__ABS_DIR__ . 'src/model/funcionario.class.php');


//instanciar objeto
$objFuncionario = new funcionarioModel();


//Colocando valores dos campos dentro do objeto
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

    case 'read':


        $result = $objFuncionario->readFuncionario();
        require_once(__ABS_DIR__ . 'src/view/funcionariosList.php');

        break;

    case 'delete':

        if ($objFuncionario->deleteFuncionario() === true) {
            //$msgResultPositive = 'Dados excluidos com sucesso';
        } else {
            //$msgResultNegative = 'Erro ao excluir';
        }


        break;

    case 'insert':

        if ($objFuncionario->createFuncionario() === true) {
            //$msgResultPositive = 'Dados excluidos com sucesso';
        } else {
            //$msgResultNegative = 'Erro ao excluir';
        }


        break;

    case 'edit':

        if ($objFuncionario->updateFuncionario() === true) {
            //$msgResultPositive = 'Dados excluidos com sucesso';
        } else {
            //$msgResultNegative = 'Erro ao excluir';
        }


        break;





    default:
        echo 'Erro: Action "' . $action . '" não existe';
        break;
}
