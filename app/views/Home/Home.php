<style>
    body {
        background-color: #f8f9fa;
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
        margin: 0 10px;
    }

    .fixed-bottom-btn {
        width: 60px;
        height: 60px;
        font-size: 24px;
        text-align: center;
        padding: 10px;
        border-radius: 50%;
        background-color: #007bff;
        color: white;
    }

    .fixed-bottom-btn span {
        display: none;
    }

    @media (min-width: 768px) {
        .fixed-bottom-btn {
            width: auto;
            height: auto;
            font-size: 16px;
            border-radius: 5px;
            padding: 10px 20px;
        }

        .fixed-bottom-btn span {
            display: inline;
        }

        .fixed-bottom-btn i {
            display: none;
        }
    }

    .table-container {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .table thead th {
        background-color: #343a40;
        color: white;
        border: none;
    }

    .table tbody tr {
        transition: background-color 0.3s;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .btn-quitar {
        background-color: #28a745;
        border: none;
        transition: background-color 0.3s;
    }

    .btn-quitar:hover {
        background-color: #218838;
    }

    .list-group-item div {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }
    
</style>

<h2 class="mb-4">Valores devidos</h2>
<ul class="list-group">
    <?php foreach ($minhasDespesas as $despesa) { ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <span><?= $despesa->devendo_para_nome ?></span>
                <span>R$ <?= number_format($despesa->valor_devendo, 2, ',', '.') ?></span>
            </div>
            <a href="<?php echo URL_BASE . "pagamentos/quitar/" . $despesa->valor_devendo . "/" . $_SESSION['id'] . "/" . $despesa->devendo_para ?>"
                class="btn btn-primary">quitar</a>
        </li>
    <?php } ?>
</ul>

<h2 class="mb-4">Valores a receber</h2>
<ul class="list-group">
<?php foreach ($meusValoresAReceber as $receber) { ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <span><?= $receber->a_receber_nome ?></span>
                <span>R$ <?= number_format($receber->valor_receber, 2, ',', '.') ?></span>
            </div>
            <a href="<?php echo URL_BASE . "pagamentos/quitar/" . $receber->valor_receber . "/" . $receber->a_receber_de . "/" . $_SESSION['id'] ?>"
                class="btn btn-primary">quitar</a>
        </li>
    <?php } ?>
</ul>

<div class="footer-bar">
    <a href="<?php echo URL_BASE . 'Grupos' ?>" class="btn btn-secondary">Grupos</a>
    <a href="<?php echo URL_BASE . 'Despesas/create' ?>" class="btn btn-primary fixed-bottom-btn">
        <i class="fa fa-plus"></i>
        <span>Adicionar Despesa</span>
    </a>
    <a href="<?php echo URL_BASE . 'amigos' ?>" class="btn btn-secondary">Amigos</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">