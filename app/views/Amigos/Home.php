<style>
    .list-group-item {
        cursor: pointer;
        padding: 15px;
        border: none;
        transition: background-color 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .list-group-item:hover {
        background-color: #f1f1f1;
    }

    .list-group-item .name {
        font-weight: bold;
        font-size: 1.5rem;
        flex-grow: 1;
        text-align: left;
    }

    .list-group-item .amount {
        font-size: 1.5rem;
        font-weight: bold;
        text-align: right;
    }

    .list-group-item .description {
        font-size: 0.9rem;
        color: #6c757d;
        text-align: right;
    }

    .list-group-item .valor {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Center the items horizontally */
        justify-content: center;
        /* Center the items vertically */
        margin-right: 10px;
    }

    .list-group-item .valor .deveAvoce {
        color: #00a5a5;
    }

    .list-group-item .valor .voceDeve {
        color: #f79b0c;
    }

    .list-group-item .btn-quitar {
        font-weight: 600 !important; 
    }
    

    .btn-container {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .btn-container .btn {
        margin-top: 5px;
        white-space: nowrap;
    }

    .list-group-item .pix {
        font-weight: 500;        
        font-size: medium; 
    }
</style>
<div class="mt-2">
<a href="<?php echo URL_BASE . 'amigos/create' ?>" class="btn btn-outline-info"> <i class="fa fa-plus"></i> Adicionar amigo</a>
</div>
<hr>
<ul class="list-group">
    <?php foreach ($minhasDespesas as $despesa) { ?>
        <li class="list-group-item" onclick="location.href='<?php echo URL_BASE . 'pagamentos/detalhes/' . $despesa->devendo_para ?>'">
            <div class="name"><?= $despesa->devendo_para_nome ?></br>
                <span class="pix">PIX:079.920.529-00</span>
            </div>
            <div class="valor mr-4 ">
                <span class="description deveAvoce">deve a você</span>
                <span class="amount deveAvoce">R$ <?= number_format($despesa->valor_devendo, 2, ',', '.') ?></span>
            </div>
            <div class="btn-container">
                <a href="<?php echo URL_BASE . "pagamentos/quitar/" . $despesa->valor_devendo . "/" . $_SESSION['id'] . "/" . $despesa->devendo_para ?>" class="btn btn-primary btn-quitar">QUITAR <br> DIVIDA</a>
            </div>
        </li>
    <?php } ?>
</ul>

<ul class="list-group">
    <?php foreach ($meusValoresAReceber as $receber) { ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="name"><?= $receber->a_receber_nome ?></br>
                <span class="pix">PIX:</span>
            </div>
            <div class="valor mr-4 ">
                <span class="description voceDeve">você deve</span>
                <span class="amount voceDeve">R$ <?= number_format($receber->valor_receber, 2, ',', '.') ?></span>
            </div>
            <div class="btn-container">
                <a href="<?php echo URL_BASE . "pagamentos/quitar/" . $receber->valor_receber . "/" . $receber->a_receber_de . "/" . $_SESSION['id'] ?>" class="btn btn-primary btn-quitar">QUITAR <br> DIVIDA</a>
            </div>
        </li>
    <?php } ?>
</ul>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

<script>
    document.querySelectorAll('.list-group-item').forEach(item => {
        item.addEventListener('click', function(e) {
            if (!e.target.closest('.btn')) {
                window.location.href = this.getAttribute('onclick').replace('location.href=', '').replace(/'/g, '');
            }
        });
    });
</script>