<?php if ((isset($msgResultPositive)) && ($msgResultPositive != '')) { ?>
    <div class="alert alert-success">
        <h4 class="alert-heading">Sucesso!</h4>
        <hr>
        <p class="alert-message"><?= $msgResultPositive ?></p>

    </div>
<?php } ?>

<?php if ((isset($msgResultNegative)) && ($msgResultNegative != '')) { ?>
    <div class="alert alert-error" onshow="console.log('aq')">
        <h4 class="alert-heading">Erro:</h4>
        <hr>
        <p class="alert-message"><?= $msgResultNegative ?></p>

    </div>
<?php } ?>