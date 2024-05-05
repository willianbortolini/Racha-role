

function calcularExpressao(composicao_id) {

    let l = larguraInput.value;
    let a = alturaInput.value;
    let q = quantidadeInput.value;
    let v = 0;
    const elemento = document.getElementById('composicao_' + composicao_id);
    if (elemento !== null) {
        if ('value' in elemento) {
            v = elemento.value
        }
    }

    let t = input_valor_unitario_tabela.value;

    const compisicao_item = composicao.filter(item => item.composicao_id == composicao_id);
    if (compisicao_item[0].composicao_formula) {
        expressao = compisicao_item[0].composicao_formula;
        expressao = expressao.replace(/l/g, l).replace(/a/g, a).replace(/q/g, q).replace(/t/g, t).replace(/v/g, v).replace(/,/g, '.');
        let resultadoExpressao = eval(expressao)
        if (resultadoExpressao < 0) {
            resultadoExpressao = 0;
        }
        return resultadoExpressao;
    } else {
        return 0
    }
}

function carregaTabelaPreco() {
    const urlTabela = URL_BASE + "Tabela_preco_item/tabela/" + selectProduto.value;
    fetch(urlTabela)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.length > 0) {
                tabelaDePreco = data;

            } else {
                alert = document.getElementById('alert-danger')
                alert.classList.remove('hidden')
                alert.classList.add('d-flex')
                document.getElementById('textoDoAlert').innerText = 'Produto sem tabela de preço.';
                tabelaDePreco = null;
            }

        })
        .catch(error => {
            alert = document.getElementById('alert-danger')
            alert.classList.remove('hidden')
            alert.classList.add('d-flex')
            document.getElementById('textoDoAlert').innerText = 'Produto sem tabela de preço.';
            tabelaDePreco = null;
        });
}

var preco_medio = 0;
function mudaSelectProduto() {
    selectedOption = selectProduto.options[selectProduto.selectedIndex];
    usaTabelaPreco = selectedOption.getAttribute("usaTabelaPreco");
    preco_medio = selectedOption.getAttribute("preco");
    validaUsaTabela(usaTabelaPreco)
    pegaComposicao()
}

function validaUsaTabela(valor) {
    if (valor == 1) {
        carregaTabelaPreco()
        alturaInput.parentElement.classList.remove('hidden')
        larguraInput.parentElement.classList.remove('hidden')
        input_valor_unitario_tabela.parentElement.classList.remove('hidden')
    } else {
        alturaInput.parentElement.classList.add('hidden')
        larguraInput.parentElement.classList.add('hidden')
        input_valor_unitario_tabela.parentElement.classList.add('hidden')
        alturaInput.value = 0
        larguraInput.value = 0
        input_valor_unitario_tabela.value = 0
    }
}

function salva() {
    if ((tabelaDePreco == null) && (usaTabelaPreco == 1)) {
        alert = document.getElementById('alert-danger')
        alert.classList.remove('hidden')
        alert.classList.add('d-flex')
        document.getElementById('textoDoAlert').innerText = 'Não é possivel salvar um produto sem tabela de preço, selecione outro produto ou entre em contato com o suporte';
    } else {
        enviaComposicao();
    }
}
function verificaComposicoesObrigatorias() {
    var inputs = document.querySelectorAll('[required]')
    var formValido = true;

    inputs.forEach(function (input) {

        if (input.value.trim() === '') {
            formCheckDiv = input.closest('.form-check');
            if (formCheckDiv) {
                var checkboxElement = formCheckDiv.querySelector('input[type="checkbox"]');
                if (checkboxElement.checked) {
                    input.style.border = '1px solid red';
                    formValido = false;
                }
            } else {
                input.style.border = '1px solid red';
                formValido = false;
            }
        } else {
            input.style.border = '';
        }
    });

    if (!formValido) {
        alert = document.getElementById('alert-danger')
        alert.classList.remove('hidden')
        alert.classList.add('d-flex')
        document.getElementById('textoDoAlert').innerText = 'Preencha todos os campos obrigatórios!';
    }
    return formValido;

}

function enviaComposicao() {
    if (verificaComposicoesObrigatorias()) {

        processarInputs()
        if (input_valor_total.value > 0) {
            const urlDoServidor = URL_BASE + "/Pedido_item_composicao/salvaJson";
            fetch(urlDoServidor, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: dadosJson,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Erro na requisição: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success == true) {
                        document.getElementById("formulario").submit();
                    } else {
                        console.log("Erro no servidor".data);
                    }
                })
                .catch(error => {
                    return false
                });
        } else {
            alert = document.getElementById('alert-danger')
            alert.classList.remove('hidden')
            alert.classList.add('d-flex')
            document.getElementById('textoDoAlert').innerText = 'Não foi possível calcular o valor do produto, verifique as dimensões e quantidades';
        }
    }
}

function atualizarValor() {
    const novaLargura = parseFloat(larguraInput.value);
    const novaAltura = parseFloat(alturaInput.value);
    var alturaArredondada = Math.floor(novaAltura / 10) * 10;
    var larguraArredondada = Math.floor(novaLargura / 10) * 10;

    const larguraMinima = Math.min(...tabelaDePreco.map(item => item.largura));
    const alturaMinima = Math.min(...tabelaDePreco.map(item => item.altura));

    if (alturaArredondada < alturaMinima) {
        alturaArredondada = alturaMinima;
    }

    if (larguraArredondada < larguraMinima) {
        larguraArredondada = larguraMinima;
    }

    if (!isNaN(novaLargura) && !isNaN(novaAltura)) {
        const valorCorrespondente = obterValorTabelaDePrecos(alturaArredondada, larguraArredondada);
        if (valorCorrespondente !== null) {
            input_valor_unitario_tabela.value = Number(valorCorrespondente).toFixed(2)
        } else {
            input_valor_unitario_tabela.value = null
        }
    }
}

function obterValorTabelaDePrecos(altura, largura) {
    const alturaArredondada = Math.floor(altura / 10) * 10;
    const larguraArredondada = Math.floor(largura / 10) * 10;
    const itemCorrespondente = tabelaDePreco.find(item => item.altura == alturaArredondada && item.largura == larguraArredondada);
    return itemCorrespondente ? itemCorrespondente.valor : null;
}

function pegaComposicao() {
    let urlComposicao = URL_BASE + "Composicao/composicaoProduto/" + selectProduto.value;

    fetch(urlComposicao)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            composicao = data;
            const itensDiv = document.getElementById('itens');
            itensDiv.innerHTML = '';         
            const composicoesIniciais = data.filter(item => item.composicao_pai_id == 0);
            composicoesIniciais.forEach(composicaoInicial => {
                itensDiv.appendChild(criaInput(composicaoInicial, data))
            });
        })
        .catch(error => {
            console.error('Erro durante a requisição:', error);
        });
}