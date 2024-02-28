$(function () {
	/*** modal **/
	$("a[rel=modal]").click( function(ev){
        ev.preventDefault();
 
        var id = $(this).attr("href");                 
         tela(id);	
		
    });
 
    $("#mascara").click( function(){
        $(this).hide();
        $(".window").hide();
    });
 
    $('.fechar').click(function(ev){
        ev.preventDefault();
        $("#mascara").hide();
        $(".window").hide();
    });
	
	/*** fim modal 	**/ 

});	

function abrirModal(id){
    var alturaTela = $(document).height();
    var larguraTela = $(window).width();

    //colocando o fundo preto
    $('#mascara').css({'width':larguraTela,'height':alturaTela});
    $('#mascara').fadeIn(1000);	
    $('#mascara').fadeTo("slow",0.8);

    var left = "left: "+(($(window).width() /2) - ( $(id).width() / 2 ))+"px !important;";
    var top = "top:"+($(window).scrollTop())+"px !important";
    var posição= left+top;
    $(id).css({'cssText': posição});;
    $(id).show();
}

function fecharModal(){
	//inicio();	
	$("#mascara").hide();
    $(".window").hide();
}