
document.addEventListener('DOMContentLoaded', function () {
    $('.menu-m').click(function () {
        $('#menu').slideToggle();
        $(this).toggleClass('active');
        return false;
    });

    $("#ocultar-menu").click(function (e) {
        e.preventDefault();
        $(".menu-lateral").toggleClass("oculto");
        $("#ocultar-menu").toggleClass("oculto");
        $(".base-geral").toggleClass("expandido");
    });

    $('.senha').click(function () {
        $('.mostrasenha').slideToggle();

        $(this).toggleClass('active');
        return false;
    });

    const btnModal = document.getElementById("btnModal");
    const modal = document.querySelector("dialog");
    if (btnModal) {
        btnModal.onclick = function () {
            modal.showModal();
        }
        console.log("teste");
    }

    const botaoFechaModal = document.getElementById("fecharModal");
    if (botaoFechaModal) {
        botaoFechaModal.onclick = function () {
            modal.close();
            parent.location.reload();

        }
    }


});



