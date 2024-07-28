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
        padding: 10px 0 20px 0px;
        box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-around;
        align-items: center;
        z-index: 1000;
        flex-direction: column;
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

    .footer-bar .btn {
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: auto;
        height: 60px;
        font-size: 14px;

    }

    .footer-bar .btn.active {
        background-color: #007bff;
        /* Active color */
    }

    .footer-bar .btn i {
        margin-bottom: 5px;
        font-size: 20px;
    }

    .fixed-bottom-btn {
        width: 70px;
        height: 70px;
        font-size: 20px;
    }

    @media (min-width: 768px) {
        .footer-bar .btn {
            width: auto;
            height: auto;
            font-size: 16px;
            border-radius: 5px;
            padding: 10px 20px;
        }

        .footer-bar .btn i {
            margin-bottom: 0;
        }

        .fixed-bottom-btn {
            width: auto;
            height: auto;
            font-size: 16px;
            border-radius: 5px;
            padding: 10px 20px;
        }
    }

    .card-body {
        background-color: #ECCBAC;
    }

    .lista-item {
        margin-bottom: 10px;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
</style>


<div class="card mt-2 mb-4">
    <div class="card-body">
        <h5 class="card-title">No total</h5>
        <?php if ($saldo > 0) { ?>
            <?= $amigo->username ?> deve a você <span class="deveAvoce">R$
                <?= number_format($saldo, 2, ',', '.') ?></span>
        <?php } else { ?>
            você deve <span class="deveAvoce">R$ <?= number_format($saldo * -1, 2, ',', '.') ?> a
                <?= $amigo->username ?></span>
        <?php } ?>
    </div>
</div>

<ul class="list-group">
    <?php foreach ($detalhe as $item) { ?>
        <li class="list-group-item lista-item">
            <div class="d-flex justify-content-between">
                <div>
                    <strong>Tipo:</strong> <?= ucfirst($item->tipo) ?>
                </div>
                <div>
                    <strong>Data:</strong> <?= date('d/m/Y H:i:s', strtotime($item->data)) ?>
                </div>
            </div>
            <div>
                <strong>Descrição:</strong> <?= $item->descricao ?>
            </div>
            <div>
                <?php if ($item->valor > 0) { ?>
                    <strong class="deveAvoce">R$ <?= number_format($item->valor, 2, ',', '.') ?></strong>
                <?php } else { ?>
                    <strong class="voceDeve">R$ <?= number_format(abs($item->valor), 2, ',', '.') ?></strong>
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