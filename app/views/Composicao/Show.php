<style>
    .hidden {
        display: none;
    }


    .clicavel {
        cursor: pointer;
        border: 1px solid #000;
        padding: 10px;
        margin: 5px;
    }

    .destacado {
        box-shadow: 0 0 10px 5px #89db89 !important;
        border: solid 1px #56e956 !important;
    }

    a {
        color: black;
        text-decoration: none;
    }

    .op {
        color: red;
    }

    .material {
        color: blue;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">
                <?php echo ((isset($produto->produtos_id) and ($produto->produtos_id > 0)) ? '' : 'Listagem de Composições padrão') ?>
            </h1>
            <h2>
                <?php echo ((isset($produto->produtos_nome)) ? $produto->produtos_nome : ''); ?>
            </h2>
            <?php if (isset($produto->produtos_id)) { ?>
                <a href="<?php echo URL_BASE . "Composicao/create/" . ((isset($produto->produtos_id)) ? $produto->produtos_id : '-1') . "/" . ((isset($produto->produtos_nome)) ? '0' : '-1') ?>"
                    class="btn btn-secondary  btn-sm m-2">
                    <?php echo ((isset($produto->produtos_id) and ($produto->produtos_id > 0)) ? 'Criar composição filha do produto principal' : 'Criar composição padrão') ?>
                </a>
            <?php } ?>
            <?php if (isset($produto->produtos_id)) { ?>
                <a href="<?php echo URL_BASE . "produtos/edit/" . $produto->produtos_id ?>"
                    class="btn btn-primary btn-sm">Voltar para produto</a>
            <?php } else { ?>
                <a href="<?php echo URL_BASE . "Composicao/padrao" ?>" class="btn btn-primary btn-sm">Voltar para
                    composições padão</a>
            <?php } ?>
            <div class="row">
                <?php if (isset($produto->produtos_id)) { ?>
                    <h3>Composição</h3>
                    <p>É assim que a composição vai aparecer na tela de seleção de produto.</p>
                    <div class="col-8">
                        <div class="row" id="itens"></div>
                    </div>
                    <div class="col-4">
                        <div id="editCard" class="card m-2 hidden">
                            <div class="card-body">
                                <div class="form-group mb-2">
                                    <label for="composicao_nome">Nome</label>
                                    <input type="text" class="form-control" id="composicao_nome" name="composicao_nome"
                                        required>
                                </div>
                                <div class="form-group mb-2">

                                    <input type="checkbox" class="form-check-input" id="composicao_obrigatoria"
                                        name="composicao_obrigatoria">
                                    <label for="composicao_nome">preenchimento obrigatorio</label>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="composicao_tipo_id">Tipo</label>
                                    <select class="form-select" aria-label="Default select example"
                                        name="composicao_tipo_id" id="composicao_tipo_id">
                                        <option value="0"></option>
                                        <?php foreach ($composicao_tipo as $item) {
                                            echo "<option value='$item->composicao_tipo_id'" . ">$item->composicao_tipo_nome</option>";
                                        } ?>
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="composicao_ordem">Ordem de exibição</label>
                                    <input type="number" class="form-control" id="composicao_ordem" name="composicao_ordem"
                                        value="">
                                </div>

                                <div class="form-group mb-2">
                                    <label for="composicao_padrao_id">composicao padrao</label>
                                    <select class="form-select" aria-label="Default select example"
                                        name="composicao_padrao_id" id="composicao_padrao_id">
                                        <option value="0"></option>
                                        <?php foreach ($composicao_padrao as $item) {
                                            echo "<option value='$item->composicao_id'" . ">$item->composicao_nome</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="composicao_formula">Formula</label>
                                    <input type="text" class="form-control" id="composicao_formula"
                                        name="composicao_formula"
                                        value="<?php echo (isset($composicao->composicao_formula)) ? $composicao->composicao_formula : ''; ?>">
                                    l = largura <br>
                                    a = altura <br>
                                    q = quantidade <br>
                                    v = valor <br>
                                    t = valor de tabela do produto <br>
                                </div>
                                <input type="hidden" name="composicao_pai_id" id="composicao_pai_id" value="">
                                <input type="hidden" name="produtos_id" id="produtos_id" value="">
                                <input type="hidden" name="composicao_id" id="composicao_id" value="">
                                <input type="hidden" name="csrf_token" id="csrf_token"
                                    value="<?php echo $_SESSION['csrf_token']; ?>">

                                <div class="row">
                                    <div class="col-auto">
                                        <button type="button" id="salvar-btn" class="btn btn-sm btn-primary">Salvar</button>

                                        <a id="btnCriaFilho" href="<?php echo URL_BASE . "Composicao/create/" ?>"
                                            class="btn btn-secondary btn-sm m-2">Criar filho</a>

                                        <button id_linha="" onclick="deletaEditar(this)" type="button" id="editDeletar"
                                            class="btn btn-danger btn-sm deletar" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                            Deletar
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php } ?>


                <ul class="mind-map mt-5">
                    <h3>Mapa da composição</h3>
                    <li class="list-group-item">

                        <?php
                        function passaporarray($dados, $id, $composicao_tipo, $composicao_referencia = 0)
                        {

                            $arrayFiltrado = array_filter($dados, function ($item) use ($id) {
                                return $item->composicao_pai_id == $id;
                            });
                            if (count($arrayFiltrado) > 0) {
                                echo "<ul class='list-group'>";                                
                                foreach ($arrayFiltrado as $itemFiltrado) {

                                    ?>
                                <li class='list-group-item'>
                                    <div class="row">
                                        <div class="form-group mr-2 col-2 d-flex align-items-center">
                                            <?php echo (isset($itemFiltrado->composicao_nome)) ? $itemFiltrado->composicao_nome : ''; ?>
                                        </div>
                                        <div class="form-group mb-2 col-2  d-flex align-items-center">
                                            Tipo:
                                            <?php echo (isset($itemFiltrado->composicao_tipo_nome)) ? $itemFiltrado->composicao_tipo_nome : ''; ?>
                                        </div>

                                        <?php if (isset($itemFiltrado->composicao_pai_id) and ($itemFiltrado->composicao_pai_id == 0)) { ?>
                                            <div class="form-group mb-2 col-1  d-flex align-items-center">
                                                Ordem:
                                                <?php echo (isset($itemFiltrado->composicao_ordem)) ? $itemFiltrado->composicao_ordem : ''; ?>
                                            </div>
                                        <?php } ?>

                                        <?php if (isset($itemFiltrado->composicao_padrao_nome)) { ?>
                                            <div class="form-group mb-2 col-1  d-flex align-items-center">
                                                composição padrão:
                                                <?php echo (isset($itemFiltrado->composicao_padrao_nome)) ? $itemFiltrado->composicao_padrao_nome : ''; ?>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group mb-2 col-1  d-flex align-items-center">
                                                Formula:
                                                <?php echo (isset($itemFiltrado->composicao_formula)) ? $itemFiltrado->composicao_formula : ''; ?>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group mb-2 col-1  d-flex align-items-center">
                                                Insumo:
                                                <?php echo (isset($itemFiltrado->insumo_nome )) ? $itemFiltrado->insumo_nome  : ''; ?>                                                
                                                <?php echo (isset($itemFiltrado->quantidade_insumo) and ($itemFiltrado->quantidade_insumo <> 0.00)) ?'/'.$itemFiltrado->quantidade_insumo  : ''; ?>
                                            </div>

                                        <div class="form-group mb-2 col-1  d-flex align-items-center">
                                            Posição OP:
                                            <?php echo (isset($itemFiltrado->posicao_op_descricao)) ? $itemFiltrado->posicao_op_descricao : ''; ?>
                                        </div>


                                        <div class="form-group mb-2 col-3  d-flex align-items-center">
                                            <a href="<?php echo URL_BASE . "Composicao/edit/" . $itemFiltrado->composicao_id;
                                            if ((isset($composicao_referencia)) && ($composicao_referencia > 0)) {
                                                echo "/" . $composicao_referencia;
                                            }
                                            ; ?>" class="btn btn-primary btn-sm m-2">Editar</a>
                                            <a href="<?php echo URL_BASE . "Composicao/create/" . $itemFiltrado->produtos_id . "/" . $itemFiltrado->composicao_id . "/" . $composicao_referencia ?>"
                                                class="btn btn-secondary btn-sm m-2">Criar filho</a>

                                            <?php
                                            $id_pai = $itemFiltrado->composicao_id;
                                            $filhos = $arrayFiltrado = array_filter($dados, function ($item) use ($id_pai) {
                                                return $item->composicao_pai_id == $id_pai;
                                            });
                                            if (count($filhos) == 0) { ?>

                                                <button onclick="deletarItem(<?php echo $itemFiltrado->composicao_id; ?>)" type="button"
                                                    class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                    Deletar
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                    passaporarray($dados, $itemFiltrado->composicao_id, $composicao_tipo, $composicao_referencia);

                                    echo "</li>";
                                }
                                echo "</ul>";

                            }
                        }
                        if (isset($produto)) {
                            passaporarray($composicao, 0, $composicao_tipo);
                        } else {
                            passaporarray($composicao, -1, $composicao_tipo, $composicao_referencia);
                        }
                        ?>
            </div>
            
            <!-- Modal Delete -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
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
        </div>
    </div>
</div>
<?php if (isset($produto)) { ?>
    <script src="<?php echo URL_BASE . 'assets/js/pedido_item_criaComposicao7.js' ?>"></script>
    <script src="<?php echo URL_BASE . 'assets/js/composicao_editar4.js' ?>"></script>
<?php } ?>
<script>
    composicaoSalva = [];

    <?php if (isset($produto)) { ?>
        pegaComposicao()
        function pegaComposicao() {
            let urlComposicao = "<?php echo URL_BASE ?>" + "Composicao/composicaoProduto/" + "<?php echo ((isset($produto->produtos_id)) ? $produto->produtos_id : '-1') ?>";
            fetch(urlComposicao)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Erro na requisição: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    composicao = data;
                    const itensDiv = document.getElementById('itens');
                    itensDiv.innerHTML = '';
                    const composicoesIniciais = data.filter(item => item.composicao_pai_id == 0);
                    composicoesIniciais.forEach(composicaoInicial => {
                        itensDiv.appendChild(criaInput(composicaoInicial, data))
                    });
                    carregaInputsCriados();
                })
                .catch(error => {
                    console.error('Erro durante a requisição:', error);
                });
        }
    <?php } ?>

    controller = 'Composicao';
    caminhoRetornoDelete = '<?php echo 'Composicao/' . ((isset($produto->produtos_id)) ? "show/" . $produto->produtos_id : 'padrao_item/' . $composicao_referencia) ?>';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }

    function deletaEditar(botao) {
        idLinha = botao.getAttribute('id_linha');
    }

</script>