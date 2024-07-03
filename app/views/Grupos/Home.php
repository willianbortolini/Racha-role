<style>
    .deveAvoce {
        color: #00a5a5;
    }

    .voceDeve {
        color: #f79b0c;
    }

    ul li{
        list-style-type: none;
        padding-left: 0;
    }

    .grupo {
        margin-top: 10px;
        background-color: #f1f1f1;
        padding: 8px;
    }
    .lista{
        padding: 0px;
    }
</style>
<div class="mt-2">
    <a href="<?php echo URL_BASE . 'grupos/create' ?>" class="btn btn-outline-info"> <i class="fa fa-plus"></i>
        Adicionar grupo</a>
</div>
<hr>
<h5>No total, 
    <?php if ($saldo > 0) { ?>
        devem a você <span class="deveAvoce">R$ <?= number_format($saldo, 2, ',', '.') ?></span>
    <?php } else { ?>
        você deve <span class="deveAvoce">R$ <?= number_format($saldo*-1, 2, ',', '.') ?></span>
    <?php } ?>
</h5>
<ul class="lista">
    <?php $current_group = null;
    foreach ($minhasDespesas as $item) { ?>
        <?php
        // Definir o nome do grupo, substituindo nulos por 'Sem Grupo'
        $group_name = $item->nome_grupo ?? 'Despesa sem grupo';
        $group_id = $item->grupos_id ?? -1;
        ?>
        <?php if ($group_id !== $current_group) { ?>
            <?php if ($current_group !== null) { ?>
            </ul>
            </li>
        <?php } ?>
        <li class="grupo">
            <strong><?php echo htmlspecialchars($group_name); ?></strong>
            <ul>
                <?php $current_group = $group_id; ?>
            <?php } ?>
            <li>
                <?php if ($item->valor > 0) { ?>
                    Você deve
                    <span class="voceDeve"> R$
                        <?php echo moedaBr($item->valor) ?>
                    </span>
                    a
                    <?php echo substr(htmlspecialchars($item->username), 0, 10); ?>
                    </span>
                <?php } else { ?>
                    <?php echo substr(htmlspecialchars($item->username), 0, 10); ?>
                    deve
                    <span class="deveAvoce"> R$
                        <?php echo moedaBr($item->valor * -1) ?>
                    </span>
                    a você
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
</li>
</ul>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">