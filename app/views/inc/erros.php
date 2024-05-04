<?php foreach ($erros as $erro) { ?>

    <div class="alert alert-danger d-flex" role="alert" >
        <div class="flex-grow-1">
            <?php echo $erro ?>
        </div>
        <button type="button" class="btn-close"  aria-label="Close" onclick="fecharAlerta(this)"></button>
    </div>
<?php } ?>