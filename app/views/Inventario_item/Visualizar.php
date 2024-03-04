<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1 text-center">Visualizar iventário</h1>
            <a href="<?php echo URL_BASE . "Inventario" ?>"
                class="btn btn-sm btn-outline-info m-1 col-12 col-md-auto">Voltar para inventarios</a>
            <hr>
            <?php if ($agrupado == 0) { ?>
                <a href="<?php echo URL_BASE . "Inventario_item/visualizarAgrupado/" . $inventario->inventario_id ?>"
                    class="btn btn-sm btn-outline-info m-1 col-12 col-md-auto">Visualizar Agrupado</a>
            <?php } else if ($agrupado == 1) { ?>
                    <a href="<?php echo URL_BASE . "Inventario_item/visualizar/" . $inventario->inventario_id ?>"
                        class="btn btn-sm btn-outline-info m-1 col-12 col-md-auto">Visualizar individual</a>
            <?php } ?>
            <button class="btn btn-sm btn-outline-primary m-1 col-12 col-md-auto"
                onclick="exportarTabelaParaCSV('<?php echo $inventario->nome ?>.csv')">Exportar para CSV</button>

            <button class="btn btn-sm btn-outline-primary m-1 col-12 col-md-auto"
                onclick="exportarTabelaParaTXT('<?php echo $inventario->nome ?>.txt')">Exportar para TXT</button>

            <button class="btn btn-sm btn-outline-primary m-1 col-12 col-md-auto"
                onclick="exportarDadosParaTXT('<?php echo $inventario->nome ?>Eans.txt')">Exportar para TXT EANs
                individuais</button>

            <button class="btn btn-sm btn-outline-primary m-1 col-12 col-md-auto"
                onclick="exportarDadosParaCSV('<?php echo $inventario->nome ?>Eans.csv')">Exportar para CSV
                EANs</button>

            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>EAN-13</th>
                        <th>Qtd.</th>
                        <?php if ($agrupado == 0) { ?>
                            <th>Rua</th>
                            <th>Coluna</th>
                            <th>Nível</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventario_item as $item) { ?>
                        <tr>
                            <?php if ($agrupado == 0) { ?>
                                <td>
                                    <?php echo $item->ean13; ?>
                                </td>
                                <td>
                                    <?php echo $item->quantidade; ?>
                                </td>
                                <td>
                                    <?php echo $item->rua; ?>
                                </td>
                                <td>
                                    <?php echo $item->coluna; ?>
                                </td>
                                <td>
                                    <?php echo $item->nivel; ?>
                                </td>
                            <?php } else if ($agrupado == 1) { ?>
                                    <td>
                                    <?php echo $item->code; ?>
                                    </td>
                                    <td>
                                    <?php echo $item->quantity; ?>
                                    </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script>
    $(document).ready(function () {
        var table = new DataTable('table.display', {
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "order": [
                [1, 'desc']
            ],
            "pageLength": 25,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

    function exportarTabelaParaCSV(nomeDoArquivo) {
        var tabela = document.getElementById("tabela").getElementsByTagName("tbody")[0];
        var linhas = tabela.getElementsByTagName("tr");
        var csv = [];
        for (var i = 0; i < linhas.length; i++) {
            var colunas = linhas[i].querySelectorAll("td, th");
            var arr = [];

            for (var j = 0; j < colunas.length; j++) {
                var dado = colunas[j].innerText.replace(/(\r\n|\n|\r)/gm, "").trim();
                arr.push(dado);
            }
            csv.push(arr.join(","));
        }
        var csvString = csv.join("\n");
        var link = document.createElement("a");
        link.setAttribute("href", "data:text/csv;charset=utf-8," + encodeURIComponent(csvString));
        link.setAttribute("download", nomeDoArquivo);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function exportarTabelaParaTXT(nomeDoArquivo) {
        var tabela = document.getElementById("tabela").getElementsByTagName("tbody")[0];
        var linhas = tabela.getElementsByTagName("tr");
        var txt = [];
        for (var i = 0; i < linhas.length; i++) {
            var colunas = linhas[i].querySelectorAll("td, th");
            var arr = [];

            for (var j = 0; j < colunas.length; j++) {
                var dado = colunas[j].innerText.replace(/(\r\n|\n|\r)/gm, "").trim();
                arr.push(dado);
            }
            txt.push(arr.join("\t"));
        }
        var txtString = txt.join("\n");
        var link = document.createElement("a");
        link.setAttribute("href", "data:text/plain;charset=utf-8," + encodeURIComponent(txtString));
        link.setAttribute("download", nomeDoArquivo);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function exportarDadosParaTXT(nomeDoArquivo) {
        var linhas = document.getElementById("tabela").getElementsByTagName("tbody")[0].rows;
        var conteudoTXT = "";
        for (var i = 0; i < linhas.length; i++) {
            var codigoEAN = linhas[i].cells[0].innerText.trim();
            var quantidade = parseInt(linhas[i].cells[1].innerText.trim(), 10);
            for (var q = 0; q < quantidade; q++) {
                conteudoTXT += codigoEAN + "\n"; // Adiciona o código EAN e uma quebra de linha
            }
        }
        var elemento = document.createElement('a');
        elemento.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(conteudoTXT));
        elemento.setAttribute('download', nomeDoArquivo);
        elemento.style.display = 'none';
        document.body.appendChild(elemento);
        elemento.click(); // Iniciar o download
        document.body.removeChild(elemento); // Remover o elemento após o download
    }

    function exportarDadosParaCSV(nomeDoArquivo) {
        var linhas = document.getElementById("tabela").getElementsByTagName("tbody")[0].rows;
        var conteudoCSV = ""; // Cabeçalho da coluna CSV
        for (var i = 0; i < linhas.length; i++) {
            var codigoEAN = linhas[i].cells[0].innerText.trim();
            var quantidade = parseInt(linhas[i].cells[1].innerText.trim(), 10);
            for (var q = 0; q < quantidade; q++) {
                conteudoCSV += codigoEAN + "\n"; // Adiciona o código EAN e uma quebra de linha
            }
        }
        var elemento = document.createElement('a');
        elemento.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(conteudoCSV));
        elemento.setAttribute('download', nomeDoArquivo);
        elemento.style.display = 'none';
        document.body.appendChild(elemento);
        elemento.click(); // Iniciar o download
        document.body.removeChild(elemento); // Remover o elemento após o download
    }

</script>