$(document).ready(function () {
    var deletButton = document.getElementById('modal_ok');
    if (deletButton) {
        deletButton.addEventListener('click', function () {
            if (caminhoRetornoDelete == undefined) {
                caminhoRetornoDelete = controller;
            }
            var xhr = new XMLHttpRequest();
            xhr.open('POST', URL_BASE + controller + '/delete', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            var formData = new FormData();
            formData.append('_method', 'DELETE');
            formData.append('id', idLinha);
            formData.append('csrf_token', csrfToken);

            xhr.send(new URLSearchParams(formData));

            xhr.onload = function () {
                if (xhr.status === 200) {
                    window.location.href = URL_BASE + caminhoRetornoDelete;
                } else {

                }
            };
        });
    }
})

function fecharAlerta(botao) {
    var divPai = botao.closest(".alert");
    divPai.remove();
}

function fecharMsg(obj) {
    $(".msg").hide();
}

if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register('/service-worker.js').then(function (registration) {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);

            // Verifica se há uma atualização do service worker
            registration.onupdatefound = function () {
                const installingWorker = registration.installing;
                installingWorker.onstatechange = function () {
                    if (installingWorker.state === 'installed') {
                        if (navigator.serviceWorker.controller) {
                            // Novo service worker encontrado, informe ao usuário
                            console.log('New or updated content is available.');
                            alert('Nova versão disponível. Atualize a página.');
                        } else {
                            // Conteúdo pré-cachado foi atualizado
                            console.log('Content is now available offline!');
                        }
                    }
                };
            };
        }).catch(function (error) {
            console.log('ServiceWorker registration failed: ', error);
        });
    });
}
