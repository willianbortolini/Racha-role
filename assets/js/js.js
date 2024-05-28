$(function () {

    $('.filtro').click(function () {
        $('.mostraFiltro').slideToggle();
        $(this).toggleClass('active');
        return false;
    });

    $('.mobmenu').click(function () {
        $('.menu-lateral').slideToggle();
        $(this).toggleClass('active');
        return false;
    });

    $(".accordion").accordion({
        collapsible: true,
        autoHeight: false,
        active: false,
        heightStyle: "content"
    });

});

function pegaArquivo(files) {
    var file = files[0];
    const fileReader = new FileReader();
    fileReader.onloadend = function () {
        $("#imgUp").attr("src", fileReader.result);
    }
    fileReader.readAsDataURL(file);

}

function excluir(obj) {
    var entidade = $(obj).attr('data-entidade');
    var id = $(obj).attr('data-id');
    if (confirm('Deseja realmente excluir ?')) {
        window.location.href = base_url + entidade + "/excluir/" + id;
    }
}

function excluirRecaregando(obj) {
    var entidade = $(obj).attr('data-entidade');
    var id = $(obj).attr('data-id');
    if (confirm('Deseja realmente excluir ?')) {
        $.get(base_url + entidade + "/excluir/" + id, {})
                .done(function (data) {
                    window.location.reload();
                })
    }
}

function fecharMsg(obj) {
    $(".msg").hide();
}

function formataData(data) {
    var diaContagem = data.slice(8, 10);
    var mesContagem = data.slice(5, 7);
    var anoContagem = data.slice(0, 4);
    var horaContagem = data.slice(11, 13);
    var minutoContagem = data.slice(14, 16);
    var segundoContagem = data.slice(17, 19);
    var d = new Date(anoContagem, mesContagem - 1, diaContagem, horaContagem, minutoContagem, segundoContagem);
    return d;
}

