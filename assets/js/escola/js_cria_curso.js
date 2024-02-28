

const inputs = document.querySelectorAll('#grade_curicular li input');
inputs.forEach(input => {
    input.addEventListener('keydown', keypress);
    input.addEventListener('focusout', onfocusout);
});

function onfocusout() {
    var capitulo_id = this.getAttribute("capitulo_id");
    var aula_id = this.getAttribute("aula_id");
    if (aula_id === null) {
        //se é para mudar o nome do capitulo 
        atualizaNomeCapitulo(capitulo_id, this.value)
    } else {
        //se é para mudar o nome da aula
        atualizaNomeAula(aula_id, this.value)
    }
}

function keypress(e) {
    var capitulo_id = this.getAttribute("capitulo_id");
    var aula_id = this.getAttribute("aula_id");

    if (e.key === 'Enter') {
        if (aula_id === null) {
            //se é para mudar o nome do capitulo 
            atualizaNomeCapitulo(capitulo_id, this.value)
        } else {
            //se é para mudar o nome da aula
            atualizaNomeAula(aula_id, this.value)
        }
        return false;
    }
}

function atualizaNomeAula(aula_id, novoNome) {
    var url = "https://w9b2.com/escola/mudaNomeAula/" + aula_id + "/" + novoNome;//Sua URL

    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", url, false);
    xhttp.send();
}

function atualizaNomeCapitulo(capitulo_id, novoNome) {
    var url = "https://w9b2.com/escola/mudaNomeCapitulo/" + capitulo_id + "/" + novoNome;//Sua URL

    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", url, false);
    xhttp.send();
}

$(function () {
    /* const btnCriaCapitulo = document.getElementById("adicionaCapitulo");
     btnCriaCapitulo.onclick = function () {
     var url = "https://w9b2.com/escola/adicionaCapitulo/1";//Sua URL
     
     var xhttp = new XMLHttpRequest();
     xhttp.open("GET", url, false);
     xhttp.send();
     var capitulo =  JSON.parse(xhttp.responseText);
     // $("<span>Hello world!</span>").insertAfter("#nav");
     console.log(capitulo.capitulo_id)     
     var lista  = document.getElementById("nav").innerHTML;
     lista = lista +"<li><label for='sub"+ capitulo.capitulo_id +"'><h4>"+capitulo.titulo_capitulo+"</h4></label><input id='sub"+capitulo.capitulo_id+"' type='checkbox'><ul><li>inserir aula</li></ul></li>";
     document.getElementById("nav").innerHTML = lista;
     
     }  */




});


