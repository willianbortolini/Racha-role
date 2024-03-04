<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1 text-center">INVENTARIOS</h1>
            <a href="<?php echo URL_BASE . "Inventario/create" ?>"
                class="btn btn-sm btn-outline-info mb-1  col-12 col-md-auto">Adicionar
                inventario</a>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventario as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->nome; ?>
                            </td>
                            <td>
                                <a href="<?php echo URL_BASE . "Inventario/edit/" . $item->inventario_id ?>"
                                    class="btn btn-outline-primary btn-sm">Editar</a>

                                <a href="<?php echo URL_BASE . "Inventario_item/index/" . $item->inventario_id ?>"
                                    class="btn btn-outline-primary btn-sm">Itens</a>

                                <a href="<?php echo URL_BASE . "Inventario_compartilhado/membros/" . $item->inventario_id ?>"
                                    class="btn btn-outline-primary btn-sm">Membros</a>

                                <button type="button" onclick="copiarLink('<?php echo $item->chave ?>')"
                                    class="btn btn-outline-info btn-sm ">Compartilhar</button>

                                <a href="<?php echo URL_BASE . "Inventario_item/Visualizar/" . $item->inventario_id ?>"
                                    class="btn btn-outline-primary btn-sm">Visualizar</a>
                                    
                                <button onclick="deletarItem(<?php echo $item->inventario_id; ?>)" type="button"
                                    class="btn btn-outline-danger btn-sm deletar" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    Deletar
                                </button>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php foreach ($inventarioCompartilhado as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->nome; ?>
                            </td>
                            <td>
                                <a href="<?php echo URL_BASE . "Inventario_item/compartilhado/" . $item->chave ?>"
                                    class="btn btn-outline-primary btn-sm">Itens</a>
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
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 25,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

    controller = 'Inventario';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }

    function copiarLink(chave) {
        // Define o link que você quer copiar
        var linkParaCopiar = "<?php echo URL_BASE . 'Inventario_item/compartilhado/' ?>" + chave;

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