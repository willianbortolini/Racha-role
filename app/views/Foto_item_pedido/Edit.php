<style>
    .exclusao-ativa img {
        opacity: 0.3;
    }
</style>
<h1>
    <?php echo (isset($foto_item_pedido->foto_item_pedido_id)) ? 'Editar Foto do ambiente' : 'Adicionar Foto do ambiente'; ?>
</h1>

<form action="<?php echo URL_BASE . "Foto_item_pedido/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="row">
        <div class="form-group col-lg-6 col-12 mb-2">
            <?php if (isset($foto_item_pedido->foto_item_pedido_caminho) && $foto_item_pedido->foto_item_pedido_caminho != '') { ?>
                <label class="container-imagem" for="foto_item_pedido_caminho">
                    <img id="preview" width="250" height="250"
                        src="<?php echo (isset($foto_item_pedido->foto_item_pedido_caminho)) ? (URL_IMAGEM . $foto_item_pedido->foto_item_pedido_caminho) : ''; ?>">
                </label>
                <div class="image-buttons mt-1 mb-1">
                    <button type="button" class="btn btn-primary btn-edit"
                        data-target="foto_item_pedido_caminho">Editar</button>
                    <button type="button" class="btn btn-danger btn-delete ms-2"
                        data-target="remove_foto_item_pedido_caminho">Excluir</button>
                    <input type="checkbox" class="form-check-input visually-hidden" id="remove_foto_item_pedido_caminho"
                        name="remove_foto_item_pedido_caminho" value="1">
                </div>
            <?php } else { ?>
                <label class="container-imagem" for="foto_item_pedido_caminho">
                    <svg class="bd-placeholder-img " width="250" height="250" role="img" focusable="false">
                        <rect width="100%" height="100%" fill="#868e96"></rect>
                        <text x="10%" y="50%" fill="#dee2e6" dy=".3em">Carregue uma imagem</text>
                    </svg>
                </label>
            <?php } ?>
            <input type="file" class="form-control-file  visually-hidden" id="foto_item_pedido_caminho" name="foto_item_pedido_caminho" 
            onchange="processarImagem(this)">

            <!--<input type="file" class="form-control-file visually-hidden" id="foto_item_pedido_caminho"
                name="foto_item_pedido_caminho">-->
        </div>
    </div>


    <input type="hidden" class="form-control" id="pedido_item_id" name="pedido_item_id"
        value="<?php echo (isset($foto_item_pedido->pedido_item_id)) ? $foto_item_pedido->pedido_item_id : $pedido_item_id ?>">

    <input type="hidden" name="foto_item_pedido_id"
        value="<?php echo (isset($foto_item_pedido->foto_item_pedido_id)) ? $foto_item_pedido->foto_item_pedido_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "Pedido_item/edit/" . ((isset($foto_item_pedido->pedido_item_id)) ? $foto_item_pedido->pedido_item_id : $pedido_item_id) ?>"
                class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>
<script src="<?php echo URL_BASE ?>assets/js/inputImg.js"></script>

<script>
function processarImagem(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var img = new Image();
            img.src = e.target.result;

            img.onload = function () {
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');
                var maxW = 1024;
                var maxH = 1024;

                var width = img.width;
                var height = img.height;

                // Redimensionar a imagem
                if (width > height) {
                    if (width > maxW) {
                        height *= maxW / width;
                        width = maxW;
                    }
                } else {
                    if (height > maxH) {
                        width *= maxH / height;
                        height = maxH;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                // Converter a imagem para JPEG
                canvas.toBlob(function(blob) {
                    var novoArquivo = new File([blob], "imagem_redimensionada.jpg", {type: "image/jpeg", lastModified: Date.now()});
                    // Substituir o arquivo original pelo redimensionado
                    var container = new DataTransfer();
                    container.items.add(novoArquivo);
                    input.files = container.files;

                    // Atualizar a visualização da imagem
                    var readerPreview = new FileReader();
                    readerPreview.onload = function (e) {
                        document.getElementById('preview').src = e.target.result;
                    }
                    readerPreview.readAsDataURL(novoArquivo);
                }, 'image/jpeg', 0.70); // Ajuste a qualidade do JPEG aqui, se necessário
            };
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>