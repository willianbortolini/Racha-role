<style>
    .deveAvoce {
        color: #00a5a5;
    }

    .voceDeve {
        color: #f79b0c;
    }

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

    .footer-bar2 {
        display: flex;
        width: 100%;
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
</style>
<h5>No total,
    <?php if ($saldo > 0) { ?>
        <?= $amigo->username ?> deve a você <span class="deveAvoce">R$ <?= number_format($saldo, 2, ',', '.') ?></span>
    <?php } else { ?>
        você deve <span class="deveAvoce">R$ <?= number_format($saldo * -1, 2, ',', '.') ?> a <?= $amigo->username ?></span>
    <?php } ?>
</h5>

<ul class="lista">
    <?php foreach ($detalhe as $item) { ?>

        <li>
            <?php if ($item->tipo == 'pagamento') { ?>
                <?php if ($item->valor > 0) { ?>
                    <?= $amigo->username ?>
                    pagou
                    <span class="deveAvoce"> R$
                        <?php echo moedaBr($item->valor) ?>
                    </span>
                    a você, <?= $item->descricao ?>                    
                <?php } else { ?>
                    Você pagou
                    <span class="voceDeve"> R$
                        <?php echo moedaBr(abs($item->valor)) ?>
                    </span>
                    para
                    <?= $amigo->username ?>, <?= $item->descricao ?>  
                    </span>
                <?php } ?>
            <?php } else { ?>
                <?php if ($item->valor > 0) { ?>
                    Você emprestou
                    <span class="voceDeve"> R$
                        <?php echo moedaBr($item->valor) ?>
                    </span>
                    para
                    <?= $amigo->username ?>, <?= $item->descricao ?>  
                    </span>
                <?php } else { ?>
                    <?= $amigo->username ?>
                    pegou emprestado
                    <span class="deveAvoce"> R$
                        <?php echo moedaBr($item->valor * -1) ?>
                    </span>
                    de você, <?= $item->descricao ?>  
                <?php } ?>
            <?php } ?>
        </li>
    <?php } ?>
</ul>

<div class="footer-bar">
    <div class="footer-bar2">
        <a href="<?php echo URL_BASE ?>" class="btn btn-primary">Voltar</a>

        <?php if ($saldo > 0) { ?>
            <a href="<?php echo URL_BASE . 'pagamentos/quitar/' . $saldo .'/'. $amigo->users_uid  .'/'. $_SESSION['uid']?>" class="btn btn-primary">Quitar divida</a>
        <?php } else { ?>
            <a href="<?php echo URL_BASE . 'pagamentos/quitar/' . $saldo .'/'. $_SESSION['uid']  .'/'. $amigo->users_uid?>" class="btn btn-primary">Quitar divida</a>
        <?php } ?>

    </div>
</div>