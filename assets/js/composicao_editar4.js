//quando seleciona algo 
var selectElement = document.getElementById("composicao_tipo_id");
//quando seleciona algo 
if (selectElement != null) {
    var selectElement = document.getElementById("composicao_tipo_id");
    selectElement.addEventListener("change", function () {
        validaTipo()
    });


    function validaTipo() {
        var selecionado = selectElement.value;
        if (selecionado == COMPOSICAO_LIGACAO) {
            document.getElementById('composicao_formula').value = '';
            document.getElementById('composicao_formula').parentNode.classList.add("hidden")
            document.getElementById('composicao_padrao_id').parentNode.classList.remove("hidden")
        } else {
            document.getElementById('composicao_formula').parentNode.classList.remove("hidden")
            document.getElementById('composicao_padrao_id').parentNode.classList.add("hidden")
            document.getElementById('composicao_padrao_id').value = 0;
        }
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

        if (tipo == COMPOSICAO_LIGACAO) {
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

    function destacarElemento(event) {

        event.stopPropagation();
        elementosClicaveis.forEach(function (elemento) {
            elemento.classList.remove('destacado');
        });
        var idSemPrefixo = this.id.replace(/composicao_/g, "");

        if ((this.tagName.toLowerCase() == 'select')) {
            if (this.value > 0) {
                atualizaEdit(this.value)
            } else {
                atualizaEdit(idSemPrefixo)
            }
        } else {
            atualizaEdit(idSemPrefixo)
        }

        this.classList.add('destacado');
        document.getElementById('editCard').classList.remove('hidden');

    }

    function atualizaEdit(composicao_id) {

        var compisicao_item = composicao.filter(item => item.composicao_id == composicao_id);
        //se é uma composição padrão
        if (compisicao_item[0].composicao_pai_id == '-1') {
            compisicao_item = composicao.filter(item => item.composicao_padrao_id == composicao_id);
        }

        document.getElementById("btnCriaFilho").href = URL_BASE + "Composicao/create/" + compisicao_item[0].produtos_id + "/" + compisicao_item[0].composicao_id
        document.getElementById("composicao_pai_id").value = compisicao_item[0].composicao_pai_id
        document.getElementById("produtos_id").value = compisicao_item[0].produtos_id
        document.getElementById('composicao_nome').value = compisicao_item[0].composicao_nome
        document.getElementById('composicao_ordem').value = compisicao_item[0].composicao_ordem
        document.getElementById("composicao_id").value = compisicao_item[0].composicao_id        
        document.getElementById('editDeletar').setAttribute('id_linha', composicao_id);
        console.log(document.getElementById('editDeletar'));
        if (compisicao_item[0].composicao_obrigatoria == 1) {
            document.getElementById('composicao_obrigatoria').checked = true;
        } else {
            document.getElementById('composicao_obrigatoria').checked = false;
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

        validaTipo()

    }

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
    }

    var elementosClicaveis = document.querySelectorAll('[id^="composicao_"]');

    function carregaInputsCriados() {
        elementosClicaveis = document.querySelectorAll('[id^="composicao_"]');
        var elementosNumericos = [];

        elementosClicaveis.forEach(function (elemento) {
            var id = elemento.id;
            if (/^composicao_\d+$/.test(id)) {
                elementosNumericos.push(elemento);
            }
        });
        elementosClicaveis = elementosNumericos
        // Atribuir o evento de clique a cada elemento
        elementosClicaveis.forEach(function (elemento) {
            elemento.addEventListener('click', destacarElemento);

        });
    }
}