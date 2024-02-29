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

    .primeiro-plano {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        background-color: #0B232A;

        border-radius: 15px;
    }

    .fundo {
        display: flex;
        flex-direction: column;
        height: 100%;
        margin: 10px;
        max-width: 500px;
    }

    .botao-captura {
        padding: 10px 20px;
        background-color: #007bff;
        border: none;
        border-top: 2px solid #ffffffc2;
        border-radius: 50px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        outline: none;
        width: 100%;
        height: 65px !important;
    }

    .div-quantidade {
        margin-top: auto;
        border-top: 2px solid #3E5F79;
        border-radius: 10px;
        margin: 5px;
    }

    .footer {
        height: 75px;
        margin-top: 5px;
        margin-bottom: 15px;
    }



    .titulo {
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
        border: 2px solid #99CEE4;
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
        border: 2px solid #3E5F79;
        border-radius: 20%;
        cursor: pointer;
        color: #3E5F79;
        font-size: x-large;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qtd-button .fas {
        font-size: 1.2em;
        color: #3E5F79;
        font-size: large;
    }

    .action-text {
        flex-grow: 1;
        text-align: center;
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
        width: 98%;
    }

    .tabela-ean {
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
        border: 2px solid #3E5F79;
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
</style>

<div class="fundo">
    <div class="titulo">
        COLETOR DE DADOS
    </div>
    <div class="primeiro-plano">
        <div class="video">
            <div id="barcode-scanner">
                <div id="flash-overlay"></div> <!-- Overlay para piscar -->
            </div>
        </div>
        <div class="box-aprova">
            <div class="action-bar">                
                <button class="action-button" id="validate-button">
                    <i class="fas fa-check"></i> <!-- Ícone de validar -->
                </button>
                <span id="codigo-lido" class="action-text"></span>
                <button class="action-button" id="cancel-button">
                    <i class="fas fa-times"></i> <!-- Ícone de X -->
                </button>
            </div>
            <div class="progress-bar">
                <div class="progress-fill">
                </div>
            </div>
        </div>
        <div class="tabela-ean">
            <table id="most-frequent-code">
                
            </table>
        </div>
        <div class="div-quantidade">

            <div class="action-bar">                
                <button class="qtd-button">
                    6
                </button>
                <button class="qtd-button">
                    1
                </button>
                <input class="qtd-text" type="number" value="1">
                <button class="qtd-button">
                    <i class="fas fa-minus"></i>
                </button>
                <button class="qtd-button">
                    <i class="fas fa-plus"></i>
                </button>                
            </div>
        </div>
    </div>
    <div class="footer">
        <button id="scan-button" class="botao-captura scan-off">ESCANEAR</button>
    </div>
</div>



<script>

    let isScanning = false;

    document.getElementById('scan-button').addEventListener('click', function () {
        this.classList.remove('scan-off');
        this.classList.add('scan-on');
        this.textContent = 'ESCANEAMENTO';

        progressBar.style.transition = 'none';
        progressBar.classList.remove('grow');

        isScanning = true;
    });

    var outputCodigo = document.getElementById("codigo-lido");
    var progressBar = document.querySelector('.progress-fill');


    document.addEventListener('DOMContentLoaded', function () {

        function sendData(ean13) {
            const formData = new URLSearchParams();
            formData.append('inventario_id', '<?php echo $inventario ?>');
            formData.append('ean13', ean13);
            formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');

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
                    // Tente reenviar qualquer dado salvo localmente
                    resendSavedData();
                })
                .catch(error => {
                    console.error('Erro:', error);
                    // Salvar localmente para reenvio posterior
                    saveDataLocally('<?php echo $inventario ?>', ean13);
                });
        }

        function resendSavedData() {
            // Recupera os dados salvos
            let savedData = localStorage.getItem('savedData');
            if (!savedData) return;

            savedData = JSON.parse(savedData);

            // Função auxiliar para enviar dados
            function sendSavedData(inventarioId, ean13) {
                const formData = new URLSearchParams();
                formData.append('inventario_id', inventarioId);
                formData.append('ean13', ean13);
                formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');

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
                sendSavedData(item.inventarioId, item.ean13)
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


        function saveDataLocally(inventarioId, ean13) {
            // Recupera os dados salvos ou inicializa um array vazio
            let savedData = localStorage.getItem('savedData') || '[]';
            savedData = JSON.parse(savedData);

            // Cria um objeto com inventario_id e ean13 e adiciona ao array
            savedData.push({ inventarioId, ean13 });
            console.log(savedData);
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
        const maxReadings = 4;

        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#barcode-scanner'),
                constraints: {
                    facingMode: "environment",
                    width: { ideal: 900 },  // Sugere a largura ideal
                    height: { ideal: 900 } // Sugere a altura ideal
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
                        displayMostFrequentCode(scannedCodes);
                        sendData(scannedCodes);
                        scannedCodes = [];
                        let scanButton = document.getElementById('scan-button');
                        scanButton.classList.remove('scan-on');
                        scanButton.classList.add('scan-off');
                        scanButton.textContent = 'ESCANEAR';
                        isScanning = false;
                        beep(); // Toca um bipe   

                    }
                }
            }
        });

        function displayMostFrequentCode(codes) {
            const counts = codes.reduce((acc, code) => {
                acc[code] = (acc[code] || 0) + 1;
                return acc;
            }, {});

            const mostFrequentCode = Object.keys(counts).reduce((a, b) => counts[a] > counts[b] ? a : b);
            addLine(mostFrequentCode)
            outputCodigo.textContent = mostFrequentCode;
            // Adicione o efeito de piscar aqui
            progressBar.style.transition = 'width 3s ease-in-out'; // Remove a animação
            progressBar.classList.add('grow');

            flashScreen();
        }

        function addLine(mostFrequentCode) {
            var container = document.getElementById('most-frequent-code'); // Certifique-se de que isto é o tbody da tabela
            var newLine = document.createElement('tr');

            var eanCell = document.createElement('td');
            eanCell.textContent = mostFrequentCode;
            newLine.appendChild(eanCell);

            var quantidadeCell = document.createElement('td');
            quantidadeCell.textContent = 2;
            newLine.appendChild(quantidadeCell);

            // Adiciona a nova linha no início
            container.insertBefore(newLine, container.firstChild);

            // Limita a 5 linhas
            var lines = container.children;
            if (lines.length > 6) {
                container.removeChild(lines[5]); // Remove a sexta linha (índice 5)
            }
        }
    });
    // Função para piscar a tela
    function flashScreen() {
        const flashOverlay = document.getElementById('flash-overlay');
        flashOverlay.style.display = 'block';
        setTimeout(() => {
            flashOverlay.style.display = 'none';
        }, 100); // Duração do piscar em milissegundos
    }
</script>