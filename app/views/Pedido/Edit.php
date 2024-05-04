<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    .hidden {
        display: none;
    }

    /* Estilização dos radiobuttons */
    .form-check-input[type="radio"] {
        display: none;
        /* Esconde o radiobutton padrão */
    }

    /* Estilo dos botões quando não selecionados */
    .form-check-label {
        display: inline-block;
        padding: .4rem 1rem;
        margin-bottom: 0;
        font-size: 0.85rem;
        cursor: pointer;
        color: #6c757d;
        /* Cor cinza do Bootstrap */
        border: 1px solid #6c757d;
        /* Borda cinza */
        border-radius: .25rem;
        /* Borda arredondada */
    }

    /* Estilo dos botões quando selecionados */
    .form-check-input[type="radio"]:checked+.form-check-label {
        background-color: #28a745;
        /* Cor verde do Bootstrap */
        color: #fff;
        /* Cor branca para texto */
        border-color: #28a745;
        /* Borda verde */
    }
</style>
<h1>
    <?php echo (isset($pedidos->pedidos_id)) ? 'Editar Pedido' : 'Adicionar Pedido'; ?>
</h1>

<form action="<?php echo URL_BASE . "Pedido/save" ?>" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="form-group mb-2 col-md-6 col-12">
            <label for="pedidos_nome">Descrição</label>
            <input type="text" class="form-control" id="pedidos_nome" name="pedidos_nome"
                value="<?php echo (isset($pedidos->pedidos_nome)) ? $pedidos->pedidos_nome : ''; ?>">
        </div>

        <div
            class="form-group mb-2 col-md-3 col-12 <?php echo (isset($_SESSION['he_administrador']) ? "" : "hidden") ?> ">
            <label for="usuarios_id">Representante</label>
            <select class="form-select" aria-label="Default select example" name="usuarios_id" id="usuarios_id">
                <?php foreach ($usuarios as $item) {
                    echo "<option value='$item->usuarios_id'" . ($item->usuarios_id == $pedidos->usuarios_id ? "selected" : "") . ">$item->usuario</option>";
                } ?>
            </select>
        </div>
        <?php if (in_array(PERMITE_CADASTRARCLIENTENOPEDIDO, $_SESSION['acessos'])) { ?>
            <div class="form-group mb-2 col-md-6 col-12 ">
                <label for="cliente">Cliente</label>
                <select class="form-select" aria-label="Default select example" name="cliente" id="cliente">
                    <option value='0'></option>
                    <?php foreach ($clientes as $item) {
                        echo "<option value='$item->usuarios_id'" . ($item->usuarios_id == $pedidos->cliente ? "selected" : "") . ">" . ucfirst($item->usuario) . " - " . ucfirst($item->cidade) . ", " . ucfirst($item->bairro) . "</option>";
                    } ?>
                </select>
            </div>
        <?php } ?>
    </div>
    <?php if (($pedidos->statusPedido_id < PEDIDO_APROVADO && isset($_SESSION['he_representante'])) || (isset($_SESSION['he_administrador']))) { ?>
        <div class="form-group mb-4">
            <fieldset>
            <label>Status do Pedido:</label><br>
                <?php if (($pedidos->statusPedido_id == ORCAMENTO) || ($pedidos->statusPedido_id == PEDIDO)) { ?>
                    <div class="form-check-inline col-md-auto col-12 mb-2">
                        <input class="form-check-input" type="radio" name="statusPedido_id" value="<?php echo ORCAMENTO ?>"
                            id="opcao1" <?php echo (isset($pedidos->statusPedido_id) && $pedidos->statusPedido_id == ORCAMENTO) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="opcao1">
                            Orçamento
                        </label>
                    </div>
                <?php } ?>

                <?php if (($pedidos->statusPedido_id == ORCAMENTO) || ($pedidos->statusPedido_id == PEDIDO) || ($pedidos->statusPedido_id == PEDIDO_APROVADO)) { ?>
                    <div class=" form-check-inline col-md-auto col-12 mb-2">
                        <input class="form-check-input" type="radio" name="statusPedido_id" value="<?php echo PEDIDO ?>"
                            id="opcao2" <?php echo (isset($pedidos->statusPedido_id) && $pedidos->statusPedido_id == PEDIDO) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="opcao2">
                            Pedido
                        </label>
                    </div>
                <?php } ?>

                <?php if (isset($_SESSION['he_administrador'])) { ?>
                    <?php if (($pedidos->statusPedido_id == PEDIDO_EMTREGUE) || ($pedidos->statusPedido_id == PEDIDO) || ($pedidos->statusPedido_id == PEDIDO_APROVADO)) { ?>
                        <div class="form-check-inline col-md-auto col-12 mb-2">
                            <input class="form-check-input" type="radio" name="statusPedido_id"
                                value="<?php echo PEDIDO_APROVADO ?>" id="opcao3" <?php echo (isset($pedidos->statusPedido_id) && $pedidos->statusPedido_id == PEDIDO_APROVADO) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="opcao3">
                                Pedido aprovado
                            </label>
                        </div>
                    <?php } ?>

                    <?php if (($pedidos->statusPedido_id == PEDIDO_APROVADO) || ($pedidos->statusPedido_id == PEDIDO_EMTREGUE)) { ?>
                        <div class="form-check-inline col-md-auto col-12 mb-2">
                            <input class="form-check-input" type="radio" name="statusPedido_id"
                                value="<?php echo PEDIDO_EMTREGUE ?>" id="opcao4" <?php echo (isset($pedidos->statusPedido_id) && $pedidos->statusPedido_id == PEDIDO_EMTREGUE) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="opcao4">
                                Pedido entregue
                            </label>
                        </div>
                    <?php } ?>
                <?php } ?>
            </fieldset>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-sm btn-primary mb-2">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE ?>" class="btn btn-sm btn-primary mb-2">Voltar</a>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "Pedido/print/" . $pedidos->pedidos_id ?>" class="btn btn-sm btn-primary mb-2">Visualizar
                orçamento</a>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "Pedido/visualizar_pedido_representante/" . $pedidos->pedidos_id ?>"
                class="btn btn-sm btn-primary mb-2">Visualizar
                pedido completo</a>
        </div>
        <div class="col-auto">
            <button type="button" onclick="copiarLink()" class="btn btn-sm btn-primary mb-2">Copiar link compartilhável</button>
        </div>
    </div>
    <input type="hidden" name="pedidos_id"
        value="<?php echo (isset($pedidos->pedidos_id)) ? $pedidos->pedidos_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Itens do pedido</h1>
            <?php if (($pedidos->statusPedido_id < PEDIDO_APROVADO && isset($_SESSION['he_representante'])) || (isset($_SESSION['he_administrador']))) { ?>
                <a id="btnAdicionaItem" class="btn btn-primary mb-3">Adicionar item ao pedido</a>
            <?php } ?>
            <hr>
            <?php if (count($pedido_item) > 0) { ?>
                <table id="tabela" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Ambiente</th>
                            <th>Largura</th>
                            <th>Altura</th>
                            <th>Composição</th>
                            <th>Qtd.</th>
                            <?php if (isset($_SESSION['he_administrador'])) { ?>
                                <th>Valor Total</th>
                                <th>Markup</th>
                            <?php } ?>
                            <th>Valor Venda</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedido_item as $item) { ?>
                            <tr>
                                <td>
                                    <?php echo $item->produtos_nome; ?>
                                </td>
                                <td>
                                    <?php echo $item->pedido_item_descricao; ?>
                                </td>
                                <td>
                                    <?php echo $item->pedido_item_largura; ?>
                                </td>
                                <td>
                                    <?php echo $item->pedido_item_altura; ?>
                                </td>
                                <td>
                                    <button onclick="trocaTextoDoModal(event)" type="button" class="btn btn-info btn-sm mt-2 "
                                        data-bs-toggle="modal" data-bs-target="#modalComposicao">
                                        Visualizar composição
                                    </button>
                                    <span class="d-none">
                                        <?php echo $item->pedido_item_composicao_descricao ?>
                                    </span>
                                </td>

                                <td>
                                    <?php echo $item->pedido_item_quantidade; ?>
                                </td>
                                <?php if (isset($_SESSION['he_administrador'])) { ?>
                                    <td>
                                        <?php echo (isset($item->pedido_item_valor_total)) ? moedaBr($item->pedido_item_valor_total) : NULL; ?>
                                    </td>
                                    <td>
                                        <?php echo $item->pedido_item_markup; ?>
                                    </td>
                                <?php } ?>
                                <td>
                                    <?php echo (isset($item->pedido_item_valor_venda)) ? moedaBr($item->pedido_item_valor_venda) : NULL; ?>
                                </td>
                                <td>
                                    <?php if ($pedidos->statusPedido_id < PEDIDO_APROVADO && isset($_SESSION['he_representante'])) { ?>
                                        <a href="<?php echo URL_BASE . "Pedido_item/edit/" . $item->pedido_item_id ?>"
                                            class="btn btn-primary btn-sm mt-2">Editar</a>

                                        <button onclick="deletarItem(<?php echo $item->pedido_item_id; ?>)" type="button"
                                            class="btn btn-danger btn-sm mt-2 " data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                            Deletar
                                        </button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <tfoot>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <?php if (isset($_SESSION['he_administrador'])) { ?>
                            <td>
                            </td>
                            <td>
                            </td>
                        <?php } ?>
                        <td>
                            valor total
                        </td>
                        <td>
                            <?php echo (isset($pedidos->total_valor_venda)) ? moedaBr($pedidos->total_valor_venda) : NULL; ?>
                        </td>
                        <td>
                        </td>
                    </tfoot>

                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2 btn-sm">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE ?>" class="btn btn-primary mb-2 btn-sm">Voltar</a>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "Pedido/print/" . $pedidos->pedidos_id ?>" class="btn btn-primary mb-2 btn-sm">Visualizar
                orçamento</a>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "Pedido/visualizar_pedido_representante/" . $pedidos->pedidos_id ?>"
                class="btn btn-primary mb-2 btn-sm">Visualizar
                pedido completo</a>
        </div>
        <div class="col-auto">
            <button type="button" onclick="copiarLink()" class="btn btn-primary mb-2 btn-sm">Copiar link compartilhável</button>
        </div>
    </div>
</form>
<form id="formularioPedidoItem" class="hidden" action="<?php echo URL_BASE . "Pedido_item/save" ?>" method="post">
    <!-- Conteúdo do formulário -->

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type='hidden' name='pedidos_id'
        value='<?php echo (isset($pedidos->pedidos_id)) ? $pedidos->pedidos_id : NULL; ?>'>
    <input type='hidden' name='produtos_id' value='<?php echo $produtos[0]->produtos_id ?>'>
    <input type='hidden' name='pedido_item_largura' value='0'>
    <input type='hidden' name='pedido_item_altura' value='0'>
    <input type='hidden' name='pedido_item_quantidade' value='1'>
    <input type='hidden' name='pedido_item_markup' value='<?php echo $markupSugerido; ?>'>
</form>

<!-- Modal composicao -->

<div class="modal fade" id="modalComposicao" tabindex="-1" aria-labelledby="modalComposicaoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalComposicaoLabel">Composição</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="corpo-modalComposicao" class="modal-body">

            </div>
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



<script>

    //select com pesquisa
    $(document).ready(function () {
        $('#cliente').select2();
    });


    const btnAdicionaItem = document.getElementById('btnAdicionaItem');
    btnAdicionaItem.addEventListener('click', adicionaItem);

    function adicionaItem() {
        var form = document.getElementById('formularioPedidoItem');
        form.submit();
    }
    $(document).ready(function () {

        var table = new DataTable('table.display', {
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

    function trocaTextoDoModal(event) {
        var descricao = $(event.target).next('.d-none').text();
        console.log(descricao);
        document.getElementById('corpo-modalComposicao').innerText = descricao;
    }

    controller = 'Pedido_item';
    caminhoRetornoDelete = '<?php echo 'Pedido/edit/' . $pedidos->pedidos_id ?>'
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }

    function copiarLink() {
        // Define o link que você quer copiar
        var linkParaCopiar = "<?php echo URL_BASE . 'Pedido/cliente/' . $pedidos->codigo_acesso_cliente ?>";

        // Cria um elemento input temporário para ajudar na cópia do link
        var tempInput = document.createElement("input");
        tempInput.value = linkParaCopiar;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput); // Remove o input temporário

        // Seleciona o botão pelo evento ou por ID se necessário
        var botao = event.currentTarget;

        // Muda a cor e o texto do botão
        botao.classList.remove("btn-primary");
        botao.classList.add("btn-secondary");
        botao.textContent = "Link compartilhável copiado";

        // Espera 10 segundos e reverte as mudanças
        setTimeout(function () {
            botao.classList.remove("btn-secondary");
            botao.classList.add("btn-primary");
            botao.textContent = "Copiar link compartilhável";
        }, 5000); // 10000 milissegundos = 10 segundos
    }
</script>