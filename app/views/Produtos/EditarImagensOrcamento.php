<style>
    .conta {
        position: relative;
        display: inline-block;
        width: 900px;
    }

    .overlay-image {
        position: absolute;
        cursor: pointer;
    }

    .imagem-maior {
        width: 100%;
        /* Ajusta a largura do contêiner */
        display: block;
        /* Remove o espaço abaixo da imagem */
    }

    .imagem-menor {
        position: absolute;
        top: 20px;
        /* Posiciona 20px do topo do contêiner */
        left: 20px;
        /* Posiciona 20px da esquerda do contêiner */
        height: auto;
        /* Para manter a proporção da imagem menor */
    }

    .imagem-pg {
        width: 900px;
    }

    .folha {
        width: 900px;
        margin: auto;
    }

    #loadingModal {
        background-color: rgba(0, 0, 0, 0.5);
        /* Cor de fundo com opacidade */
    }

    #loadingModal .modal-dialog {
        display: flex;
        align-items: center;
        min-height: 100vh;
        /* Altura total da viewport */
    }

    #loadingModal .modal-content {
        width: 100%;
        background: transparent;
        border: none;
    }

    #loadingModal .spinner-border {
        width: 3rem;
        height: 3rem;
    }
</style>

<div class="row mt-2 mb-2">
    <div class="col-6">
        <!-- Upload Background Image -->
        <div class="input-group mb-3 col-md-3">
            <input type="file" class="form-control" id="uploadBackground" accept="image/*">
            <label class="input-group-text" for="uploadBackground">Escolha uma folha</label>
        </div>
    </div>

    <div class="col-6 mb-3">
        <div class="input-group mr-2 col-md-3 mb-2">
            <input type="file" class="form-control" id="uploadOverlay" accept="image/*">
            <label class="input-group-text" for="uploadOverlay">Escolha uma imagem para o link</label>
        </div>
        <input type="text" id="overlayLink" placeholder="Insira o link aqui" class="form-control col-md-3  mb-2">
        <button id="addOverlay" class="btn btn-primary btn-sm">Adicionar Imagem Sobreposta</button>
    </div>
    <div class="col-auto">
        <a href="<?php echo URL_BASE . "Produtos/edit/" . $produtos_id ?>" class="btn btn-primary">Voltar</a>
    </div>
    <div class="col-auto">
        <button id="salvaImagem" class="btn btn-primary">Salvar</button>
    </div>
    <div class="col-auto">
        <button id="limparCampos" class="btn btn-danger">Limpar Imagem</button>
    </div>
</div>
<div class="row  justify-content-center">
    <div class="folha">
        <div id="container" class="conta bg-white shadow ">
            <?php echo $imagem ?>
        </div>
    </div>
</div>
<div id="loadingModal" class="modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('limparCampos').onclick = function () {
            container.innerHTML = '';
            overlayLink.value = '';
        };


        const imagensMenores = document.querySelectorAll('.imagem-menor');

        imagensMenores.forEach(function (imagemMenor) {
            imagemMenor.addEventListener('click', function (e) {
                if (deleteBtn) {
                    deleteBtn.remove();
                }
                createDeleteButton(imagemMenor.parentNode, imagemMenor);
                e.stopPropagation();
            });

            imagemMenor.addEventListener('mousedown', function (e) {
                isDragging = true;
                activeImage = imagemMenor;
                offset = [
                    imagemMenor.offsetLeft - e.clientX,
                    imagemMenor.offsetTop - e.clientY
                ];
            });
        });

        document.getElementById('salvaImagem').onclick = function () {
            $('#loadingModal').modal('show');
            const containerHtml = document.getElementById('container').innerHTML;

            const postData = {
                html: containerHtml,
                csrf_token: '<?php echo $_SESSION['csrf_token'] ?>',
                produtos_id: '<?php echo $produtos_id ?>'
                // Outros valores que você deseja enviar como parâmetros POST
            };
            // Envia os dados para o servidor
            fetch('<?php echo URL_BASE . 'Produtos/salvaOrcamento' ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(postData)
            })
                .then(response => {
                    location.reload();
                })
                .catch(error => {
                    location.reload();
                });
        };

        const uploadBackground = document.getElementById('uploadBackground');
        const uploadOverlay = document.getElementById('uploadOverlay');
        const overlayLink = document.getElementById('overlayLink');
        const addOverlayButton = document.getElementById('addOverlay');
        const container = document.getElementById('container');
        let deleteBtn = null;
        // Função para adicionar a imagem de fundo
        uploadBackground.onchange = function () {
            const file = this.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('imagem-pg');
                img.classList.add('imagem-maior');
                container.innerHTML = ''; // Limpa o contêiner antes de adicionar a nova imagem de fundo
                container.appendChild(img);
            };
            reader.readAsDataURL(file);
        };

        let activeImage = null;
        let isDragging = false;
        // Função para adicionar e permitir arrastar a imagem sobreposta
        function addDraggableImage(src, link) {
            const a = document.createElement('a');
            a.href = link;
            a.target = '_blank';
            a.classList.add('linkExt');

            const img = document.createElement('img');
            img.src = src;
            img.classList.add('overlay-image');
            img.style.position = 'absolute';
            img.style.left = '50px';
            img.style.top = '50px';
            img.classList.add('imagem-menor');

            // Anexa a imagem ao link, e ambos ao contêiner
            a.appendChild(img);
            container.appendChild(a);

            img.addEventListener('mousedown', function (e) {
                isDragging = true;
                if (isDragging) {
                    activeImage = img;
                    offset = [
                        img.offsetLeft - event.clientX,
                        img.offsetTop - event.clientY
                    ];
                };
            });

            img.addEventListener('click', function (e) {
                if (deleteBtn) {
                    deleteBtn.remove();
                }
                createDeleteButton(a, img);
                e.stopPropagation();
            });
            a.style.cursor = 'move';
        }

        function createDeleteButton(a) {
            deleteBtn = document.createElement('button');
            deleteBtn.textContent = 'Deletar';
            deleteBtn.classList.add('btn');
            deleteBtn.classList.add('btn-danger');
            deleteBtn.onclick = function () {
                if (confirm('Tem certeza que deseja deletar esta imagem e o link?')) {
                    container.removeChild(a);
                    deleteBtn.remove();
                    deleteBtn = null;
                }
            };
            addOverlayButton.parentNode.insertBefore(deleteBtn, addOverlayButton.nextSibling);
        }

        // Clique no container para esconder o botão deletar
        container.addEventListener('click', function () {
            if (deleteBtn) {
                deleteBtn.remove();
                deleteBtn = null;
            }
        });

        container.onmousemove = function (event) {
            if (activeImage) {
                activeImage.style.left = (event.clientX + offset[0]) + 'px';
                activeImage.style.top = (event.clientY + offset[1]) + 'px';
            }
            event.preventDefault();
        };

        container.onmouseup = function (event) {
            activeImage = null;
        };

        // Adiciona a imagem sobreposta com funcionalidade de arrastar
        addOverlayButton.onclick = function () {
            const file = uploadOverlay.files[0];
            const link = overlayLink.value;
            if (file && link) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    addDraggableImage(e.target.result, link);
                };
                reader.readAsDataURL(file);
            } else {
                alert('Por favor, selecione uma imagem e insira um link.');
            }
        };

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('linkExt') || e.target.parentElement.classList.contains('linkExt')) {
                e.preventDefault();
            }
        }, true);
    });

</script>