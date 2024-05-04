
<h1>
    <?php echo (isset($ordem_producao_item->ordem_producao_item_id)) ? 'Editar Itens da Ordem de Produção' : 'Adicionar Itens da Ordem de Produção'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Ordem_producao_item/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="ordem_producao_id">Ordem produção</label>
        <input type="number" class="form-control" id="ordem_producao_id" name="ordem_producao_id"
        value="<?php echo (isset($ordem_producao_item->ordem_producao_id)) ? $ordem_producao_item->ordem_producao_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="ambiente">Ambiente</label>
        <input type="text" class="form-control" id="ambiente" name="ambiente"
        value="<?php echo (isset($ordem_producao_item->ambiente)) ? $ordem_producao_item->ambiente : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="modelo">modelo</label>
        <input type="number" class="form-control" id="modelo" name="modelo"
        value="<?php echo (isset($ordem_producao_item->modelo)) ? $ordem_producao_item->modelo : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="largura">Largura</label>
        <input type="number" class="form-control" id="largura" name="largura"
        value="<?php echo (isset($ordem_producao_item->largura)) ? $ordem_producao_item->largura : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="altura">Altura</label>
        <input type="number" class="form-control" id="altura" name="altura"
        value="<?php echo (isset($ordem_producao_item->altura)) ? $ordem_producao_item->altura : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="cor">Cor</label>
        <input type="text" class="form-control" id="cor" name="cor"
        value="<?php echo (isset($ordem_producao_item->cor)) ? $ordem_producao_item->cor : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="tipo_tela">Tipo de tela</label>
        <input type="text" class="form-control" id="tipo_tela" name="tipo_tela"
        value="<?php echo (isset($ordem_producao_item->tipo_tela)) ? $ordem_producao_item->tipo_tela : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="tipo_conexao">Tipo de tela</label>
        <input type="text" class="form-control" id="tipo_conexao" name="tipo_conexao"
        value="<?php echo (isset($ordem_producao_item->tipo_conexao)) ? $ordem_producao_item->tipo_conexao : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="largura_corte">Largura de corte</label>
        <input type="number" class="form-control" id="largura_corte" name="largura_corte"
        value="<?php echo (isset($ordem_producao_item->largura_corte)) ? $ordem_producao_item->largura_corte : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="altura_corte">Altura de corte</label>
        <input type="number" class="form-control" id="altura_corte" name="altura_corte"
        value="<?php echo (isset($ordem_producao_item->altura_corte)) ? $ordem_producao_item->altura_corte : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="tamanho_trilho_superior">Tamanho do trilho superior</label>
        <input type="number" class="form-control" id="tamanho_trilho_superior" name="tamanho_trilho_superior"
        value="<?php echo (isset($ordem_producao_item->tamanho_trilho_superior)) ? $ordem_producao_item->tamanho_trilho_superior : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="tamanho_trilho_inferior">Tamanho do trilho inferior</label>
        <input type="number" class="form-control" id="tamanho_trilho_inferior" name="tamanho_trilho_inferior"
        value="<?php echo (isset($ordem_producao_item->tamanho_trilho_inferior)) ? $ordem_producao_item->tamanho_trilho_inferior : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="instalacao">Intalação</label>
        <input type="text" class="form-control" id="instalacao" name="instalacao"
        value="<?php echo (isset($ordem_producao_item->instalacao)) ? $ordem_producao_item->instalacao : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="tipo_trilho_superior">Tipo do trilho superior</label>
        <input type="text" class="form-control" id="tipo_trilho_superior" name="tipo_trilho_superior"
        value="<?php echo (isset($ordem_producao_item->tipo_trilho_superior)) ? $ordem_producao_item->tipo_trilho_superior : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="tipo_trilho_infeior">Tipo do trilho inferior</label>
        <input type="text" class="form-control" id="tipo_trilho_infeior" name="tipo_trilho_infeior"
        value="<?php echo (isset($ordem_producao_item->tipo_trilho_infeior)) ? $ordem_producao_item->tipo_trilho_infeior : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="fixacao_trilho_superior">Fixação do trilho superior</label>
        <input type="text" class="form-control" id="fixacao_trilho_superior" name="fixacao_trilho_superior"
        value="<?php echo (isset($ordem_producao_item->fixacao_trilho_superior)) ? $ordem_producao_item->fixacao_trilho_superior : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="fixacao_trilho_inferior">Fixação do trilho inferior</label>
        <input type="text" class="form-control" id="fixacao_trilho_inferior" name="fixacao_trilho_inferior"
        value="<?php echo (isset($ordem_producao_item->fixacao_trilho_inferior)) ? $ordem_producao_item->fixacao_trilho_inferior : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="posicao_escovas">Posição escovas</label>
        <input type="text" class="form-control" id="posicao_escovas" name="posicao_escovas"
        value="<?php echo (isset($ordem_producao_item->posicao_escovas)) ? $ordem_producao_item->posicao_escovas : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="cor_escovas">Cor das Escovas</label>
        <input type="text" class="form-control" id="cor_escovas" name="cor_escovas"
        value="<?php echo (isset($ordem_producao_item->cor_escovas)) ? $ordem_producao_item->cor_escovas : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="altura_escovas">Altura das escovas</label>
        <input type="number" class="form-control" id="altura_escovas" name="altura_escovas"
        value="<?php echo (isset($ordem_producao_item->altura_escovas)) ? $ordem_producao_item->altura_escovas : ''; ?>" required>
    </div>


    <input type="hidden" name="ordem_producao_item_id" value="<?php echo (isset($ordem_producao_item->ordem_producao_item_id)) ? $ordem_producao_item->ordem_producao_item_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Ordem_producao_item" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

