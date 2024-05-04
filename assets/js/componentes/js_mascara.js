document.addEventListener("DOMContentLoaded", function () {

    //mascara cep
    var cepInputs = document.querySelectorAll(".mascara-cep");
    cepInputs.forEach(function (input) {
        input.addEventListener("input", function (e) {
            var cep = this.value.replace(/\D/g, "");
            var maskedCep = "";

            if (cep.length <= 8) {
                if (cep.length > 5) {
                    maskedCep = cep.slice(0, 5) + "-" + cep.slice(5);
                } else {
                    maskedCep = cep;
                }
            } else {
                maskedCep = cep.slice(0, 8);
            }

            this.value = maskedCep;
        });
    });

    //busca cidade
    var cepInputs = document.querySelectorAll(".mascara-cep");

    cepInputs.forEach(function (input) {
        input.addEventListener("blur", function (e) {
            var cep = this.value.replace(/\D/g, "");

            if (cep.length === 8) {
                var url = "https://viacep.com.br/ws/" + cep + "/json/";

                fetch(url)
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (data) {
                        if (!data.erro) {
                            var ruaInput = document.querySelector(".rua");
                            var bairroInput = document.querySelector(".bairro");
                            var cidadeInput = document.querySelector(".cidade");
                            var estadoInput = document.querySelector(".estado");

                            ruaInput.value = data.logradouro || "";
                            bairroInput.value = data.bairro || "";
                            cidadeInput.value = data.localidade || "";
                            estadoInput.value = data.uf || "";
                        } else {
                            alert("CEP não encontrado.");
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        });
    });

});