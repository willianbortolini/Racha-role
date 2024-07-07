
function handleFileInputChange(event) {

    var file = event.target.files[0];
    var reader = new FileReader();
    var previewContainer = event.target.parentNode.querySelector("[for='" + event.target.id + "']");
    reader.onload = function (e) {
        var img = document.createElement("img");
        img.src = e.target.result;
        console.log("imagemCircular");
        img.classList.add = "imagemCircular";

        previewContainer.innerHTML = "";
        previewContainer.appendChild(img);
    };

    reader.readAsDataURL(file);
}

var fileInputs = document.querySelectorAll("input[type=file]");

fileInputs.forEach(function (fileInput) {
    fileInput.addEventListener("change", handleFileInputChange);
});

// Adicione um evento de clique aos botões "Editar"
const editButtons = document.querySelectorAll('.btn-edit');
editButtons.forEach(button => {
    button.addEventListener('click', function () {
        const targetId = this.dataset.target;
        document.getElementById(targetId).click();
    });
});

function toggleExclusao(button) {
    const targetId = button.dataset.target;
    const checkbox = document.getElementById(targetId);
    const imageLabel = button.parentElement.previousElementSibling;

    if (checkbox.checked) {
        // Se o checkbox estiver marcado, desmarque-o e remova a classe "exclusao-ativa"
        checkbox.checked = false;
        imageLabel.classList.remove("exclusao-ativa");
        button.innerText = "Excluir";
    } else {
        // Se o checkbox estiver desmarcado, marque-o e adicione a classe "exclusao-ativa"
        checkbox.checked = true;
        imageLabel.classList.add("exclusao-ativa");
        button.innerText = "Cancelar exclusão";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    // Adicionar eventos de clique aos botões "Excluir"
    const deleteButtons = document.querySelectorAll(".btn-delete");
    deleteButtons.forEach(button => {
        button.addEventListener("click", function () {
            toggleExclusao(this);
        });
    });


});

