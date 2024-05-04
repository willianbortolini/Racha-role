<style>
    /* Estilo personalizado para o botão fixo no canto inferior direito */
    .fixed-bottom-right {
        position: fixed;
        bottom: 15px;
        right: 15px;
    }

    .saida {
        color: #ff2f2f;
        font-weight: 700;
    }

    .entrada {
        color: #21d125;
        font-weight: 700;
    }

    .clickable {
        cursor: pointer;
    }

    #toggle-icon {
        margin-left: auto;
        /* Para garantir que fique no canto direito */
    }

    a {
        text-decoration: none;
    }
</style>

<!-- ANALISE SEMANAS -->
<div class="container mt-2">
    <div class="card">
        <div class="card-header bg-primary text-white clickable d-flex justify-content-between">
            <span>Gastos da Semana</span>
            Gasto:
            <?php echo moedaBr($gastoSemanal) ?>
            resta:
            (
            <?php echo moedaBr(800 - $gastoSemanal) ?>)
            <span class="toggle-icon">+</span>
        </div>
        <div class="card-body collapse">
            <div class="card-body">
                <h5 class="card-title">Resumo Semanal</h5>
                <p class="card-text">Aqui está um resumo dos seus gastos da semana.</p>
                <ul class="list-group">
                    <?php foreach ($gastoPorCategoriaSemanal as $item) { ?>
                        <a href="<?php echo URL_BASE . "Fi_transacoes/categoriaSemana/" . $item->fi_categorias_id ?>">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $item->fi_categorias_nome ?>
                                <span class="badge bg-success">
                                    <?php echo moedaBr($item->valor) ?>
                                </span>
                            </li>
                        </a>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ANALISE MENSAL -->
<div class="container mt-2">
    <div class="card">
        <div class="card-header bg-primary text-white clickable d-flex justify-content-between">
            <span>Gastos do mês</span>
            Total:
            <?php echo  moedaBr($gastoMensal) ?>
            resta:
            (
            <?php echo  moedaBr(3996 - $gastoMensal) ?>)
            <span class="toggle-icon">+</span>
        </div>
        <div class="card-body collapse">
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($gastoPorCategoriaMensal as $item) { ?>
                        <a href="<?php echo URL_BASE . "Fi_transacoes/categoriaMes/" . $item->fi_categorias_id ?>">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $item->fi_categorias_nome ?>
                                <span class="badge bg-success">
                                    <?php echo  moedaBr($item->valor) ?>
                                </span>

                            </li>
                        </a>
                    <?php } ?>

                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="<?php echo URL_BASE . "Fi_transacoes/create" ?>"
                class="btn btn-primary mb-3 d-md-block d-none">Adicionar
                Transacoes</a>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Valor</th>
                        <th>data</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Conta</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fi_transacoes as $item) { ?>
                        <tr>
                            <td class="<?php echo (($item->tipo == 1) ? "saida" : "entrada") ?>">
                                <?php echo (($item->tipo == 1) ? "-" : "") . $item->valor; ?>
                            </td>
                            <td>
                                <?php echo databr($item->data); ?>
                            </td>
                            <td>
                                <?php echo $item->descricao; ?>
                            </td>
                            <td>
                                <?php echo $item->fi_categorias_nome; ?>
                            </td>
                            <td>
                                <?php echo $item->fi_conta_nome; ?>
                            </td>

                            <td>
                                <a href="<?php echo URL_BASE . "Fi_transacoes/edit/" . $item->fi_transacoes_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>

                                <button onclick="deletarItem(<?php echo $item->fi_transacoes_id; ?>)" type="button"
                                    class="btn btn-danger btn-sm deletar" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    Deletar
                                </button>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja deletar este registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="modal_ok" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
</div>



<div class="fixed-bottom m-4 d-md-none text-right">
    <a href="Fi_transacoes/create" class="btn btn-primary fixed-bottom-right btn-lg" role="button" data-toggle="tooltip"
        data-placement="top" title="Adicionar Transação">
        +
    </a>
</div>

<script>
   jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "date-br-pre": function (a) {
            if (a == null || a == "") {
                return 0;
            }
            var brDatea = a.split('/');
            return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
        },

        "date-br-asc": function (a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-br-desc": function (a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });
    $(document).ready(function () {
        var table = new DataTable('table.display', {
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "columnDefs": [
                { type: 'date-br', targets: 1 } 
            ],
            "order": [
                [1, 'desc']
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

    controller = 'fi_transacoes';
    var idLinha = 0;
    function deletarItem(id) {

        idLinha = id;
        console.log(idLinha);
    }

    $(document).ready(function () {
        $('.card-header').click(function () {
            // Alterna a visibilidade do corpo do cartão
            $(this).next('.card-body').collapse('toggle');

            // Alterna o ícone de + para - e vice-versa
            var icon = $(this).find('.toggle-icon');
            if (icon.text() == '+') {
                icon.text('-');
            } else {
                icon.text('+');
            }
        });
    });
</script>