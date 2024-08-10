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
