<style>
    ul li {
        list-style-type: none;
        padding-left: 0;
    }

    .grupo {
        margin-top: 10px;
        background-color: #f1f1f1;
        padding: 8px;
    }

    .lista {
        padding: 0px;
    }



    .footer-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #ffffff;
        padding: 10px 0;
        box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-around;
        align-items: center;
        z-index: 1000;
    }


    .lista-item {
        margin-bottom: 10px;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .deleted {
        background-color: #dddddd;
    }

    .fundo-tabela {
        height: 100px;
    }
</style>


<div class="card mt-2 mb-4">
    <div class="card-body">
        <div class="profile-image" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
            <img src="<?= (!empty($amigo->foto_perfil)) ? URL_IMAGEM_150 . $amigo->foto_perfil : URL_BASE . "assets/img/avatares/avatar" . $amigo->avatar . ".jpg" ?>"
                alt="Profile Image" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
        </div>
        <?php if (abs($saldo) > 0) { ?>
            <h5 class="card-title">No total</h5>
            <div>
                <?php if ($saldo > 0) { ?>
                    <?= (empty($amigo->username)) ? $amigo->email : $amigo->username ?> deve a você <span class="deveAvoce"
                        id="total">R$
                        <?= number_format($saldo, 2, ',', '.') ?></span>
                <?php } else { ?>
                    você deve <span class="voceDeve" id="total">R$ <?= number_format($saldo * -1, 2, ',', '.') ?> a
                        <?= (empty($amigo->username)) ? $amigo->email : $amigo->username ?></span>
                <?php } ?>
            </div>
        <?php } else { ?>
            <br>Você não possui dividas com <?= (empty($amigo->username)) ? $amigo->email : $amigo->username ?>
        <?php } ?>
    </div>
</div>
<ul class="list-group">
    <?php foreach ($detalhe as $item) { ?>
        <li class="list-group-item lista-item <?php echo ($item->ativo == 0) ? 'deleted' : '' ?>"
            id="despesa-<?php echo $item->despesas_id; ?>">
            <?= ($item->ativo == 0) ? '<strong> Deletado</strong>' : '' ?>
            <div class="d-flex justify-content-between">
                <div>
                    <strong>Tipo:</strong> <?= ucfirst($item->tipo) ?> 
                </div>
                <div>
                    <strong>Data:</strong> <?= date('d/m/Y H:i:s', strtotime($item->data)) ?>
                </div>
            </div>
            <div>
                <div>
                    <strong>Descrição:</strong> <?= $item->descricao ?>
                </div>

            </div>
            <div class="row">
                <div class="col-8">
                    <?php if ($item->valor > 0) { ?>
                        <strong class="deveAvoce">R$ <?= number_format($item->valor, 2, ',', '.') ?></strong>
                    <?php } else { ?>
                        <strong class="voceDeve">R$ <?= number_format(abs($item->valor), 2, ',', '.') ?></strong>
                    <?php } ?>
                </div>

                <?php if ($item->despesas_id > 0) { ?>
                    <?php if ($item->ativo == 1) { ?>
                        <div class="col-4">
                            <a href="<?php echo URL_BASE . 'despesas/desativa/' . $item->despesas_id . '/' . $amigo->users_uid ?>"
                                class="btn btn-outline-danger btn-sm">Deletar</a>
                        </div>
                    <?php } else { ?>
                        <div class="col-4">
                            <a href="<?php echo URL_BASE . 'despesas/ativar/' . $item->despesas_id . '/' . $amigo->users_uid ?>"
                                class="btn btn-outline-info btn-sm">Recuperar</a>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <?php if (!empty($item->grupos_nome)) { ?>
                <div>
                    <strong>Grupo:</strong> <?= $item->grupos_nome ?>
                </div>
            <?php } ?>
        </li>
    <?php } ?>
</ul>

<div class="fundo-tabela"></div>
<div class="footer-bar">
    <div class="footer-bar2">
        <a href="<?php echo URL_BASE ?>" class="btn btn-outline-secondary">Voltar</a>

        <?php if ($saldo > 0) { ?>
            <a href="<?php echo URL_BASE . 'pagamentos/quitar/' . $saldo . '/' . $amigo->users_uid . '/' . $_SESSION['uid'] ?>"
                class="btn btn-outline-secondary">Quitar divida</a>
        <?php } else { ?>
            <a href="<?php echo URL_BASE . 'pagamentos/quitar/' . $saldo . '/' . $_SESSION['uid'] . '/' . $amigo->users_uid ?>"
                class="btn btn-outline-secondary">Quitar divida</a>
        <?php } ?>

    </div>
</div>