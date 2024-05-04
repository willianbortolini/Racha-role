<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">



<style>
    canvas {
        border: 1px solid #000;
    }

    .hidden {
        display: none;
    }
</style>

<h2>
    <?php echo ((isset($produto->produtos_nome)) ? $produto->produtos_nome : ''); ?>
</h2>
<a href="#" class="btn btn-secondary  btn-sm m-2" id="filho-principal-btn">
    Criar composição filha do produto principal
</a>
<div class="row">
    <div class="col-8">
        <canvas id="myCanvas" width="850" height="900px"></canvas>
    </div>
    <div class="col-4">
        <div id="editCard" class="card m-2">
            <div class="card-body">
                <div id="avisoComPadrao" class="alert alert-danger mt-3 hidden" role="alert">
                    Essa é uma composição padrão.
                </div>
                <div class='row'>
                    <div class="form-group mb-2 col-6">
                        <label for="composicao_nome">Nome</label>
                        <input type="text" class="form-control" id="composicao_nome" name="composicao_nome" required>
                    </div>
                    <div class="form-group mb-2 col-6">
                        <input type="checkbox" class="form-check-input" id="composicao_obrigatoria"
                            name="composicao_obrigatoria">
                        <label for="composicao_nome">obrigatorio</label>
                    </div>
                    <div class="form-group mb-2 col-6">
                        <label for="composicao_tipo_id">Tipo</label>
                        <select class="form-select" aria-label="Default select example" name="composicao_tipo_id"
                            id="composicao_tipo_id">
                            <option value="0"></option>
                            <?php foreach ($composicao_tipo as $item) {
                                echo "<option value='$item->composicao_tipo_id'>$item->composicao_tipo_nome</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="form-group mb-2 col-6">
                        <label for="composicao_ordem">Ordem de exibição</label>
                        <input type="number" class="form-control" id="composicao_ordem" name="composicao_ordem"
                            value="">
                    </div>

                    <div class="form-group mb-2 col-6">
                        <label for="composicao_padrao_id">composicao padrao</label>
                        <select class="form-select" aria-label="Default select example" name="composicao_padrao_id"
                            id="composicao_padrao_id">
                            <option value="0"></option>
                            <?php foreach ($composicao_padrao as $item) {
                                echo "<option value='$item->composicao_id'" . ">$item->composicao_nome</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group mb-2 col-6">
                        <label for="composicao_formula">Formula</label>
                        <input type="text" class="form-control" id="composicao_formula" name="composicao_formula"
                            value="<?php echo (isset($composicao->composicao_formula)) ? $composicao->composicao_formula : ''; ?>">
                    </div>
                    <div class="card col-12 mb-2">
                        <div class="card-body">
                            <h5>Informações para ordem de produção</h5>
                            <div class='row'>
                                <div class="form-group mb-2 col-6 ">
                                    <label for="composicao_op_posicao">Posição OP</label>
                                    <select class="form-select" aria-label="Default select example"
                                        name="composicao_op_posicao" id="composicao_op_posicao">
                                        <option value="0"></option>
                                        <?php foreach ($posicoes_op as $item) {
                                            echo "<option value='$item->posicao_op_id'" . ($item->posicao_op_id == $composicao->composicao_op_posicao ? "selected" : "") . ">$item->descricao</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2 col-6 ">
                                    <label for="composicao_op_formula">Formula da OP</label>
                                    <input type="text" class="form-control" id="composicao_op_formula"
                                        name="composicao_op_formula"
                                        value="<?php echo (isset($composicao->composicao_op_formula)) ? $composicao->composicao_op_formula : ''; ?>">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-12  mb-2">
                        <div class="card-body">
                            <h5>Consumo de insumo</h5>
                            <div class='row'>
                                <div class="form-group mb-2 col-6 ">
                                    <label for="insumo">Insumo</label>
                                    <select class="form-select" aria-label="Default select example" name="insumo"
                                        id="insumo">
                                        <option value="0"></option>
                                        <?php foreach ($insumos as $item) {
                                            echo "<option value='$item->produtos_id'" . ($item->produtos_id == $composicao->insumo ? "selected" : "") . ">$item->produtos_nome</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2 col-6 ">
                                    <label for="quantidade_insumo">Quantidade</label>
                                    <input type="text" class="form-control" id="quantidade_insumo"
                                        name="quantidade_insumo"
                                        value="<?php echo (isset($composicao->quantidade_insumo)) ? $composicao->quantidade_insumo : ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="composicao_pai_id" id="composicao_pai_id" value="">
                <input type="hidden" name="produtos_id" id="produtos_id" value="">
                <input type="hidden" name="composicao_id" id="composicao_id" value="">
                <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="row">
                    <div class="col-auto">
                        <button type="button" id="salvar-btn" class="btn btn-sm btn-primary">Salvar</button>

                        <button type="button" id="filho-btn" class="btn btn-sm btn-secondary">Criar filho</button>

                        <button id_linha="" onclick="deletaEditar(this)" type="button" id="editDeletar"
                            class="btn btn-danger btn-sm deletar" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            Deletar
                        </button>
                    </div>
                </div>

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
                Tem certeza de que deseja deletar este registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="modalDelet_ok" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>

    controller = 'Composicao';
    caminhoRetornoDelete = '<?php echo "Composicao/showMapa/" . $produtos_id ?>';
    var idLinha = 0;
    function deletaEditar(botao) {
        idLinha = botao.getAttribute('id_linha');
    }

    var canvas = document.getElementById('myCanvas');
    var ctx = canvas.getContext('2d');
    var xAtual = 50;
    var yAtual = 50;
    var afastamentoX = 30;
    var afastamentoY = 5;
    var items = [];
    var connections = [];
    var composicao = [];
    pegaComposicao()
    function pegaComposicao() {
        let urlComposicao = URL_BASE + "Composicao/composicaoProduto/" + <?php echo $produtos_id?>;

        fetch(urlComposicao)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro na requisição: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                composicao = data;
                console.log(composicao);
                items = [];
                connections = [];
                xAtual = 50;
                yAtual = 50;
                clickListeners = [];
                index = 0;
                percoreItens(composicao, 0);
                draw();
            })
            .catch(error => {
                console.error('Erro durante a requisição:', error);
            });
    }

    var index = 0;
    var indexpai = 0;
    var terminouforeac = false;
    function percoreItens(data, idItemPai) {

        const composicoesIniciais = data.filter(item => item.composicao_pai_id == idItemPai);
        xAtual += larguraBalao + afastamentoX;
        yAtual -= alturaBalao + afastamentoY;
        var indexAntesFor = index;
        
        composicoesIniciais.forEach(composicaoInicial => {
            items.push({
                x: xAtual,
                y: yAtual,
                text: composicaoInicial.composicao_nome,
                index: composicaoInicial
            });

            yAtual += alturaBalao + afastamentoY;
            if (terminouforeac == false) {
                if (indexAntesFor > 0) {
                    connections.push({
                        from: indexpai,
                        to: index
                    });
                }
            } else {
                if (indexAntesFor > 0) {
                    connections.push({
                        from: indexAntesFor - 1,
                        to: index
                    });
                }
                terminouforeac = false;
            }
            
            index++;
            if (composicaoInicial.composicao_tipo_id == 8) {
                xAtual += larguraBalao + afastamentoX;

                const composicaoPadrao = data.filter(itemPadrao => itemPadrao.composicao_id == composicaoInicial.composicao_padrao_id);
                composicaoPadrao.forEach(composicaoP => {
                    yAtual -= alturaBalao + afastamentoY;
                    items.push({
                        x: xAtual,
                        y: yAtual,
                        text: composicaoP.composicao_nome,
                        index: composicaoP
                    });
                    connections.push({
                        from: index,
                        to: index - 1
                    });
                    yAtual += alturaBalao + afastamentoY;
                    index++;
                })

                const composicoesFilha = data.filter(item => item.composicao_pai_id == composicaoInicial.composicao_padrao_id);
                if (composicoesFilha.length > 0) {
                    indexpai = index - 1
                    percoreItens(data, composicaoInicial.composicao_padrao_id)
                }
                xAtual -= larguraBalao + afastamentoX;
            } else {
                const composicoesFilha = data.filter(item => item.composicao_pai_id == composicaoInicial.composicao_id);
                if (composicoesFilha.length > 0) {
                    indexpai = index - 1
                    percoreItens(data, composicaoInicial.composicao_id)
                }
            }

        });

        yAtual += afastamentoY;
        terminouforeac = true;
        xAtual -= larguraBalao + afastamentoX;

    }

    // Define o fator de zoom inicial
    var zoomFactor = 1;

    // Variáveis para rastrear a posição do mouse durante o pan
    var lastX, lastY;
    var isPanning = false;

    // Mantém uma lista de event listeners de clique por item
    var clickListeners = [];

    var larguraBalao = 100;
    var alturaBalao = 50;
    // Função para desenhar um balão
    function drawBalloon(x, y, text, index) {
        var composicao_id = document.getElementById('composicao_id').value;
        ctx.beginPath();
        ctx.moveTo(x * zoomFactor, y * zoomFactor);
        drawRoundedRect(ctx, x * zoomFactor, (y - (alturaBalao / 2)) * zoomFactor, larguraBalao * zoomFactor, alturaBalao * zoomFactor, 5);
        if(composicao_id ==  index.composicao_id){
            ctx.fillStyle = '#93d184';
        }else{
            ctx.fillStyle = '#c8c8c8';
        }
        ctx.fill();
        ctx.strokeStyle = '#2f2f2f';
        ctx.lineWidth = 1;
        ctx.stroke();
        ctx.font = 12 * zoomFactor + 'px Arial';
        var maxTextLength = 14;
        // Define a fonte e o tamanho do texto
        var displayText = text.length > maxTextLength ? text.substring(0, maxTextLength) + "..." : text;
        ctx.fillStyle = '#000';
        ctx.textAlign = 'center';
        ctx.textAlign = 'left';
        ctx.fillText(displayText, (x + 5) * zoomFactor, (y - (alturaBalao / 2) + 15) * zoomFactor);

        if (index.composicao_tipo_id == 1) {
            ctx.fillStyle = 'black';
            ctx.font = 20 * zoomFactor + 'px FontAwesome';
            ctx.textBaseline = 'middle';
            ctx.fillText("\uf00c", (x + 5) * zoomFactor, (y + 8) * zoomFactor);
        }
        if (index.composicao_tipo_id == 2) {
            ctx.fillStyle = 'black';
            ctx.font = 20 * zoomFactor + 'px FontAwesome';
            ctx.textBaseline = 'middle';
            ctx.fillText("\uf258", (x + 5) * zoomFactor, (y + 8) * zoomFactor);
        }
        if (index.composicao_tipo_id == 3) {
            ctx.fillStyle = 'black';
            ctx.font = 20 * zoomFactor + 'px FontAwesome';
            ctx.textBaseline = 'middle';
            ctx.fillText("\uf078", (x + 5) * zoomFactor, (y + 8) * zoomFactor);
        }
        if (index.composicao_tipo_id == 4) {
            ctx.fillStyle = 'black';
            ctx.font = 20 * zoomFactor + 'px FontAwesome';
            ctx.textBaseline = 'middle';
            ctx.fillText("\uf061", (x + 5) * zoomFactor, (y + 8) * zoomFactor);
        }
        if (index.composicao_tipo_id == 5) {
            ctx.fillStyle = 'black';
            ctx.font = 20 * zoomFactor + 'px FontAwesome';
            ctx.textBaseline = 'middle';
            ctx.fillText("\uf07c", (x + 5) * zoomFactor, (y + 8) * zoomFactor);
        }
        if (index.composicao_tipo_id == 6) {
            ctx.fillStyle = 'black';
            ctx.font = 20 * zoomFactor + 'px FontAwesome';
            ctx.textBaseline = 'middle';
            ctx.fillText("\uf258", (x + 5) * zoomFactor, (y + 8) * zoomFactor);
        }
        if (index.composicao_tipo_id == 7) {
            ctx.fillStyle = 'black';
            ctx.font = 20 * zoomFactor + 'px FontAwesome';
            ctx.textBaseline = 'middle';
            ctx.fillText("\uf070", (x + 5) * zoomFactor, (y + 8) * zoomFactor);
        }
        if (index.composicao_tipo_id == 8) {
            ctx.fillStyle = 'black';
            ctx.font = 20 * zoomFactor + 'px FontAwesome';
            ctx.textBaseline = 'middle';
            ctx.fillText("\uf086", (x + 5) * zoomFactor, (y + 8) * zoomFactor);
        }
        if (index.composicao_tipo_id == 9) {
            ctx.fillStyle = 'black';
            ctx.font = 20 * zoomFactor + 'px FontAwesome';
            ctx.textBaseline = 'middle';
            ctx.fillText("\uf304", (x + 5) * zoomFactor, (y + 8) * zoomFactor);
        }


        if (index.composicao_op_posicao > 0) {
            ctx.fillStyle = 'black';
            ctx.font = 20 * zoomFactor + 'px FontAwesome'; // Define a fonte e o tamanho do ícone
            ctx.textBaseline = 'middle';
            ctx.fillText("\uf0ae", (x + 35) * zoomFactor, (y + 8) * zoomFactor); // Use o código do ícone Font Awesome   
        }
        if (index.insumo > 0) {
            ctx.fillStyle = 'black';
            ctx.font = 20 * zoomFactor + 'px FontAwesome'; // Define a fonte e o tamanho do ícone
            ctx.textBaseline = 'middle';
            ctx.fillText("\uf1b3", (x + 65) * zoomFactor, (y + 8) * zoomFactor); // Use o código do ícone Font Awesome   
        }
    }

    function drawRoundedRect(ctx, x, y, width, height, radius) {
        ctx.beginPath();
        ctx.moveTo(x + radius, y);
        ctx.arcTo(x + width, y, x + width, y + height, radius);
        ctx.arcTo(x + width, y + height, x, y + height, radius);
        ctx.arcTo(x, y + height, x, y, radius);
        ctx.arcTo(x, y, x + width, y, radius);
        ctx.closePath();
        ctx.stroke();
    }

    function drawBezierCurve(x1, y1, x2, y2, isRightCurve) {
        var dx = Math.abs(x2 - x1);
        var dy = Math.abs(y2 - y1);
        var mx = (x1 + x2) / 2;
        var my = (y1 + y2) / 2;

        var cp1x = isRightCurve ? x1 + dx * 0.5 : mx;
        var cp1y = y1;
        var cp2x = isRightCurve ? mx : x2 - dx * 0.5;
        var cp2y = y2;

        ctx.beginPath();
        ctx.moveTo(x1 * zoomFactor, y1 * zoomFactor);
        ctx.bezierCurveTo(cp1x * zoomFactor, cp1y * zoomFactor, cp2x * zoomFactor, cp2y * zoomFactor, x2 * zoomFactor, y2 * zoomFactor);
        ctx.stroke();
    }

    // Use drawBezierCurve em vez de drawLine
    function drawConnections() {
        connections.forEach(function (connection) {
            var fromItem = items[connection.from];
            var toItem = items[connection.to];
            var isRightCurve = fromItem.x < toItem.x; // Verifica se a curva vai para a direita ou para a esquerda
            drawBezierCurve(fromItem.x + larguraBalao + posicaoX, fromItem.y + posicaoY, toItem.x + posicaoX, toItem.y + posicaoY, isRightCurve);
        });
    }

    // Função para desenhar todos os itens e conexões
    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.save();
        //ctx.scale(zoomFactor, zoomFactor);

        // Desenha as conexões entre os itens
        connections.forEach(function (connection) {
            var fromItem = items[connection.from];
            var toItem = items[connection.to];
            drawConnections();
        });

        // Desenha os itens
        items.forEach(function (item, index) {
            drawBalloon(item.x + posicaoX, item.y + posicaoY, item.text, item.index);

            // Remove os event listeners de clique anteriores para o item
            clickListeners[index] && canvas.removeEventListener('click', clickListeners[index]);

            // Adiciona um event listener para o evento de clique em cada item
            clickListeners[index] = function (event) {
                var mouseX = ((event.clientX - canvas.getBoundingClientRect().left) / zoomFactor);
                var mouseY = ((event.clientY - canvas.getBoundingClientRect().top) / zoomFactor);
                if (mouseX >= item.x + posicaoX && mouseX <= item.x + posicaoX + 100 && mouseY >= item.y + posicaoY - 20 && mouseY <= item.y + posicaoY + 20) {
                    atualizaEdit(item.index.composicao_id)
                }
            };
            canvas.addEventListener('click', clickListeners[index]);
        });

        ctx.restore();
    }

    // Função para atualizar o zoom do canvas
    function updateZoom(delta) {
        var zoomStep = 0.1;
        if (delta > 0) {
            // Zoom in
            zoomFactor += zoomStep;
            if (zoomFactor > 2.5) {
                zoomFactor = 2.5;
            }
        } else {
            // Zoom out
            zoomFactor -= zoomStep;
            if (zoomFactor < 0.4) {
                zoomFactor = 0.4;
            }
        }
        // Redesenha o canvas com o zoom atualizado
        draw();
    }

    // Função para tratar o evento de pressionar o botão do scroll do mouse
    function handleMouseDown(event) {
        if (event.button === 1) { // Verifica se o botão do scroll foi pressionado
            event.preventDefault();
            isPanning = true;
            lastX = event.clientX;
            lastY = event.clientY;
        }
    }

    // Função para tratar o evento de soltar o botão do scroll do mouse
    function handleMouseUp() {
        isPanning = false;
    }

    // Função para tratar o evento de movimento do mouse durante o pan
    var posicaoX = 0;
    var posicaoY = 0;
    function handleMouseMove(event) {
        if (isPanning) {
            var deltaX = (event.clientX - lastX)/zoomFactor;
            var deltaY = (event.clientY - lastY)/zoomFactor;
            posicaoX += deltaX;
            posicaoY += deltaY;

            lastX = event.clientX;
            lastY = event.clientY;

            draw();
        }
    }

    // Adiciona event listeners para os eventos de mouse
    canvas.addEventListener('mousedown', handleMouseDown);
    canvas.addEventListener('mouseup', handleMouseUp);
    canvas.addEventListener('mousemove', handleMouseMove);

    // Adiciona um event listener para o evento de rolagem do mouse
    canvas.addEventListener('wheel', function (event) {
        event.preventDefault(); // Evita o comportamento padrão de rolagem da página
        var delta = event.deltaY; // Obtém o valor de rolagem do mouse
        updateZoom(delta); // Atualiza o zoom do canvas
    });

    // Desenha o mapa mental inicialmente
    draw();

    document.getElementById("composicao_tipo_id").addEventListener("change", function () {
        if (this.value == 8) {
            document.getElementById('editDeletar').classList.add('hidden')
            document.getElementById("composicao_padrao_id").selectedIndex = 0;
            document.getElementById("composicao_padrao_id").parentNode.classList.remove('hidden')
        } else {
            document.getElementById('editDeletar').classList.remove('hidden')
            document.getElementById("composicao_padrao_id").parentNode.classList.add('hidden')
        }
    });

    function atualizaEdit(composicao_id) {
        
        var compisicao_item = composicao.filter(item => item.composicao_id == composicao_id);
        //se é uma composição padrão
        /*if (compisicao_item[0].composicao_pai_id == '-1') {
            compisicao_item = composicao.filter(item => item.composicao_padrao_id == composicao_id);
        }*/
        if (compisicao_item[0].produtos_id == -1) {
            document.getElementById('avisoComPadrao').classList.remove('hidden')

        } else {
            document.getElementById('avisoComPadrao').classList.add('hidden')
        }

        document.getElementById("composicao_pai_id").value = compisicao_item[0].composicao_pai_id
        document.getElementById("produtos_id").value = compisicao_item[0].produtos_id
        document.getElementById('composicao_nome').value = compisicao_item[0].composicao_nome
        document.getElementById('composicao_ordem').value = compisicao_item[0].composicao_ordem
        document.getElementById("composicao_id").value = compisicao_item[0].composicao_id
        document.getElementById("composicao_op_formula").value = compisicao_item[0].composicao_op_formula
        document.getElementById("quantidade_insumo").value = compisicao_item[0].quantidade_insumo
        document.getElementById('editDeletar').setAttribute('id_linha', composicao_id);
        if (compisicao_item[0].composicao_obrigatoria == 1) {
            document.getElementById('composicao_obrigatoria').checked = true;
        } else {
            document.getElementById('composicao_obrigatoria').checked = false;
        }

        if (compisicao_item[0].composicao_tipo_id == 8) {//8 = composição padrão
            document.getElementById('editDeletar').classList.add('hidden')
            document.getElementById("composicao_padrao_id").selectedIndex = 0;
            document.getElementById("composicao_padrao_id").parentNode.classList.remove('hidden')
        } else {
            document.getElementById('editDeletar').classList.remove('hidden')
            document.getElementById("composicao_padrao_id").parentNode.classList.add('hidden')
        }
        const inputOpPosicao = document.getElementById("composicao_op_posicao");
        const OpPosicao = compisicao_item[0].composicao_op_posicao;
        inputOpPosicao.selectedIndex = 0;
        for (var i = 0; i < inputOpPosicao.options.length; i++) {
            if (inputOpPosicao.options[i].value == OpPosicao) {
                inputOpPosicao.selectedIndex = i;
                break;
            }
        }

        const inputInsumo = document.getElementById("insumo");
        const Insumo = compisicao_item[0].insumo;
        inputInsumo.selectedIndex = 0;

        for (var i = 0; i < inputInsumo.options.length; i++) {
            if (inputInsumo.options[i].value == Insumo) {
                inputInsumo.selectedIndex = i;
                break;
            }
        }

        const inputTipo = document.getElementById("composicao_tipo_id");
        const tipo = compisicao_item[0].composicao_tipo_id;
        inputTipo.selectedIndex = 0;
        for (var i = 0; i < inputTipo.options.length; i++) {
            if (inputTipo.options[i].value == tipo) {
                inputTipo.selectedIndex = i;
                break;
            }
        }

        const inputcomposicao_padrao_id = document.getElementById("composicao_padrao_id");
        const valorComposicao_padrao = compisicao_item[0].composicao_padrao_id
        inputcomposicao_padrao_id.selectedIndex = 0;
        for (var i = 0; i < inputcomposicao_padrao_id.options.length; i++) {
            if (inputcomposicao_padrao_id.options[i].value == valorComposicao_padrao) {
                inputcomposicao_padrao_id.selectedIndex = i;
                break;
            }
        }
        draw()
    }

    document.querySelector('#salvar-btn').addEventListener('click', function () {
        // Obtém os valores dos campos de entrada
        var nome = document.getElementById('composicao_nome').value;
        var obrigatorio = 'off';
        if (document.getElementById('composicao_obrigatoria').checked == true) {
            obrigatorio = 'on';
        }
        var tipo = document.getElementById('composicao_tipo_id').value;
        var ordem = document.getElementById('composicao_ordem').value;
        var padrao = document.getElementById('composicao_padrao_id').value;
        var formula = document.getElementById('composicao_formula').value;
        var produtos_id = document.getElementById('produtos_id').value;
        var composicao_id = document.getElementById('composicao_id').value;
        var composicao_pai_id = document.getElementById('composicao_pai_id').value;
        var csrf_token = document.getElementById('csrf_token').value;
        var insumo = document.getElementById('insumo').value;
        var quantidade_insumo = document.getElementById('quantidade_insumo').value;
        var composicao_op_posicao = document.getElementById('composicao_op_posicao').value;
        var composicao_op_formula = document.getElementById('composicao_op_formula').value;

        if (tipo == 8) {
            if (padrao == 0) {
                alert("Adicione a composição associada");
                return;
            }
        }
        // Cria um objeto FormData e adiciona os valores aos pares chave/valor
        var formData = new FormData();
        formData.append('composicao_nome', nome);
        formData.append('composicao_obrigatoria', obrigatorio);
        formData.append('composicao_tipo_id', tipo);
        formData.append('composicao_ordem', ordem);
        formData.append('composicao_padrao_id', padrao);
        formData.append('composicao_formula', formula);
        formData.append('produtos_id', produtos_id);
        formData.append('composicao_id', composicao_id);
        formData.append('composicao_pai_id', composicao_pai_id);
        formData.append('insumo', insumo);
        formData.append('quantidade_insumo', quantidade_insumo);
        formData.append('composicao_op_posicao', composicao_op_posicao);
        formData.append('composicao_op_formula', composicao_op_formula);
        formData.append('csrf_token', csrf_token);

        var xhr = new XMLHttpRequest();

        xhr.open('POST', URL_BASE + "Composicao/save", true);

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                pegaComposicao()
                limpaEditar()
            } else {
                console.error('Erro na solicitação');
            }
        };
        xhr.send(formData);
    });

    document.querySelector('#filho-btn').addEventListener('click', function () {
        if (document.getElementById('composicao_tipo_id').value > 0) {
            var produtos_id = document.getElementById('produtos_id').value;
            var composicao_id = document.getElementById('composicao_id').value;
            var csrf_token = document.getElementById('csrf_token').value;

            var formData = new FormData();
            formData.append('composicao_nome', 'composição filha');
            formData.append('composicao_tipo_id', 7);
            formData.append('produtos_id', produtos_id);
            formData.append('composicao_pai_id', composicao_id);
            formData.append('csrf_token', csrf_token);

            var xhr = new XMLHttpRequest();

            xhr.open('POST', URL_BASE + "Composicao/save", true);

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    pegaComposicao()
                    limpaEditar()
                } else {
                    console.error('Erro na solicitação');
                }
            };
            xhr.send(formData);
        }
    });

    document.querySelector('#filho-principal-btn').addEventListener('click', function () {
        var csrf_token = document.getElementById('csrf_token').value;

        var formData = new FormData();
        formData.append('composicao_nome', 'composição filha');
        formData.append('composicao_tipo_id', 7);
        formData.append('produtos_id', <?php echo $produtos_id ?>);
        formData.append('composicao_pai_id', 0);
        formData.append('csrf_token', csrf_token);

        var xhr = new XMLHttpRequest();

        xhr.open('POST', URL_BASE + "Composicao/save", true);

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                pegaComposicao()
                limpaEditar()
            } else {
                console.error('Erro na solicitação');
            }
        };
        xhr.send(formData);
    });

    document.querySelector('#modalDelet_ok').addEventListener('click', function () {
        if (document.getElementById('composicao_id').value > 0) {
            var composicao_id = document.getElementById('composicao_id').value;
            var csrf_token = document.getElementById('csrf_token').value;


            if (caminhoRetornoDelete == undefined) {
                caminhoRetornoDelete = controller;
            }
            var xhr = new XMLHttpRequest();
            xhr.open('POST', URL_BASE + controller + '/delete', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            var formData = new FormData();
            formData.append('_method', 'DELETE');
            formData.append('id', composicao_id);
            formData.append('csrf_token', csrf_token);

            xhr.send(new URLSearchParams(formData));

            xhr.onload = function () {
                if (xhr.status === 200) {
                    pegaComposicao()
                    limpaEditar()
                    $('#deleteModal').modal('hide');
                } else {
                    console.log('Erro na solicitação delete');
                }
            };

        }
    });

    function limpaEditar() {
        document.getElementById("composicao_pai_id").value = ""
        document.getElementById("produtos_id").value = ""
        document.getElementById('composicao_nome').value = ""
        document.getElementById('composicao_ordem').value = ""
        document.getElementById("composicao_id").value = ""
        document.getElementById('composicao_obrigatoria').checked = false;
        document.getElementById("composicao_tipo_id").selectedIndex = 0;
        document.getElementById("composicao_padrao_id").selectedIndex = 0;
        document.getElementById('editDeletar').setAttribute('id_linha', '');
        document.getElementById('insumo').selectedIndex = 0;
        document.getElementById('quantidade_insumo').value = 0;
        document.getElementById('composicao_op_posicao').selectedIndex = 0;
        document.getElementById('composicao_op_formula').value = 0;
    }
</script>