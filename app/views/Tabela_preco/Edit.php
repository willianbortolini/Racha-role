<style>
    input[type="number"] {
        width: 80px;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
<h1>
    <?php echo (isset($tabela_preco->tabela_preco_id)) ? 'Editar tabela de preço' : 'Adicionar tabela de preço'; ?>
</h1>

<form action="<?php echo URL_BASE . "Tabela_preco/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="tabela_preco_nome">Nome</label>
        <input type="text" class="form-control" id="tabela_preco_nome" name="tabela_preco_nome"
            value="<?php echo (isset($tabela_preco->tabela_preco_nome)) ? $tabela_preco->tabela_preco_nome : ''; ?>"
            required>
        <div class="row mt-2">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Salvar tabela de preço</button>
            </div>
            <div class="col-auto">
                <a href="<?php echo URL_BASE . "Tabela_preco" ?>" class="btn btn-primary">Voltar</a>
            </div>
        </div>
    </div>

    <h3>Inportar .csv da tabela de preço</h3>
    <input type="hidden" name="tabela_preco_id"
        value="<?php echo (isset($tabela_preco->tabela_preco_id)) ? $tabela_preco->tabela_preco_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <div class="form-group mb-2">
        <input type="file" class="btn" id="csvInput" accept=".csv" style="display: none;">
        <label for="csvInput" class="btn btn-primary">Escolher Arquivo csv</label>
    </div>
    <div class="row">
        <div class="col-auto">
            <button type="button" id="btnSalvaJson" class="btn btn-primary">Salva tabela csv</button>
        </div>
    </div>
</form>
<h3 class="mt-2">Tabela de preços</h3>
<div id="output" class="table-responsive mt-2">
    <?php
    if (isset($tabela_preco_itens)) {
        // Inicializar arrays para armazenar os valores de largura, altura e valor
        $larguras = [];
        $alturas = [];
        $valores = [];
        $id = [];
        // Preencher os arrays com os dados
        foreach ($tabela_preco_itens as $item) {
            $larguras[$item->largura] = true;
            $alturas[$item->altura] = true;
            $id[$item->largura][$item->altura] = $item->tabela_preco_item_id;
            $valores[$item->largura][$item->altura] = $item->valor;
        }

        // Obter larguras e alturas únicas
        $larguras = array_keys($larguras);
        $alturas = array_keys($alturas);

        // Iniciar a tabela HTML
        echo "<table  id='tabelaPreco' class='table table-bordered'>";
        echo '<tr><th></th>';

        // Adicionar cabeçalhos de largura
        foreach ($larguras as $largura) {
            echo '<th>' . $largura . '</th>';
        }

        echo '</tr>';

        // Adicionar linhas com alturas e valores
        foreach ($alturas as $altura) {
            echo '<tr>';
            echo '<th>' . $altura . '</th>';

            foreach ($larguras as $largura) {
                echo '<td  tabela_preco_item_id="' . $id[$largura][$altura] . '">';
                if (isset($valores[$largura][$altura])) {
                    echo $valores[$largura][$altura];
                }
                echo '</td>';
            }

            echo '</tr>';
        }

        echo '</table>';
    }
    ?>
</div>




<script>

    document.getElementById("tabelaPreco").addEventListener("click", function (e) {
        if (e.target.tagName === "TD") {
            editTableCell(e.target);
        }
    });

    function editTableCell(cell) {
        const oldValue = cell.textContent.trim();
        const input = document.createElement("input");
        input.type = "number";
        input.step = "0.01";
        input.value = oldValue;
        input.addEventListener("blur", function () {
            saveTableCell(cell, oldValue, input.value);
        });
        input.addEventListener("keydown", function (e) {
            if (e.key === "Enter" || e.key === "Tab") {
                saveTableCell(cell, oldValue, input.value);
            }
        });
        input.addEventListener("focusout", function () {
            // Se o usuário sair sem salvar, volte ao valor original
            cell.innerHTML = oldValue;
        });
        cell.innerHTML = "";
        cell.appendChild(input);
        input.focus();
    }

    function saveTableCell(cell, oldValue, newValue) {
        const tabelaPrecoItemId = cell.getAttribute("tabela_preco_item_id");

        // Enviar dados via POST
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "<?php echo URL_BASE ?>Tabela_preco_item/save", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Atualizar a célula com o novo valor
                cell.innerHTML = newValue;
            }
        };
        xhr.send(`tabela_preco_item_id=${tabelaPrecoItemId}&valor=${newValue}&csrf_token=<?php echo $_SESSION['csrf_token']; ?>`);


    }

    document.getElementById('csvInput').addEventListener('change', handleFile);
    const btnSalvaJson = document.getElementById('btnSalvaJson');
    btnSalvaJson.addEventListener('click', salvaJson);

    let jsonTabela

    function salvaJson() {
        const urlDoServidor = "<?php echo URL_BASE . '/Tabela_preco_item/saveJson/' . $tabela_preco->tabela_preco_id ?>";
        fetch(urlDoServidor, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: jsonTabela,
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro na requisição: ${response.status}`);
                }

                // Log antes de chamar response.json()
                //console.log(response.text());

                return response.json();
            })
            .then(data => {
                // Lida com a resposta do servidor, se necessário
                console.log(data);
            })
            .catch(error => {
                console.error('Erro durante a requisição:', error);
            });

    }

    function handleFile(event) {
        const file = event.target.files[0];

        if (file) {
            Papa.parse(file, {
                complete: function (results) {
                    const jsonData = parseCSV(results.data);

                    // Exibir o JSON resultante
                    const outputDiv = document.getElementById('output');
                    outputDiv.innerHTML = jsonData;
                }
            });
        }
    }

    function parseCSV(data) {
        const jsonData = [];
        const headers = data[0];

        let table = "<table class='table table-bordered'>";

        for (let i = 0; i < data.length; i++) {


            table += '<tr>';
            const row = data[i];
            const rowData = {};

            for (let j = 0; j < headers.length && j < row.length; j++) {
                const width = parseInt(headers[j]);
                const height = parseInt(row[0].trim());
                const value = parseFloat(row[j].replace(',', '.').replace('R$', ''))

                if (value > 0) {
                    table += '<td>' + value + '</td>';
                } else {
                    table += '<td></td>';
                }
                if (j > 0 && i > 0) {
                    rowData['largura'] = width;
                    rowData['altura'] = height;
                    rowData['valor'] = value;

                    jsonData.push({
                        ...rowData
                    });
                }
            }

            table += '</tr>';
        }

        table += '</table>';
        jsonTabela = JSON.stringify(jsonData); //jsonData;
        return table;
    }
</script>