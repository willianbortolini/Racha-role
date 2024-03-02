<script>
    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    if (!isMobile) {
        window.location.href = "<?php echo URL_BASE ?>";
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
<style>
    body,
    html {
        height: 100%;
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #ACBDC6;
        color: white;
        text-align: center;
    }

    .modal-dialog {
        text-align: left;
        color: #0B232A;
    }

    .primeiro-plano {
        display: flex;
        flex-direction: column;
        background-color: #0B232A;
        border-radius: 15px;
    }

    .fundo {
        display: flex;
        flex-direction: column;
        margin: 10px;
        height: 98vh;
        max-width: 500px;
    }

    .botao-captura {
        padding: 10px 20px;
        background-color: #007bff;
        border: none;
        border-top: 2px solid #ffffffc2;
        border-radius: 25px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        outline: none;
        width: 100%;
        height: 80px !important;
    }

    .botao-digitar {
        padding: 10px 20px;
        background-color: #99CEE4;
        border: none;
        border-top: 2px solid #ffffffc2;
        border-radius: 25px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        outline: none;
        width: 100%;
        height: 40px !important;
        margin-top: 5px;
    }

    .div-quantidade {
        margin-top: auto;
        border-top: 1px solid #3E5F79;
        border-radius: 10px;
        margin: 5px;
    }

    .footer {
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .titulo {
        margin-top: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
        font-size: small;
        font-weight: 600;
    }

    .video {
        border: 2px dashed orange;
        height: 200px;
        margin: 5px;
        border-radius: 10px;
    }

    video {
        height: 200px;
        border-radius: 10px;
    }

    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
    }

    .action-button {
        width: 45px;
        height: 45px;
        background-color: #0B232A;
        border: 1px solid #99CEE4;
        border-radius: 100%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qtd-button {
        width: 50px;
        height: 50px;
        background-color: #0B232A;
        border: 1px solid #3E5F79;
        border-radius: 20%;
        cursor: pointer;
        color: #3E5F79;
        font-size: x-large;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qtd-button:active {
        background-color: #21414b;
        transform: scale(0.98);
        border: 1px solid orange;
    }

    .qtd-button .fas {
        font-size: 1.2em;
        color: #3E5F79;
        font-size: large;
    }

    .action-text {
        flex-grow: 1;
        text-align: center;
        margin-left: 50px;
        margin-right: 5px;
    }

    .fas {
        font-size: 1.2em;
        color: #99CEE4;
    }

    .progress-bar {
        border: 1px solid #99CEE4;
        height: 10px;
        border-radius: 10px;
        margin: 0px 10px;
    }

    .progress-fill {
        background-color: white;
        height: 8px;
        border-radius: 8px;
        margin: 1px;
        width: 0;
    }

    .grow {
        width: 99%;
    }

    .tabela-ean {
        background-color: #0B232A;
        border-radius: 15px;
        flex-grow: 1;
        overflow-y: auto;
        width: 100%;
        overflow-x: auto;
        padding: 5%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        padding: 5px;
        text-align: center;
        border-top: 1px solid #99CEE4;
        border-bottom: 1px solid #99CEE4;
    }

    tr:first-child td {
        border-top: none;
    }

    tr:last-child td {
        border-bottom: none;
    }

    .qtd-text {
        display: flex;
        align-items: center;
        text-align: center;
        justify-content: center;
        width: 25%;
        height: 50px;
        background-color: white;
        border: 1px solid #3E5F79;
        border-radius: 50px;
        cursor: pointer;
        color: #0B232A;
        font-size: x-large;
        font-weight: 700;
    }

    #barcode-scanner {
        width: 100%;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    #barcode-scanner video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .scan-on {
        background-color: #FEBC6C;
    }

    .scan-off {
        background-color: #247AAA;
    }

    .button-voltar {
        text-decoration: none;
        color: white;
        border: solid white 1px;
        padding: 5px;
        border-radius: 5px;
    }

    .vermelhoDelete {
        color: #ff6775;
        border: solid #ff6775 2px;
        background-color: #3d1f1f;
    }

    .vermelhoDelete .fas {
        color: #ff6775;
    }
</style>

<div class="fundo">
    <div class="titulo">
        <a href="<?php echo URL_BASE . 'Inventario_item/index/' . $inventario ?>" class="button-voltar">
            VOLTAR
        </a>
        COLETOR DE DADOS
        <a href="<?php echo URL_BASE ?>">
            <img src="<?PHP echo URL_BASE . 'logoApp.png' ?>" width="30px" alt="">
        </a>
    </div>
    <div>
        estoque 1 / rua 1 / coluna 1
    </div>
    <div class="primeiro-plano">
        <div class="video">
            <div id="barcode-scanner">
            </div>
        </div>
        <div class="box-aprova">
            <div class="action-bar">

                <span id="codigo-lido" class="action-text"></span>
                <button class="action-button" id="cancel-button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="progress-bar">
                <div class="progress-fill">
                </div>
            </div>
        </div>

        <div class="div-quantidade">
            <div class="action-bar">
                <button id="btn-10" class="qtd-button">
                    10
                </button>
                <button id="btn-1" class="qtd-button">
                    1
                </button>
                <input id="quantidade" class="qtd-text" type="number" value="1">
                <button id="btn-menos" class="qtd-button">
                    <i class="fas fa-minus"></i>
                </button>
                <button id="btn-mais" class="qtd-button">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="footer">
        <button id="scan-button" class="botao-captura scan-off">ESCANEAR</button>
    </div>
    <div class="tabela-ean">
        <table id="most-frequent-code">
        </table>
    </div>
    <div>
        <button type="button" class="btn botao-digitar" data-toggle="modal" data-target="#modalProduto">
            DIGITAR CODIGO
        </button>
    </div>
</div>

<div class="modal fade" id="modalProduto" tabindex="-1" aria-labelledby="modalProdutoLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProdutoLabel">Detalhes do Produto</h5>
                <button type="button" class="btn btn-sm btn-outline-info close" data-dismiss="modal"
                    aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="ean13">EAN13:</label>
                        <input type="number" class="form-control" id="ean13">
                        <div id="eanError" class="alert alert-danger mt-2" style="display: none;">EAN inválido.</div>
                    </div>
                    <div class="form-group">
                        <label for="quantidadeManual">Quantidade:</label>
                        <input type="number" class="form-control" id="quantidadeManual">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-sm btn-outline-primary" id="btnConfirmar">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>

    $('#modalProduto').on('show.bs.modal', function (e) {
        // Limpa os valores dos inputs
        $('#ean13').val('');
        $('#quantidadeManual').val('');

        // Oculta a mensagem de erro
        $('#eanError').hide();
    });
    function isValidEAN13(code) {
        if (!/^\d{13}$/.test(code)) return false; // Verifica se tem exatamente 13 dígitos

        let sum = 0;
        for (let i = 0; i < 12; i++) {
            let digit = parseInt(code[i]);
            if (i % 2 === 0) { // Posições ímpares no código (índices pares, pois começam de 0)
                sum += digit;
            } else { // Posições pares no código
                sum += digit * 3;
            }
        }
        let modulo = sum % 10;
        let checkDigit = modulo === 0 ? 0 : 10 - modulo;
        return checkDigit === parseInt(code[12]);
    }

    document.getElementById('btnConfirmar').addEventListener('click', function () {
        var ean13 = document.getElementById('ean13').value;
        var quantidade = document.getElementById('quantidadeManual').value;
        console.log("EAN13: " + ean13 + ", Quantidade: " + quantidade);
        if (isValidEAN13(ean13)) {
            sendData(ean13, quantidade)
            $('#eanError').hide();
            $('#modalProduto').modal('hide'); // Fechando o modal com jQuery
        } else {
            $('#eanError').show();
        }
    });

    let isScanning = false;
    id_inventario = <?php echo $inventario ?>;
    chave_csrf_token = '<?php echo $_SESSION['csrf_token']; ?>'
    var container = document.getElementById('most-frequent-code');
    var ultimoEnvio = { id: 0, code: '', quantity: 0 };
    var outputCodigo = document.getElementById("codigo-lido");
    var progressBar = document.querySelector('.progress-fill');
    var btnCancelar = document.getElementById("cancel-button");
    var textQuantidade = document.getElementById("quantidade");

    btnCancelar.addEventListener('click', function () {
        deletaUltimo();
    });

    function deletaUltimo() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo URL_BASE; ?>inventario_item/deleteColetor', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        var params = new URLSearchParams();
        params.append('_method', 'DELETE');
        params.append('inventario_item_id', ultimoEnvio['id']);
        params.append('csrf_token', chave_csrf_token);

        xhr.send(params);

        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log('Item deletado com sucesso');

                // Imprimir a resposta do servidor
                console.log('Resposta do servidor:', xhr.responseText);

                // Se a resposta for JSON, você pode converter e usar assim:
                try {
                    var resposta = JSON.parse(xhr.responseText);
                    console.log('Resposta do servidor como objeto:', resposta);
                    subLine(ultimoEnvio['code'], ultimoEnvio['quantity'])
                    ultimoEnvio = { id: 0, code: '', quantity: 0 }
                    btnCancelar.classList.remove('vermelhoDelete');
                    // Agora você pode acessar as propriedades do objeto, por exemplo: resposta.mensagem
                } catch (e) {
                    console.error('Erro ao analisar a resposta do servidor como JSON:', e);
                }

                // Aqui você pode adicionar o código para atualizar a UI conforme necessário
            } else {
                console.error('Falha ao deletar o item');
                // Também pode ser útil imprimir a resposta de erro do servidor
                console.error('Erro do servidor:', xhr.responseText);
            }
        };

        xhr.onerror = function () {
            console.error('Erro na rede');
        };
    }

    document.getElementById('scan-button').addEventListener('click', function () {
        if (!isScanning) {
            this.classList.remove('scan-off');
            this.classList.add('scan-on');
            this.textContent = 'ESCANEAMENTO';
            progressBar.style.transition = 'none';
            progressBar.classList.remove('grow');
            isScanning = true;
        } else {
            this.classList.remove('scan-on');
            this.classList.add('scan-off');
            this.textContent = 'ESCANEAR';
            isScanning = false;
        }

    });

    var codeQuantities = <?php echo json_encode($identidades); ?>;
    for (var i = 0; i < codeQuantities.length; i++) {
        var item = codeQuantities[i];
        var newLine = document.createElement('tr');

        var eanCell = document.createElement('td');
        eanCell.textContent = item.code;
        newLine.appendChild(eanCell);

        var quantidadeCell = document.createElement('td');
        quantidadeCell.textContent = item.quantity;
        newLine.appendChild(quantidadeCell);

        container.appendChild(newLine);
    }

    document.getElementById("btn-mais").addEventListener('click', function () {
        textQuantidade.value = parseInt(textQuantidade.value) + 1;
    })
    document.getElementById("btn-menos").addEventListener('click', function () {
        if (parseInt(textQuantidade.value) > 1) {
            textQuantidade.value = parseInt(textQuantidade.value) - 1;
        }
    })
    document.getElementById("btn-1").addEventListener('click', function () {
        textQuantidade.value = 1;
    })
    document.getElementById("btn-10").addEventListener('click', function () {
        textQuantidade.value = 10;
    })

    function sendData(ean13, qtd) {
        const formData = new URLSearchParams();
        formData.append('inventario_id', id_inventario);
        formData.append('ean13', ean13);
        formData.append('csrf_token', chave_csrf_token);
        formData.append('quantidade', qtd);

        fetch('<?php echo URL_BASE; ?>inventario_item/saveEan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Falha no envio');
                }
                return response.json();
            })
            .then(data => {
                console.log('Dados enviados com sucesso:', data);
                ultimoEnvio['id'] = data['inventario_item_id']
                btnCancelar.classList.add('vermelhoDelete');
                // Tente reenviar qualquer dado salvo localmente
                resendSavedData();
            })
            .catch(error => {
                console.error('Erro:', error);
                // Salvar localmente para reenvio posterior
                saveDataLocally(id_inventario, ean13, qtd);
            });
    }



    function resendSavedData() {
        // Recupera os dados salvos
        let savedData = localStorage.getItem('savedData');
        if (!savedData) return;

        savedData = JSON.parse(savedData);

        // Função auxiliar para enviar dados
        function sendSavedData(inventarioId, ean13, qtd) {
            const formData = new URLSearchParams();
            formData.append('inventario_id', inventarioId);
            formData.append('ean13', ean13);
            formData.append('csrf_token', chave_csrf_token);
            formData.append('quantidade', qtd);

            return fetch('<?php echo URL_BASE; ?>inventario_item/saveEan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: formData
            });
        }

        // Cria uma cópia para iterar e modifica o array original
        [...savedData].reverse().forEach((item, index) => {
            sendSavedData(item.inventarioId, item.ean13, item.qtd)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Falha no reenvio');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Reenvio bem-sucedido:', data);
                    // Remove o item enviado do array original                        
                    savedData.splice(savedData.length - 1 - index, 1);
                })
                .catch(error => {
                    console.error('Erro no reenvio:', error);
                    // Não é necessário salvar novamente, pois já está salvo
                })
                .finally(() => {
                    // Atualiza o armazenamento local após processar cada item
                    localStorage.setItem('savedData', JSON.stringify(savedData));
                });
        });
    }


    function saveDataLocally(inventarioId, ean13, qtd) {
        // Recupera os dados salvos ou inicializa um array vazio
        let savedData = localStorage.getItem('savedData') || '[]';
        savedData = JSON.parse(savedData);

        // Cria um objeto com inventario_id e ean13 e adiciona ao array
        savedData.push({ inventarioId, ean13, qtd });
        // Salva o array atualizado no localStorage
        localStorage.setItem('savedData', JSON.stringify(savedData));
    }


    // Função para gerar um bipe
    function beep(frequency = 520, duration = 200) {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        let oscillator = audioContext.createOscillator();
        let gainNode = audioContext.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        oscillator.frequency.value = frequency;

        oscillator.start();
        setTimeout(() => {
            oscillator.stop();
            audioContext.close();
        }, duration);
    }

    let scannedCodes = [];
    const maxReadings = 5;

    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#barcode-scanner'),
            constraints: {
                facingMode: "environment",
                //width: { ideal: 900 },  // Sugere a largura ideal
                //height: { ideal: 900 } // Sugere a altura ideal
            },
        },
        decoder: {
            readers: ["ean_reader"]
        },
    }, function (err) {
        if (err) {
            console.log(err);
            return
        }
        console.log("Initialization finished. Ready to start");
        Quagga.start();
    });

    Quagga.onDetected(function (result) {
        var code = result.codeResult.code;
        if (isScanning) {
            if (scannedCodes.length < maxReadings) {
                scannedCodes.push(code);

                if (scannedCodes.length === maxReadings) {   
                    var maisFrequente = calculaMaisFrequente(scannedCodes)   
                    console.log(scannedCodes)         
                    if(isValidEAN13(maisFrequente)){
                        displayCodeErro(maisFrequente)
                    }else{                        
                        displayMostFrequentCode(maisFrequente);
                        beep(); // Toca um bipe   
                        sendData(maisFrequente, textQuantidade.value);
                    }                    
                    
                    scannedCodes = [];
                    let scanButton = document.getElementById('scan-button');
                    scanButton.classList.remove('scan-on');
                    scanButton.classList.add('scan-off');
                    scanButton.textContent = 'ESCANEAR';
                    isScanning = false;
                }
            }
        }
    });

    function calculaMaisFrequente(codes){
        const counts = codes.reduce((acc, code) => {
            acc[code] = (acc[code] || 0) + 1;
            return acc;
        }, {});

        return Object.keys(counts).reduce((a, b) => counts[a] > counts[b] ? a : b);
        
    }

    function displayCodeErro(code) {
        outputCodigo.textContent = code;  
        outputCodigo.classList.add('vermelhoDelete');  
    }

    function displayMostFrequentCode(code) {        
        outputCodigo.classList.remove('vermelhoDelete');
        addLine(code, textQuantidade.value)
        outputCodigo.textContent = code;

        ultimoEnvio['code'] = code;
        ultimoEnvio['quantity'] = textQuantidade.value;

        progressBar.style.transition = 'width 3s ease-in-out'; // Remove a animação
        progressBar.classList.add('grow');
    }

    function subLine(code, qtd) {
        for (var i = 0; i < codeQuantities.length; i++) {
            if (codeQuantities[i].code === code) {
                codeQuantities[i].quantity = parseInt(codeQuantities[i].quantity) - parseInt(qtd);
                break;
            }
        }
        renderTable()
    }

    function addLine(mostFrequentCode, qtd) {

        var found = false;
        for (var i = 0; i < codeQuantities.length; i++) {
            if (codeQuantities[i].code === mostFrequentCode) {
                codeQuantities[i].quantity = parseInt(codeQuantities[i].quantity) + parseInt(qtd);
                // Mover o item atualizado para o topo
                var item = codeQuantities.splice(i, 1)[0];
                codeQuantities.unshift(item);
                found = true;
                break;
            }
        }

        // Se o código é novo, adiciona no início do array
        if (!found) {
            codeQuantities.unshift({ code: mostFrequentCode, quantity: parseInt(qtd) });
        }

        // Renderiza a tabela
        renderTable();
    }


    function renderTable() {
        var container = document.getElementById('most-frequent-code');
        container.innerHTML = '';

        for (var i = 0; i < codeQuantities.length && i < 20; i++) {
            var item = codeQuantities[i];
            var newLine = document.createElement('tr');

            var eanCell = document.createElement('td');
            eanCell.textContent = item.code;
            newLine.appendChild(eanCell);

            var quantidadeCell = document.createElement('td');
            quantidadeCell.textContent = item.quantity;
            newLine.appendChild(quantidadeCell);

            container.appendChild(newLine);
        }
    }


</script>