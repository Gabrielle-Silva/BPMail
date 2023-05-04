<i class="fa-solid fa-users-line icon-page"></i>
<div class="titulo">

    <h2>SELECIONAR FUNCIONÁRIOS</h2>
</div>
<div class="select">
    <label class="lblCheck">Todos<input type="checkbox" id="selectall" name="selectall"><span class="checkmarkS"></span></label>
    <label class="lblCheck">PJ<input type="checkbox" id="selecPJ" name="selecPJ"> <span class="checkmarkS"></span></label>
    <label class="lblCheck">CLT<input type="checkbox" id="selectCLT" name="selectCLT"> <span class="checkmarkS"></span></label>
    <label class="lblCheck">Estagio<input type="checkbox" id="selectEstagio" name="selectEstagio"> <span class="checkmarkS"></span></label>
</div>

<button type="button" id="btn-inserirCampos" class="btnLow" title="Novo funcionário"><i class="fa-solid fa-user-plus"></i></button>

<table id="tableFunc">
    <thead id="theadFunc">
        <tr>
            <th>Selecionar</th>
            <th style="width: 15%;">Contrato</th>
            <th style="width: 20%;">Nome</th>
            <th>Email</th>
            <th></th>
            <th></th>
        </tr>

    </thead>

    <tbody id="listaFuncionarios">



        <?php while ($rows = mysqli_fetch_object($result)) { ?>
            <tr id="funcionario<?= $rows->Id ?>" class="trFunc">

                <td><label class="lblCheck"><input type="checkbox" value="<?= $rows->Id ?>" name="select" class="<?= $rows->Contrato ?>"><span class="checkmarkTb"></span></label></td>
                <td><input name="contrato_<?= $rows->Id ?>" value="<?= $rows->Contrato ?>" style="margin-left:10px;" readonly></td>
                <td><input name="nome_<?= $rows->Id ?>" value="<?= $rows->Nome ?>" readonly></td>
                <td><input name="email_<?= $rows->Id ?>" value="    <?= $rows->Email ?>   " type="email" readonly></td>
                <td><button id="btnEditarCampos" data-id="<?= $rows->Id ?>" type="button" class="btnLow" title="EDITAR"><i class="fa-solid fa-pen-to-square"></i></button></td>
                <td><button id="btnDelete" data-id="<?= $rows->Id ?>" type="button" class="btnLow" title="EXCLUIR"><i class="fa-solid fa-user-xmark"></i></button></td>

            </tr>
            <input id="valuesFunc_<?= $rows->Id ?>" type="text" data-nome="<?= $rows->Nome ?>" data-contrato="<?= $rows->Contrato ?>" data-email="<?= $rows->Email ?>" style="Display:none">
        <?php } ?>
    </tbody>
    <button type="button" class="btnFix" id="btnProximo"><i class="fa-solid fa-envelope"> <i class="fa-solid fa-chevron-right"></i></i></button>
</table>