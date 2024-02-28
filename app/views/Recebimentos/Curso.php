<script src="https://sdk.mercadopago.com/js/v2"></script>

<div class="row mt-2">

    <div class="card col-md-6 col-12  bg-dark text-white">
        <div class="card-body">
            <h3>Você está a apenas um passo de transformar sua jornada profissional!</h3>
            <ul class="list-unstyled beneficios mt-3">
                <li class="mt-2">Ao se inscrever no <strong>
                        <?= $curso->nome ?>
                    </strong>, você não está apenas adquirindo
                    conhecimento de ponta em <strong>
                        <?= $curso->area ?>
                    </strong></strong>; você está investindo no seu futuro. Com
                    acesso instantâneo a materiais exclusivos, tutoriais passo a passo, você tem tudo o que precisa para
                    dar o próximo grande salto em sua carreira.</li>
                <li class="mt-2">Valorizamos sua segurança. Nosso processo de pagamento é seguro e suas
                    informações estão protegidas.</li>
                <li class="mt-2">Oferecemos uma garantia de reembolso de 30 dias. Se o curso não atender às suas
                    expectativas, você pode solicitar o reembolso sem complicações.</li>
            </ul>
            <h2 class="desconto mt-3">
                <?= $curso->desconto ?>% OFF
            </h2>
            <p class=" preco-original mt-3">R$
                <?= moedaBr($curso->preco_original); ?>
            </p>
            <p class="preco-novo mt-4">R$
                <?= moedaBr($preco); ?>
            </p>
            <p class="mt-4">Parcele sua compra como preferir.</p>

        </div>
    </div>
    <div class="card-page col-md-6 col-12">
        <div id="statusScreenBrick_container"></div>
        <div id="paymentBrick_container"></div>
        <div class="card bg-dark text-white  mt-2">
            <div class="card-body">
                <h3>Você Está Dentro! Prepare-se para Explorar
                    <?php echo $curso->nome ?>
                </h3>
                <div>
                    <a href="URL_DO_CURSO" class="btn btn-success btn-block w-100">Ir para o Curso</a>
                </div>
            </div>
        </div>
    </div>


</div>
<script>
    const mp = new MercadoPago('TEST-cd7fb534-9799-402e-aae0-bb180c275b75');
    const bricksBuilder = mp.bricks();

    const renderPaymentBrick = async (bricksBuilder) => {
        const settings = {
            initialization: {

                amount: '<?= $preco; ?>',
                preferenceId: '<?= $preference_id; ?>',
            },
            customization: {
                paymentMethods: {
                    //bankTransfer: "all",
                    creditCard: "all",
                    //debitCard: "all",
                    //mercadoPago: "all",
                },
                visual: {
                    style: {
                        theme: "dark",
                        customVariables: {
                            "formBackgroundColor": "#212529",
                        },
                    },

                },
            },
            callbacks: {
                onReady: () => {
                    /*
                     Callback chamado quando o Brick estiver pronto.
                     Aqui você pode ocultar loadings do seu site, por exemplo.
                    */
                    console.log("pronto");
                },
                onSubmit: ({ selectedPaymentMethod, formData }) => {
                    // callback chamado ao clicar no botão de submissão dos dados   
                    formData.external_reference = '<?php echo $recebimento->recebimentos_id; ?>'
                    return new Promise((resolve, reject) => {
                        fetch("<?php echo URL_BASE . 'recebimentos/aprove' ?>", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify(formData),
                        })
                            .then((response) => response.json())
                            .then((response) => {
                                // receber o resultado do pagamento
                                console.log(response)
                                const renderStatusScreenBrick = async (bricksBuilder) => {
                                    const settings = {
                                        initialization: {
                                            paymentId: response.id, // id do pagamento a ser mostrado
                                        },
                                        callbacks: {
                                            onReady: () => {
                                                $("#paymentBrick_container").hide();
                                            },
                                            onError: (error) => {
                                                // callback chamado para todos os casos de erro do Brick
                                                console.error(error);
                                            },
                                        },
                                    };
                                    window.statusScreenBrickController = await bricksBuilder.create(
                                        'statusScreen',
                                        'statusScreenBrick_container',
                                        settings,
                                    );
                                };
                                renderStatusScreenBrick(bricksBuilder);

                                resolve();
                            })
                            .catch((error) => {
                                // lidar com a resposta de erro ao tentar criar o pagamento
                                reject();
                            });
                    });
                },
                onError: (error) => {
                    // callback chamado para todos os casos de erro do Brick
                    console.error(error);
                },
            },
        };
        window.paymentBrickController = await bricksBuilder.create(
            "payment",
            "paymentBrick_container",
            settings
        );
    };
    renderPaymentBrick(bricksBuilder);


</script>