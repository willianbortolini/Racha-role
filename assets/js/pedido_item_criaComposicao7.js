//constantes
const COMPOSICAO_CHECKBOX = 1;
const COMPOSICAO_MEDIDA = 2;
const COMPOSICAO_SELECIONAR = 3;
const COMPOSICAO_ITEM_SELECIONAR = 4;
const COMPOSICAO_CATEGORIA = 5;
const COMPOSICAO_QUANTIDADE = 6;
const COMPOSICAO_OCULTA = 7;
const COMPOSICAO_LIGACAO = 8;
const COMPOSICAO_TEXTO_CURTO = 9;

function criaInput(composicao, data) {
    if (composicao.composicao_tipo_id == COMPOSICAO_CHECKBOX) {
        return (criaCheckbox(composicao, data));
    }
    if (composicao.composicao_tipo_id == COMPOSICAO_SELECIONAR) {
        return (criaSelect(composicao, data));
    }
    if (composicao.composicao_tipo_id == COMPOSICAO_CATEGORIA) {
        return (criaCard(composicao, data));
    }
    if (composicao.composicao_tipo_id == COMPOSICAO_MEDIDA) {
        return (criaMedida(composicao, data));
    }
    if (composicao.composicao_tipo_id == COMPOSICAO_QUANTIDADE) {
        return (criaQuantidade(composicao, data));
    }
    if (composicao.composicao_tipo_id == COMPOSICAO_OCULTA) {
        return (criaOculta(composicao, data));
    }
    if (composicao.composicao_tipo_id == COMPOSICAO_LIGACAO) {
        const composicao_padrao = data.filter(item => item.composicao_id == composicao.composicao_padrao_id);
        composicao_padrao[0].composicao_nome = composicao.composicao_nome
        composicao_padrao[0].composicao_pai_id = composicao.composicao_pai_id
        return criaInput(composicao_padrao[0], data)
    }
    if (composicao.composicao_tipo_id == COMPOSICAO_TEXTO_CURTO) {
        return (criaTexto(composicao, data));
    }
}



function criaTexto(composicao, data) {
    const inputCriado = document.createElement('input');
    inputCriado.type = 'text';
    inputCriado.id = `composicao_${composicao.composicao_id}`;
    inputCriado.name = `composicao_${composicao.composicao_id}`;
    inputCriado.className = 'form-control';
    inputCriado.setAttribute('composicao_pai', 'composicao_' + composicao.composicao_pai_id);
    inputCriado.setAttribute('tipo', composicao.composicao_tipo_id);
    inputCriado.setAttribute('valorMonetario', 0);
    if (composicao.composicao_obrigatoria == 1) {
        inputCriado.setAttribute('required', '');
    }
    var valorComposicaoSalva = buscaTextoComposicaoSalva(composicao.composicao_id)
    if (valorComposicaoSalva != '') {
        inputCriado.value = valorComposicaoSalva;
    }
    const label = document.createElement('label');
    label.htmlFor = `composicao_${composicao.composicao_id}`;
    label.textContent = `${composicao.composicao_nome}: `;
    const inputDiv = document.createElement('div');
    inputDiv.className = 'input form-group mb-2 col-12';

    inputDiv.appendChild(label);
    //se tem o botão de ajuda 
    if ((composicao.ajuda_texto != '') || (composicao.ajuda_imagem != '')) {
        const inputGroupDiv = document.createElement('div');
        inputGroupDiv.className = 'input-group';

        const helpButton = document.createElement('div');
        helpButton.className = 'input-group-append';
        helpButton.onclick = function () { ajuda(this, composicao.composicao_id); };
        const helpIcon = document.createElement('span');
        helpIcon.className = 'input-group-text';
        helpIcon.textContent = '?';
        helpButton.appendChild(helpIcon);

        inputGroupDiv.appendChild(inputCriado);
        inputGroupDiv.appendChild(helpButton);

        inputDiv.appendChild(inputGroupDiv);
    } else {
        inputDiv.appendChild(inputCriado);
    }

    return inputDiv;
}

function criaOculta(composicao, data) {
    const oculta = document.createElement('input');
    oculta.setAttribute('tipo', composicao.composicao_tipo_id);
    oculta.type = 'hidden';
    oculta.id = `composicao_${composicao.composicao_id}`;
    oculta.name = `composicao_${composicao.composicao_id}`;
    oculta.setAttribute('valorMonetario', 0);
    if (composicao.composicao_pai_id == 0){
        oculta.value = 1;
    }
    const ocultaDiv = document.createElement('div');   
    ocultaDiv.appendChild(oculta);
    return ocultaDiv;
}

function criaCard(composicao, data) {
    const cardDiv = document.createElement('div');
    cardDiv.setAttribute('tipo', composicao.composicao_tipo_id);
    cardDiv.className = 'card m-2';
    cardDiv.id = `composicao_${composicao.composicao_id}`;
    
    const cardBodyDiv = document.createElement('div');
    cardBodyDiv.className = 'card-body row';
    cardBodyDiv.setAttribute('composicao_pai', 'composicao_' + composicao.composicao_pai_id);
    const cardTitle = document.createElement('h5');
    cardTitle.className = 'card-title';
    cardTitle.textContent = composicao.composicao_nome;
    cardBodyDiv.appendChild(cardTitle);
    const itensDentroCard = data.filter(item => item.composicao_pai_id == composicao.composicao_id);
    itensDentroCard.forEach(composicaoInicial => {
        cardBodyDiv.appendChild(criaInput(composicaoInicial, data))
    });
    cardDiv.appendChild(cardBodyDiv);
    return (cardDiv);
}

function criaSelect(composicaoInicial, data) {

    const formGroupDiv = document.createElement('div');
    formGroupDiv.className = 'form-group mb-2 col-md-3 col-12';

    const label = document.createElement('label');
    label.htmlFor = `composicao_${composicaoInicial.composicao_id}`;
    label.textContent = composicaoInicial.composicao_nome;

    const select = document.createElement('select');
    select.className = 'form-select';
    select.name = `composicao_${composicaoInicial.composicao_id}`;
    select.id = 'composicao_' + composicaoInicial.composicao_id;
    select.setAttribute('tipo', composicaoInicial.composicao_tipo_id);

    select.onchange = selecionarOpcao;
    select.setAttribute('composicao_pai', 'composicao_' + composicaoInicial.composicao_pai_id);
    if (composicaoInicial.composicao_obrigatoria == 1) {
        select.setAttribute('required', '');
    }
    const itensDaComposicao = data.filter(item => item.composicao_pai_id == composicaoInicial.composicao_id);
    var meuSelectContainer = document.createElement('div');
    select.appendChild(criaOpcaoVazia());

    itensDaComposicao.forEach(itenSelect => {
        const itensFilhos = data.filter(item => item.composicao_pai_id == itenSelect.composicao_id);
        itensFilhos.forEach(itenfilho => {
            var composicaoCriado = criaInput(itenfilho, data)
            var valorComposicaoSalva = buscaComposicaoSalva(itenSelect.composicao_id)
            if (valorComposicaoSalva == 0) {
                composicaoCriado.classList.add('hidden');
            }
            
            //composicaoCriado.classList.remove('col-12');
            //composicaoCriado.classList.remove('col-md-3');
            //document.getElementById('itens').appendChild(composicaoCriado);
            meuSelectContainer.appendChild(composicaoCriado);
            formGroupDiv.classList.remove('col-md-3');
        })
        if (itenSelect.composicao_tipo_id == 4) {
            select.appendChild(criaOpcaoSelect(itenSelect));
        }
    });

    formGroupDiv.appendChild(label);

    //se tem o botão de ajuda 
    if ((composicaoInicial.ajuda_texto != '') || (composicaoInicial.ajuda_imagem != '')) {
        const inputGroupDiv = document.createElement('div');
        inputGroupDiv.className = 'input-group';

        const helpButton = document.createElement('div');
        helpButton.className = 'input-group-append';
        helpButton.onclick = function () { ajuda(this, composicaoInicial.composicao_id); };
        const helpIcon = document.createElement('span');
        helpIcon.className = 'input-group-text';
        helpIcon.textContent = '?';
        helpButton.appendChild(helpIcon);

        inputGroupDiv.appendChild(select);
        inputGroupDiv.appendChild(helpButton);

        formGroupDiv.appendChild(inputGroupDiv);
    } else {
        formGroupDiv.appendChild(select);
    }

    formGroupDiv.appendChild(meuSelectContainer);
    return (formGroupDiv);
    //var novoElementoPai = document.createElement('div');
    //novoElementoPai.appendChild(formGroupDiv);
    //novoElementoPai.appendChild(meuSelectContainer);
    //return (novoElementoPai);
}

function criaOpcaoSelect(itenSelect) {
    const option = document.createElement('option');
    option.value = itenSelect.composicao_id;
    option.text = itenSelect.composicao_nome;
    option.setAttribute('valorMonetario', 0);
    option.setAttribute('tipo', itenSelect.composicao_tipo_id);
    var valorComposicaoSalva = buscaComposicaoSalva(itenSelect.composicao_id)
    if (valorComposicaoSalva > 0) {
        option.selected = true;
    }
    return (option);
}

function criaCheckbox(composicaoInicial, data) {
    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.id = `composicao_${composicaoInicial.composicao_id}`;
    checkbox.name = `composicao_${composicaoInicial.composicao_id}`;
    checkbox.onchange = changeCheckBox;
    checkbox.className = 'form-check-input';
    checkbox.setAttribute('tipo', composicaoInicial.composicao_tipo_id);
    checkbox.setAttribute('valorMonetario', 0);
    if (composicaoInicial.composicao_obrigatoria == 1) {
        checkbox.setAttribute('required', '');
    }

    var valorComposicaoSalva = buscaComposicaoSalva(composicaoInicial.composicao_id)
    if (valorComposicaoSalva > 0) {
        checkbox.checked = true;
    }

    const label = document.createElement('label');
    label.htmlFor = `composicao_${composicaoInicial.composicao_id}`;
    label.textContent = composicaoInicial.composicao_nome;
    label.className = 'form-check-label';

    const checkboxDiv = document.createElement('div');
    checkboxDiv.className = 'form-check col-md-3 col-12';

    const itensDaComposicao = data.filter(item => item.composicao_pai_id == composicaoInicial.composicao_id);
    var meuSelectContainer = document.createElement('div');
    itensDaComposicao.forEach(itenSelect => {
        meuSelectContainer.appendChild(criaInput(itenSelect, data));
        meuSelectContainer.firstChild.classList.remove('col-md-3');
        meuSelectContainer.firstChild.classList.remove('col-12');
        var valorComposicaoSalva = buscaComposicaoSalva(itenSelect.composicao_id)
        if (valorComposicaoSalva == 0) {
            meuSelectContainer.firstChild.classList.add('hidden');
        }
    });

    //se tem o botão de ajuda 
    if ((composicaoInicial.ajuda_texto != '') || (composicaoInicial.ajuda_imagem != '')) {
        const inputGroupDiv = document.createElement('div');
        inputGroupDiv.className = 'input-group';

        const helpButton = document.createElement('div');
        helpButton.className = 'input-group-append';
        helpButton.onclick = function () { ajuda(this, composicaoInicial.composicao_id); };
        const helpIcon = document.createElement('span');
        helpIcon.className = 'input-group-text';
        helpIcon.textContent = '?';
        helpButton.appendChild(helpIcon);

        inputGroupDiv.appendChild(checkbox);
        inputGroupDiv.appendChild(label);
        inputGroupDiv.appendChild(helpButton);

        checkboxDiv.appendChild(inputGroupDiv);
    } else {
        checkboxDiv.appendChild(checkbox);
        checkboxDiv.appendChild(label);
    }

    checkboxDiv.appendChild(meuSelectContainer);

    return checkboxDiv;
}

function buscaComposicaoSalva(composicao_id) {
    var resultadoFiltrado = composicaoSalva.filter(function (item) {
        return item.composicao_id == composicao_id;
    });
    if (resultadoFiltrado.length > 0) {
        return (resultadoFiltrado[0]['pedido_item_composicao_valor']);
    } else {
        return 0;
    }
}

function buscaTextoComposicaoSalva(composicao_id) {
    var resultadoFiltrado = composicaoSalva.filter(function (item) {
        return item.composicao_id == composicao_id;
    });
    if (resultadoFiltrado.length > 0) {
        return (resultadoFiltrado[0]['texto']);
    } else {
        return 0;
    }
}

function criaMedida(composicao, data) {
    const inputNumero = document.createElement('input');
    inputNumero.type = 'number';
    inputNumero.id = `composicao_${composicao.composicao_id}`;
    inputNumero.name = `composicao_${composicao.composicao_id}`;
    inputNumero.step = '0.5';
    inputNumero.min = "0";
    inputNumero.max = "1000";
    inputNumero.className = 'form-control';
    inputNumero.setAttribute('composicao_pai', 'composicao_' + composicao.composicao_pai_id);
    inputNumero.setAttribute('tipo', composicao.composicao_tipo_id);
    inputNumero.onchange = mudaInputNumero;
    inputNumero.setAttribute('valorMonetario', 0);
    if (composicao.composicao_obrigatoria == 1) {
        inputNumero.setAttribute('required', '');
    }
    var valorComposicaoSalva = buscaComposicaoSalva(composicao.composicao_id)
    if (valorComposicaoSalva > 0) {
        inputNumero.value = valorComposicaoSalva;
    }
    const label = document.createElement('label');
    label.htmlFor = `composicao_${composicao.composicao_id}`;
    label.textContent = `${composicao.composicao_nome}: `;
    const inputDiv = document.createElement('div');
    inputDiv.className = 'input-numerico form-group mb-2 col-md-3 col-12';

    inputDiv.appendChild(label);
    //se tem o botão de ajuda 
    if ((composicao.ajuda_texto != '') || (composicao.ajuda_imagem != '')) {
        const inputGroupDiv = document.createElement('div');
        inputGroupDiv.className = 'input-group';

        const helpButton = document.createElement('div');
        helpButton.className = 'input-group-append';
        helpButton.onclick = function () { ajuda(this, composicao.composicao_id); };
        const helpIcon = document.createElement('span');
        helpIcon.className = 'input-group-text';
        helpIcon.textContent = '?';
        helpButton.appendChild(helpIcon);

        inputGroupDiv.appendChild(inputNumero);
        inputGroupDiv.appendChild(helpButton);

        inputDiv.appendChild(inputGroupDiv);
    } else {
        inputDiv.appendChild(inputNumero);
    }

    return inputDiv;
}

function criaQuantidade(composicao, data) {
    const inputNumero = document.createElement('input');
    inputNumero.type = 'number';
    inputNumero.id = `composicao_${composicao.composicao_id}`;
    inputNumero.name = `composicao_${composicao.composicao_id}`;
    inputNumero.step = '1';
    inputNumero.className = 'form-control';
    inputNumero.setAttribute('composicao_pai', 'composicao_' + composicao.composicao_pai_id);
    inputNumero.setAttribute('tipo', composicao.composicao_tipo_id);
    inputNumero.min = "0";
    inputNumero.max = "100";
    inputNumero.onchange = mudaInputNumero;
    inputNumero.setAttribute('valorMonetario', 0);
    if (composicao.composicao_obrigatoria == 1) {
        inputNumero.setAttribute('required', '');
    }

    var valorComposicaoSalva = buscaComposicaoSalva(composicao.composicao_id)
    if (valorComposicaoSalva > 0) {
        inputNumero.value = valorComposicaoSalva;
    }

    const label = document.createElement('label');
    label.htmlFor = `composicao_${composicao.composicao_id}`;
    label.textContent = `${composicao.composicao_nome}: `;

    const inputDiv = document.createElement('div');
    inputDiv.className = 'input-numerico form-group mb-2 col-md-3 col-12';

    inputDiv.appendChild(label);
    //se tem o botão de ajuda 
    if ((composicao.ajuda_texto != '') || (composicao.ajuda_imagem != '')) {
        const inputGroupDiv = document.createElement('div');
        inputGroupDiv.className = 'input-group';

        const helpButton = document.createElement('div');
        helpButton.className = 'input-group-append';
        helpButton.onclick = function () { ajuda(this, composicao.composicao_id); };
        const helpIcon = document.createElement('span');
        helpIcon.className = 'input-group-text';
        helpIcon.textContent = '?';
        helpButton.appendChild(helpIcon);

        inputGroupDiv.appendChild(inputNumero);
        inputGroupDiv.appendChild(helpButton);

        inputDiv.appendChild(inputGroupDiv);
    } else {
        inputDiv.appendChild(inputNumero);
    }

    return inputDiv;


    return inputDiv;
}

function selecionarOpcao() {
    for (var i = 0; i < this.options.length; i++) {
        var select = document.querySelectorAll('[composicao_pai="composicao_' + this.options[i].value + '"]')
        if (select.length > 0) {
            if (this.options[i].value == this.value) {
                select.forEach(function (elemento) {
                    elemento.parentElement.classList.remove('hidden');
                })
            } else {
                select.forEach(function (elemento) {
                    elemento.value = null;
                    elemento.parentElement.classList.add('hidden');
                })
            }
        }
    }

    //se esta editando e o valor é maior que zero pega a composição para o edit
    var selectElement = document.getElementById("composicao_tipo_id");
    if (selectElement == null) {
        processarInputs()
    }
}

function changeCheckBox() {
    if (this.checked) {
        document.querySelectorAll('[composicao_pai="' + this.id + '"]').forEach(function (elemento) {
            elemento.parentElement.classList.remove('hidden');
        })
    } else {
        document.querySelectorAll('[composicao_pai="' + this.id + '"]').forEach(function (elemento) {
            elemento.value = null;
            elemento.parentElement.classList.add('hidden');
        })
    }
    processarInputs()
}

function mudaInputNumero() {
    processarInputs()
}

function criaOpcaoVazia() {
    const option = document.createElement('option');
    option.value = '';
    option.text = '';
    return option;
}

function processarInputs() {

    const dadosParaEnviar = [];

    const dadosSelect = {
        valorTotal: input_valor_unitario.value,
        pedido_item_id: pedido_item_id,
        largura: larguraInput.value,
        altura: alturaInput.value,
        valorUnitarioTabel: input_valor_unitario_tabela.value,
        quantidade: quantidadeInput.value,
    };
    dadosParaEnviar.push(dadosSelect);

    if (usaTabelaPreco == 1) {
        atualizarValor()
    }
    const inputs = document.querySelectorAll('input[id*="composicao_"]');
    const selects = document.querySelectorAll('select[id*="composicao_"]');
    var valorUnitarioCalculado = 0;

    const composicao_ = /composicao_/;
    inputs.forEach(input => {
        if (composicao_.test(input.id)) {
            if (input.type == 'checkbox' && input.checked == true) {
                composicao_id = input.id.replace(/composicao_/g, '')
                const resultado = calcularExpressao(composicao_id);
                valorUnitarioCalculado += parseFloat(resultado) || 0;

                const dadosSelect = {
                    id: composicao_id,
                    valor: 1,
                    valorMonetario: resultado,
                    pedido_item_id: pedido_item_id,
                };
                dadosParaEnviar.push(dadosSelect);
            }
            if (input.type == 'number' && input.value > 0) {
                composicao_id = input.id.replace(/composicao_/g, '')
                const resultado = calcularExpressao(composicao_id);
                valorUnitarioCalculado += parseFloat(resultado) || 0;

                const dadosSelect = {
                    id: composicao_id,
                    valor: input.value,
                    valorMonetario: resultado,
                    pedido_item_id: pedido_item_id,
                };
                dadosParaEnviar.push(dadosSelect);

            }
            if (input.type == 'text' && input.value != '') {
                composicao_id = input.id.replace(/composicao_/g, '')
                const dadosSelect = {
                    id: composicao_id,
                    valor: 0,
                    valorMonetario: 0,
                    pedido_item_id: pedido_item_id,
                    texto: input.value,
                };
                dadosParaEnviar.push(dadosSelect);
            }
            if (input.type == 'hidden' && input.value != '') {
                composicao_id = input.id.replace(/composicao_/g, '')
                const dadosSelect = {
                    id: composicao_id,
                    valor: input.value,
                    valorMonetario: 0,
                    pedido_item_id: pedido_item_id
                };
                dadosParaEnviar.push(dadosSelect);
            }

        }
    });
    selects.forEach(select => {
        if (select.value > 0) {
            const resultado = calcularExpressao(select.value);
            valorUnitarioCalculado += parseFloat(resultado) || 0;

            const dadosSelect = {
                id: select.value,
                valor: 1,
                valorMonetario: resultado,
                pedido_item_id: pedido_item_id,
            };
            dadosParaEnviar.push(dadosSelect);

            const itensDaComposicao = composicao.filter(item => item.composicao_pai_id == select.value);
            itensDaComposicao.forEach(itenSelect => {
                if (itenSelect.composicao_tipo_id == COMPOSICAO_OCULTA) {
                    const resultadoOculta = calcularExpressao(itenSelect.composicao_id);
                    valorUnitarioCalculado += parseFloat(resultadoOculta) || 0;
                    const dadosOculto = {
                        id: itenSelect.composicao_id,
                        valor: 1,
                        valorMonetario: 0,
                        pedido_item_id: pedido_item_id,
                    };
                    dadosParaEnviar.push(dadosOculto);
                }
            });
        }
    });
    dadosJson = JSON.stringify(dadosParaEnviar);
    input_valor_unitario.value = valorUnitarioCalculado.toFixed(2)
    input_valor_total.value = (((parseFloat(input_valor_unitario_tabela.value) + parseFloat(valorUnitarioCalculado)).toFixed(2)) * parseFloat(quantidadeInput.value).toFixed(2)).toFixed(2)
    input_pedido_item_valor_venda.value = parseFloat(input_pedido_item_markup.value * input_valor_total.value).toFixed(2);
}