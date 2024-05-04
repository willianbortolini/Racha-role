<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Listagem de Itens da Ordem de Produçãos</h1>
            <a href="<?php echo URL_BASE   . "Ordem_producao_item/create" ?>" class="btn btn-primary mb-3">Adicionar Itens da Ordem de Produção</a>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>                        
                        <th>Ordem produção</th>
                        <th>Ambiente</th>
                        <th>modelo</th>
                        <th>Largura</th>
                        <th>Altura</th>
                        <th>Cor</th>
                        <th>Tipo de tela</th>
                        <th>Tipo de tela</th>
                        <th>Largura de corte</th>
                        <th>Altura de corte</th>
                        <th>Tamanho do trilho superior</th>
                        <th>Tamanho do trilho inferior</th>
                        <th>Intalação</th>
                        <th>Tipo do trilho superior</th>
                        <th>Tipo do trilho inferior</th>
                        <th>Fixação do trilho superior</th>
                        <th>Fixação do trilho inferior</th>
                        <th>Posição escovas</th>
                        <th>Cor das Escovas</th>
                        <th>Altura das escovas</th>

                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordem_producao_item as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->ordem_producao_id; ?>
                            </td>
                            <td>
                                <?php echo $item->ambiente; ?>
                            </td>
                            <td>
                                <?php echo $item->modelo; ?>
                            </td>
                            <td>
                                <?php echo $item->largura; ?>
                            </td>
                            <td>
                                <?php echo $item->altura; ?>
                            </td>
                            <td>
                                <?php echo $item->cor; ?>
                            </td>
                            <td>
                                <?php echo $item->tipo_tela; ?>
                            </td>
                            <td>
                                <?php echo $item->tipo_conexao; ?>
                            </td>
                            <td>
                                <?php echo $item->largura_corte; ?>
                            </td>
                            <td>
                                <?php echo $item->altura_corte; ?>
                            </td>
                            <td>
                                <?php echo $item->tamanho_trilho_superior; ?>
                            </td>
                            <td>
                                <?php echo $item->tamanho_trilho_inferior; ?>
                            </td>
                            <td>
                                <?php echo $item->instalacao; ?>
                            </td>
                            <td>
                                <?php echo $item->tipo_trilho_superior; ?>
                            </td>
                            <td>
                                <?php echo $item->tipo_trilho_infeior; ?>
                            </td>
                            <td>
                                <?php echo $item->fixacao_trilho_superior; ?>
                            </td>
                            <td>
                                <?php echo $item->fixacao_trilho_inferior; ?>
                            </td>
                            <td>
                                <?php echo $item->posicao_escovas; ?>
                            </td>
                            <td>
                                <?php echo $item->cor_escovas; ?>
                            </td>
                            <td>
                                <?php echo $item->altura_escovas; ?>
                            </td>
                      
                            <td> 
                                <a href="<?php echo URL_BASE   . "Ordem_producao_item/edit/" . $item->ordem_producao_item_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>

                                <button onclick="deletarItem(<?php echo $item->ordem_producao_item_id; ?>)" type="button"
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

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script>
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

    controller = 'Ordem_producao_item';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>