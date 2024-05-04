<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    .hidden {
        display: none;
    }

    /* Custom styles */
    .product-details {
        display: flex;
        align-items: flex-start;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        margin-top: 20px;
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .thumbnail-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .thumbnail {
        width: 80px;
        height: 80px;
        margin-bottom: 10px;
        cursor: pointer;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        overflow: hidden;
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .main-image {
        max-width: 400px;
        max-height: 400px;
        margin-right: 20px;
    }

    .product-info {
        flex: 1;
    }

    .select2-container--default {
        width: 100% !important;
    }

    .balao-ajuda {
        display: none;
        position: absolute;
        background-color: #fff;
        border: 1px solid #ccc;
        padding: 10px;
        z-index: 1000;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: left;

    }

    .balao-ajuda img {
        width: -webkit-fill-available;
    }

    .input-group-append {
        cursor: pointer;
    }
</style>

<div id="alert-danger" class="alert alert-danger hidden" role="alert">
    <div id="textoDoAlert" class="flex-grow-1">
    </div>
    <button type="button" class="btn-close" aria-label="Close" onclick="fechaDanger(this)"></button>
</div>

<h1>
    Cadastramento da tela
</h1>
<?php //i($pedido_item); 
?>
<div id="tree"></div>
<form action="<?php echo URL_BASE . "Pedido_item/save" ?>" method="POST" enctype="multipart/form-data" id="formulario">
    <div class="row">
        <div class="form-group col-md-10 col-12" id="colunaSelects">
            <div class="row">
                <div class="form-group mb-2 col-md-10  col-12">
                    <label for="pedido_item_largura">Ambiente</label>
                    <input type="text" class="form-control" id="pedido_item_descricao" name="pedido_item_descricao"
                        value="<?php echo (isset($pedido_item->pedido_item_descricao)) ? $pedido_item->pedido_item_descricao : ''; ?>">
                </div>
                <div class="form-group mb-2 col-md-2 col-3">
                    <label for="pedido_item_markup">Markup</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="pedido_item_markup" step=0.1
                            name="pedido_item_markup"
                            value="<?php echo (isset($pedido_item->pedido_item_markup)) ? $pedido_item->pedido_item_markup : $markupSugerido; ?>"
                            required>
                        <div class="input-group-append" id="ajuda_markup" onclick="ajuda(this, -1)">
                            <span class="input-group-text" id="helpIcon">?</span>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-2 col-md-6 col-12">
                    <label for="produtos_id">Produto</label>
                    <select class="form-select" aria-label="Default select example" name="produtos_id" id="produtos_id">
                        <?php foreach ($produtos as $item) {
                            echo "<option usaTabelaPreco= '$item->produtos_usaTabelaPreco' value='$item->produtos_id'" . ($item->produtos_id == $pedido_item->produtos_id ? "selected" : "") . ">$item->produtos_nome</option>";
                        } ?>
                    </select>
                </div>
                <div class="form-group mb-2 col-md-2 col-12">
                    <label for="pedido_item_largura">Largura</label>
                    <input type="number" class="form-control" id="pedido_item_largura" name="pedido_item_largura"
                        value="<?php echo (isset($pedido_item->pedido_item_largura)) ? $pedido_item->pedido_item_largura : ''; ?>"
                        required>
                </div>

                <div class="form-group mb-2  col-md-2 col-12">
                    <label for="pedido_item_altura">Altura</label>
                    <input type="number" class="form-control" id="pedido_item_altura" name="pedido_item_altura"
                        value="<?php echo (isset($pedido_item->pedido_item_altura)) ? $pedido_item->pedido_item_altura : ''; ?>"
                        required>
                </div>

                <div class="form-group mb-2  col-md-2 col-12">
                    <label for="pedido_item_quantidade">Quantidade</label>
                    <input type="number" class="form-control" id="pedido_item_quantidade" name="pedido_item_quantidade"
                        value="<?php echo (isset($pedido_item->pedido_item_quantidade)) ? $pedido_item->pedido_item_quantidade : ''; ?>"
                        required>
                </div>
                <div class="row" id="itens"></div>
            </div>

        </div>
        <div class="form-group  col-md-2 col-12" id="preco">
            <div class="card h-100 ">
                <div class="card-body ">
                    <h5 class="card-title">Valor</h5>
                    <div class="input-numerico form-group mb-2" <?php echo (isset($_SESSION['he_representante'])) ? 'style="display: none;"' : ''; ?>>
                        <label for="pedido_item_valor_unitario">Valor unitário
                            produto </label>
                        <input type="number" id="pedido_item_valor_unitario" name="pedido_item_valor_unitario"
                            class="form-control"
                            value="<?php echo (isset($pedido_item->pedido_item_valor_unitario)) ? $pedido_item->pedido_item_valor_unitario : 0; ?>"
                            readonly>
                    </div>
                    <div
                        class="<?php echo (isset($_SESSION['he_representante'])) ? 'hidden' : ''; ?> input-numerico form-group mb-2">
                        <label for="pedido_item_valor_opcionais">Valor opcionais
                        </label>
                        <input type="number" id="pedido_item_valor_opcionais" name="pedido_item_valor_opcionais"
                            class="form-control"
                            value="<?php echo (isset($pedido_item->pedido_item_valor_opcionais)) ? $pedido_item->pedido_item_valor_opcionais : 0; ?>"
                            readonly>
                    </div>
                    <div
                        class="<?php echo (isset($_SESSION['he_representante'])) ? 'hidden' : ''; ?> input-numerico form-group mb-2">
                        <label for="pedido_item_valor_total">Valor Total
                        </label>
                        <input type="number" id="pedido_item_valor_total" name="pedido_item_valor_total"
                            class="form-control"
                            value="<?php echo (isset($pedido_item->pedido_item_valor_total)) ? $pedido_item->pedido_item_valor_total : 0; ?>"
                            readonly>
                    </div>
                    <div class="input-numerico form-group mb-2"><label for="pedido_item_valor_venda">Valor Venda</label>
                        <input type="number" id="pedido_item_valor_venda" name="pedido_item_valor_venda"
                            class="form-control"
                            value="<?php echo (isset($pedido_item->pedido_item_valor_total)) ? $pedido_item->pedido_item_valor_total * $pedido_item->pedido_item_markup : 0; ?>"
                            readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="pedidos_id"
        value="<?php echo (isset($pedido_item->pedidos_id)) ? $pedido_item->pedidos_id : ''; ?>">
    <input type="hidden" name="pedido_item_id"
        value="<?php echo (isset($pedido_item->pedido_item_id)) ? $pedido_item->pedido_item_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row mt-2">
        <div class="col-auto mt-2">
            <button type="button" id="btnSalvar" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto mt-2">
            <a href="<?php echo URL_BASE . "Pedido/edit/" . ((isset($pedido_item->pedidos_id)) ? $pedido_item->pedidos_id : $pedidos_id); ?> "
                class="btn btn-primary">Voltar</a>
        </div>

    </div>
</form>

<h3 class="mt-3">Fotos do ambiente</h3>
<div class="col-auto mt-2 mb-4">
    <a href="<?php echo URL_BASE . "foto_item_pedido/create/" . $pedido_item->pedido_item_id ?> "
        class="btn btn-primary">Adicionar foto</a>
</div>
<div class="row">
    <?php foreach ($foto_item_pedido as $item) { ?>
        <div class="col-md-3 col-12">
            <?php if (isset($item->foto_item_pedido_caminho)) { ?>
                <a href="#" data-toggle="modal" data-target="#imagemModal">
                    <img class="img-thumbnail" width="200" src="<?php echo (URL_IMAGEM . $item->foto_item_pedido_caminho) ?>"
                        alt="Imagem">
                </a>
            <?php } ?>
            <div class="col-12">
                <a href="<?php echo URL_BASE . "Foto_item_pedido/edit/" . $item->foto_item_pedido_id ?>"
                    class="btn btn-primary btn-sm">Editar</a>

                <button onclick="deletarFoto(<?php echo $item->foto_item_pedido_id; ?>)" type="button"
                    class="btn btn-danger btn-sm " data-bs-toggle="modal" data-bs-target="#deleteModal">
                    Deletar
                </button>
            </div>
        </div>
    <?php } ?>
</div>
</table>

<!-- Modal imagem-->
<div class="modal fade" id="imagemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img class="img-fluid" src="<?php echo (URL_IMAGEM . $item->foto_item_pedido_caminho) ?>"
                    alt="Imagem em tela inteira">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
                Tem certeza de que deseja deletar esta foto?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="modal_ok" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!-- balão ajuda -->
<div id="balaoAjuda" class="balao-ajuda">
    <p style="white-space: pre-line;">Texto de ajuda aqui...</p>
    <img src="">
</div>

<script src="<?php echo URL_BASE . 'assets/js/pedido_item5.js' ?>"></script>
<script src="<?php echo URL_BASE . 'assets/js/pedido_item_criaComposicao7.js' ?>"></script>
<script>


    function ajuda(botao, id) {

        var larguraMaxima = 400;

        if (id == -1) {
            $('#balaoAjuda p').text("O markup é a porcentagem de lucro que você deseja em cima do custo do produto.\n Sendo assim, 2 seria o dobro do custo. Ficando por exemplo em uma tela que custa 100 reais, teria 100 reais de margem de lucro bruto para você que está revendendo.\n Para o cliente, vai aparecer apenas o valor final, de 200 reais.");
            $('#balaoAjuda p').show();
            $('#balaoAjuda img').hide();
        } else {
            const itenComposicao = composicao.filter(item => item.composicao_id == id);
            if (itenComposicao[0].ajuda_texto != '') {
                $('#balaoAjuda p').text(itenComposicao[0].ajuda_texto);
                $('#balaoAjuda p').show();
            } else {
                $('#balaoAjuda p').hide();
            }

            if (itenComposicao[0].ajuda_imagem != '') {
                $('#balaoAjuda img').attr('src', URL_IMAGEM + itenComposicao[0].ajuda_imagem);
                $('#balaoAjuda img').show();
                larguraMaxima = 600
            } else {
                $('#balaoAjuda img').hide();
            }
        }

        var rect = botao.getBoundingClientRect();

        balaoAjuda.style.display = (balaoAjuda.style.display === 'none' || balaoAjuda.style.display === '') ? 'block' : 'none';


        if (window.innerWidth < larguraMaxima) {
            larguraMaxima = window.innerWidth
        }
        balaoAjuda.style.maxWidth = larguraMaxima + 'px';

        var topPosition = rect.bottom + window.scrollY;
        var bottomPosition = window.innerHeight - rect.top + window.scrollY;

        var larguraDoBalao = $('#balaoAjuda').width();
        var leftPosition = rect.left
        if (rect.left + larguraDoBalao > window.innerWidth) {
            leftPosition = window.innerWidth - larguraDoBalao;
        }
        console.log(topPosition);
        balaoAjuda.style.top = topPosition + 'px';
        balaoAjuda.style.left = leftPosition + 'px';

    }

    function func2() {

    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            balaoAjuda.style.display = 'none';
        }
    });

    $(document).on('click', function (event) {
        if ($(event.target).closest('#balaoAjuda').length) {
            $('#balaoAjuda').hide();
        }
    });

    //select com pesquisa
    $(document).ready(function () {
        $('#produtos_id').select2();
        $('#produtos_id').on('select2:select', function (e) {
            var data = e.params.data;
            mudaSelectProduto(data);
        });
    });

    controller = 'foto_item_pedido';
    caminhoRetornoDelete = '<?php echo 'Pedido_item/edit/' . $pedido_item->pedido_item_id ?>';
    var idLinha = 0;

    function deletarFoto(id) {
        idLinha = id;
    }

    const larguraInput = document.getElementById('pedido_item_largura');
    const alturaInput = document.getElementById('pedido_item_altura');
    const quantidadeInput = document.getElementById('pedido_item_quantidade');
    const input_valor_unitario = document.getElementById('pedido_item_valor_opcionais');
    const input_valor_total = document.getElementById('pedido_item_valor_total');
    const input_valor_unitario_tabela = document.getElementById('pedido_item_valor_unitario');
    const input_pedido_item_valor_venda = document.getElementById('pedido_item_valor_venda');
    const input_pedido_item_markup = document.getElementById('pedido_item_markup');
    const btnSalvar = document.getElementById('btnSalvar');
    const selectProduto = document.getElementById('produtos_id');

    larguraInput.addEventListener('change', processarInputs);
    alturaInput.addEventListener('change', processarInputs);
    quantidadeInput.addEventListener('change', processarInputs);
    btnSalvar.addEventListener('click', salva);

    var selectedOption = selectProduto.options[selectProduto.selectedIndex];
    var usaTabelaPreco = selectedOption.getAttribute("usaTabelaPreco");
    let tabelaDePreco = null;
    let dadosJson;
    let composicao;

    const pedido_item_id = <?php echo (isset($pedido_item->pedido_item_id)) ? $pedido_item->pedido_item_id : 0; ?>
    <?php $json_dados = json_encode($pedido_item_composicao); ?>

    const composicaoSalva = <?php echo $json_dados; ?>;
    const URL_IMAGEM_500 = "<?php echo URL_IMAGEM_500 ?>";

    function fechaDanger() {
        alert = document.getElementById('alert-danger')
        alert.classList.add('hidden')
        alert.classList.remove('d-flex')
    }

    mudaSelectProduto()

</script>