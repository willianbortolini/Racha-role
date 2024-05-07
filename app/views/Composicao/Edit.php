<style>
    .hidden {
        display: none;
    }
</style>

<h1>
    <?php echo (isset($composicao->composicao_id)) ? 'Editar Composição do produto' : 'Adicionar Composição do produto'; ?>
</h1>

<form action="<?php echo URL_BASE . "Composicao/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2 col-12 col-md-6">
        <label for="composicao_nome">Nome</label>
        <input type="text" class="form-control" id="composicao_nome" name="composicao_nome"
            value="<?php echo (isset($composicao->composicao_nome)) ? $composicao->composicao_nome : ''; ?>" required>
    </div>

    <div class="form-group mb-2 col-12 col-md-2">
        <input type="checkbox" class="form-check-input" id="composicao_obrigatoria" name="composicao_obrigatoria" <?php echo (isset($composicao->composicao_obrigatoria) && $composicao->composicao_obrigatoria == 1) ? 'checked' : ''; ?>>
        <label for="composicao_nome">Preenchimento obrigatorio</label>
    </div>

    <?php if (isset($composicao->composicao_pai_id) and ($composicao->composicao_pai_id == 0)) { ?>
        <div class="form-group mb-2 col-12 col-md-6">
            <label for="composicao_ordem">Ordem de exibição</label>
            <input type="number" class="form-control" id="composicao_ordem" name="composicao_ordem"
                value="<?php echo (isset($composicao->composicao_ordem)) ? $composicao->composicao_ordem : ''; ?>">
        </div>
    <?php } ?>
    <div class="form-group mb-2 col-12 col-md-6">
        <label for="composicao_tipo_id">Tipo</label>
        <select class="form-select" aria-label="Default select example" name="composicao_tipo_id" required>

            <?php
            /*if ($composicao_pai->composicao_tipo_id == 3) {
                echo "<option value='4' selected>Opção selecionar</option>";
            } else {*/
                echo "<option value='0'></option>";
                foreach ($composicao_tipo as $item) {
                    //if ($item->composicao_tipo_id != 4) {
                        echo "<option value='$item->composicao_tipo_id'" . ($item->composicao_tipo_id == $composicao->composicao_tipo_id ? "selected" : "") . ">$item->composicao_tipo_nome</option>";
                    //}
                }
            //} 
            ?>
        </select>
    </div>


    <div class="form-group mb-2 hidden col-12 col-md-6">
        <label for="composicao_padrao_id">composicao padrao</label>
        <select class="form-select" aria-label="Default select example" name="composicao_padrao_id">
            <option value="0"></option>
            <?php foreach ($composicao_padrao as $item) {
                echo "<option value='$item->composicao_id'" . ($item->composicao_id == $composicao->composicao_padrao_id ? "selected" : "") . ">$item->composicao_nome</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2 col-12 col-md-6">
        <label for="composicao_formula">Formula</label>
        <input type="text" class="form-control" id="composicao_formula" name="composicao_formula"
            value="<?php echo (isset($composicao->composicao_formula)) ? $composicao->composicao_formula : ''; ?>">
        l = largura <br>
        a = altura <br>
        q = quantidade <br>
        v = valor <br>
        t = valor de tabela do produto <br>
    </div>
    <div class="card col-12 col-md-6 mb-2">
        <div class="card-body">
            <h5>Informações para ordem de produção</h5>
            <div class="form-group mb-2 col-12 ">
                <label for="composicao_op_posicao">Posição OP</label>
                <select class="form-select" aria-label="Default select example" name="composicao_op_posicao">
                    <option value="0"></option>
                    <?php foreach ($posicoes_op as $item) {
                        echo "<option value='$item->posicao_op_id'" . ($item->posicao_op_id == $composicao->composicao_op_posicao ? "selected" : "") . ">$item->descricao</option>";
                    } ?>
                </select>
                <label for="composicao_op_formula">Formula da OP</label>
                <input type="text" class="form-control" id="composicao_op_formula" name="composicao_op_formula"
                    value="<?php echo (isset($composicao->composicao_op_formula)) ? $composicao->composicao_op_formula : ''; ?>">

            </div>
        </div>
    </div>

    <div class="card col-12 col-md-6 mb-2">
        <div class="card-body">
            <h5>Consumo de insumo</h5>
            <div class="form-group mb-2 col-12 ">
                <label for="insumo">Insumo</label>
                <select class="form-select" aria-label="Default select example" name="insumo">
                    <option value="0"></option>
                    <?php foreach ($insumos as $item) {
                        echo "<option value='$item->produtos_id'" . ($item->produtos_id == $composicao->insumo ? "selected" : "") . ">$item->produtos_nome</option>";
                    } ?>
                </select>
                <label for="quantidade_insumo">Quantidade</label>
                <input type="text" class="form-control" id="quantidade_insumo" name="quantidade_insumo"
                    value="<?php echo (isset($composicao->quantidade_insumo)) ? $composicao->quantidade_insumo : ''; ?>">

            </div>
        </div>
    </div>

    <div class="card col-12 col-md-6 mb-2">
        <div class="card">
            <div class="card-header bg-primary text-white clickable d-flex justify-content-between">
                <span>Ajuda para o representante<i class="bi bi-chevron-down"></i></span>
                <span class="toggle-icon">+</span>
            </div>
            <div class="card-body collapse">
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label for="ajuda_texto">Texto de ajuda</label>
                        <textarea class="form-control" id="ajuda_texto"
                            name="ajuda_texto"><?php echo (isset($composicao->ajuda_texto)) ? $composicao->ajuda_texto : ''; ?></textarea>
                    </div>

                    Imagem de ajuda
                    <div class="row">
                        <div class="form-group col-lg-6 col-12 mb-2">
                            <?php if (isset($composicao->ajuda_imagem) && $composicao->ajuda_imagem != '') { ?>
                                <label class="container-imagem" for="ajuda_imagem">
                                    <img id="preview" width="250" height="250"
                                        src="<?php echo (isset($composicao->ajuda_imagem)) ? (URL_IMAGEM . $composicao->ajuda_imagem) : ''; ?>">
                                </label>
                                <div class="image-buttons mt-1 mb-1">
                                    <button type="button" class="btn btn-primary btn-edit"
                                        data-target="ajuda_imagem">Editar</button>
                                    <button type="button" class="btn btn-danger btn-delete ms-2"
                                        data-target="remove_ajuda_imagem">Excluir</button>
                                    <input type="checkbox" class="form-check-input visually-hidden" id="remove_ajuda_imagem"
                                        name="remove_ajuda_imagem" value="1">
                                </div>
                            <?php } else { ?>
                                <label class="container-imagem" for="ajuda_imagem">
                                    <svg class="bd-placeholder-img " width="250" height="250" role="img" focusable="false">
                                        <rect width="100%" height="100%" fill="#868e96"></rect>
                                        <text x="10%" y="50%" fill="#dee2e6" dy=".3em">Carregue uma imagem</text>
                                    </svg>
                                </label>
                            <?php } ?>
                            <input type="file" class="form-control-file visually-hidden" id="ajuda_imagem"
                                name="ajuda_imagem">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <input type="hidden" name="composicao_pai_id"
        value="<?php echo (isset($composicao->composicao_pai_id)) ? $composicao->composicao_pai_id : $composicao_pai_id; ?>">
    <input type="hidden" name="produtos_id"
        value="<?php echo (isset($composicao->produtos_id)) ? $composicao->produtos_id : $produtos_id; ?>">
    <input type="hidden" name="composicao_id"
        value="<?php echo (isset($composicao->composicao_id)) ? $composicao->composicao_id : NULL; ?>">
    <input type="hidden" name="composicao_referencia"
        value="<?php echo (isset($composicao_referencia)) ? $composicao_referencia : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <?php if ((isset($composicao->produtos_id) && ($composicao->produtos_id > 0)) || ((isset($produtos_id) && ($produtos_id > 0)))) { ?>
                <a href="<?php echo URL_BASE . "Composicao/show/" . ((isset($composicao->produtos_id)) ? $composicao->produtos_id : $produtos_id); ?>"
                    class="btn btn-primary">Voltar</a>
            <?php } else if (isset($composicao_referencia)) { ?>
                    <a class="btn btn-primary"
                        href="<?php echo URL_BASE . "Composicao/padrao_item/" . $composicao_referencia ?>">Voltar</a>
            <?php } else { ?>
                    <a class="btn btn-primary" href="<?php echo URL_BASE . "Composicao/padrao/" ?>">Voltar</a>
            <?php } ?>
        </div>
    </div>
</form>

<script src="<?php echo URL_BASE ?>assets/js/inputImg.js"></script>
<script>
    //sd
    function toggleComposicaoPadraoSelect() {

        var composicaoTipoSelect = document.getElementsByName("composicao_tipo_id")[0];
        var composicaoPadraoSelect = document.getElementsByName("composicao_padrao_id")[0];
        var inputFormula = document.getElementsByName("composicao_formula")[0];

        if (composicaoTipoSelect.value == 8) {
            composicaoPadraoSelect.parentElement.classList.remove("hidden");
            inputFormula.parentElement.classList.add("hidden");
        } else {
            composicaoPadraoSelect.parentElement.classList.add("hidden");
            inputFormula.parentElement.classList.remove("hidden");
        }
    }

    document.getElementsByName("composicao_tipo_id")[0].addEventListener("change", toggleComposicaoPadraoSelect);
    toggleComposicaoPadraoSelect();

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