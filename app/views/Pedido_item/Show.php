<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Listagem de itens</h1>
            <a href="<?php echo URL_BASE . "Pedido_item/create/" . $pedidos_id ?>"
                class="btn btn-primary mb-3">Adicionar Pedidoitem</a>
            <hr>
            <input class="mb-1" type="text" id="filtro" placeholder="Filtrar por...">
            <table id="tabela" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Largura</th>
                        <th>Altura</th>
                        <th>Quantidade</th>
                        <th>Valor unitário</th>
                        <th>Valor opcionais</th>
                        <th>Valor Total</th>
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
                                <?php echo $item->pedido_item_largura; ?>
                            </td>
                            <td>
                                <?php echo $item->pedido_item_altura; ?>
                            </td>
                            <td>
                                <?php echo $item->pedido_item_quantidade; ?>
                            </td>
                            <td>
                                <?php echo $item->pedido_item_valor_unitario; ?>
                            </td>
                            <td>
                                <?php echo $item->pedido_item_valor_opcionais; ?>
                            </td>
                            <td>
                                <?php echo $item->pedido_item_valor_total; ?>
                            </td>
                            <td>
                                <a href="<?php echo URL_BASE . "Pedido_item/edit/" . $item->pedido_item_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>


                                <button onclick="deletarItem(<?php echo $item->pedido_item_id; ?>)" type="button"
                                    class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    Deletar
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <ul id="paginacao" class="pagination"></ul>
        </div>
    </div>
    <div class="row mt-2">

        <div class="col-auto">
            <a href="<?php echo URL_BASE ?> " class="btn btn-primary">Voltar</a>
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

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script>
    
    
    controller = 'Pedido_item';
    caminhoRetornoDelete = '<?php echo 'Pedido_item/pedido/' . $pedidos_id; ?>'
    console.log(caminhoRetornoDelete)
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }

    
</script>