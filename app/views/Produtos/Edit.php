<style>
    .conta {
        position: relative;
        display: inline-block;
        /* Ajusta ao tamanho da imagem maior */
    }

    .imagem-maior {
        width: 100%;
        /* Ajusta a largura do contêiner */
        display: block;
        /* Remove o espaço abaixo da imagem */
    }

    .imagem-menor {
        display: none;
    }

    .folha {
        width: 250;
        margin: auto;
    }
</style>
<h1>
    <?php echo (isset($produtos->produtos_id)) ? 'Editar Produtos' : 'Adicionar Produtos'; ?>
</h1>
<form action="<?php echo URL_BASE . "Produtos/save" ?>" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="form-group mb-2 col-md-4 col-12">
            <label for="produtos_nome">Nome</label>
            <input type="text" class="form-control" id="produtos_nome" name="produtos_nome"
                value="<?php echo (isset($produtos->produtos_nome)) ? $produtos->produtos_nome : ''; ?>" required>
        </div>

        <div class="form-group mb-2 col-2">
            <label for="ordem">Ordem de exibição</label>
            <input type="number" class="form-control" id="ordem" name="ordem"
                value="<?php echo (isset($produtos->ordem)) ? $produtos->ordem : ''; ?>">
        </div>
    </div>
    <div class="row">
        <div class="form-group mb-2 col-12 col-md-2">
            <input type="checkbox" class="form-check-input" id="he_produto_final" name="he_produto_final" <?php echo (isset($produtos->he_produto_final) && $produtos->he_produto_final == 1) ? 'checked' : ''; ?>>
            <label for="he_produto_final">Permite selecionar</label>
        </div>
        <div class="form-group mb-2 col-12 col-md-2 d-none">
            <input type="checkbox" class="form-check-input" id="he_produto_insumo" name="he_produto_insumo" <?php echo (isset($produtos->he_produto_insumo) && $produtos->he_produto_insumo == 1) ? 'checked' : ''; ?>>
            <label for="he_produto_insumo">Insumo</label>
        </div>
        <div class="row">

            <div class="form-group mb-2 col-12 col-md-6">
                <label for="produtos_descricao">Descrição</label>
                <input type="text" class="form-control" id="produtos_descricao" name="produtos_descricao"
                    value="<?php echo (isset($produtos->produtos_descricao)) ? $produtos->produtos_descricao : ''; ?>">
            </div>

            <div class="form-group mb-2 col-12 col-md-3 d-none">
                <label for="descricao_os">Descrição que vai aparecer na OP</label>
                <input type="text" class="form-control" id="descricao_os" name="descricao_os"
                    value="<?php echo (isset($produtos->descricao_os)) ? $produtos->descricao_os : ''; ?>">
            </div>

            <div class="form-group mb-2 col-md-2 col-12 ">
                <label for="preco_medio">Preço</label>
                <input type="number" class="form-control" id="preco_medio" name="preco_medio" step="0.01"
                    value="<?php echo (isset($produtos->preco_medio)) ? $produtos->preco_medio : ''; ?>">
            </div>
        </div>
        <div class="form-group mb-2 col-12 col-md-4 d-none">
            <label for="tabela_preco_id">Tabela de preços</label>
            <select class="form-select" aria-label="Default select example" name="tabela_preco_id" id="tabela_preco_id">
                <option value="0">não usa tabela de preço</option>
                <?php foreach ($tabela_preco as $item) {
                    echo "<option value='$item->tabela_preco_id'" . ($item->tabela_preco_id == $produtos->tabela_preco_id ? "selected" : "") . ">$item->tabela_preco_nome</option>";
                } ?>
            </select>
        </div>
        <?php if (isset($produtos->produtos_id)) { ?>
            <div class="row  mb-4 mt-4 d-none">
                <?php $nomePropriedade = "imagem_produto"; ?>
                <div class=" col-md-3 col-12">
                    <label for="<?= $nomePropriedade ?>">Imagem do produto para orçamento
                    </label>
                    <div class="form-group mb-2">

                        <a href="<?php echo URL_BASE . 'Produtos/editImagemOrcamento/' . $produtos->produtos_id ?>">
                            <?php if (isset($produtos->$nomePropriedade) && $produtos->$nomePropriedade != '') { ?>
                                <div class="folha">
                                    <?php echo $produtos->$nomePropriedade ?>
                                </div>
                            <?php } else { ?>
                                <label class="container-imagem" for="<?= $nomePropriedade ?>">
                                    <svg class="bd-placeholder-img " width="250" height="353" role="img" focusable="false">
                                        <rect width="100%" height="100%" fill="#868e96"></rect>
                                        <text x="10%" y="50%" fill="#dee2e6" dy=".3em">Carregue uma imagem</text>
                                    </svg>
                                </label>

                            <?php } ?>
                        </a>
                    </div>
                </div>

            </div>


        <?php } ?>

        <input type="hidden" name="produtos_id"
            value="<?php echo (isset($produtos->produtos_id)) ? $produtos->produtos_id : NULL; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <div class="row">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
            <?php if ((isset($produtos->he_produto_insumo) && $produtos->he_produto_insumo == 1) || (isset($he_produto_insumo))) { ?>
                <div class="col-auto">
                    <a href="<?php echo URL_BASE . "Produtos/insumos" ?>" class="btn btn-primary">Voltar</a>
                </div>
            <?php } else { ?>
                <div class="col-auto">
                    <a href="<?php echo URL_BASE . "Produtos" ?>" class="btn btn-primary">Voltar</a>
                </div>
            <?php } ?>
            <?php if (isset($produtos->produtos_id)) { ?>
                <div class="col-auto">
                    <a href="<?php echo URL_BASE . "Composicao/show/" . $produtos->produtos_id ?>"
                        class="btn btn-secondary  ">Composição do produto</a>
                </div>
                <div class="col-auto d-none">
                    <a href="<?php echo URL_BASE . "Composicao/showMapa/" . $produtos->produtos_id ?>"
                        class="btn btn-secondary  ">Mapa do produto</a>
                </div>
            <?php } ?>


            
        </div>
</form>
<script src="<?php echo URL_BASE ?>assets/js/inputImg.js"></script>