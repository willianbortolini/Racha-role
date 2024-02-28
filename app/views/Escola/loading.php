<div class="col-10 ">

    <div class="caixa-loagin-azul">
        <div class="col-4 pl-0">
            <h2 class="tit1"> Circuito impresso, do zero ao profissional </h2>

            <p class="tit2">Aprenda a fazer placas de circuito para as mais diversas aplicações</p >

            <p>De R$75,90 por R$47,50 em até 9x de R$6,21</p>
            <?php if ($_SESSION[SESSION_LOGIN]->id_usuario) { ?>
                <div class="mt-6 text-center botao-mp" id="botao-mp">             
                    <script src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
                            data-preference-id="306339298-c49f7c6d-459d-45c4-987a-1652a708fcbb" data-source="button">
                    </script>
                </div>
            <?php } else { ?>
                <div class="mt-6 text-center botao-mp">
                    <button class="mt-4 text-center botao-mp" id="btnModal">Matricule-se agora</button>
                </div>
            <?php } ?>
        </div> 
        <div class="pl-0 col-8 ">
            <div >               
                <div class="caixa-embed">
                    <iframe src="https://www.youtube.com/embed/ENmhIFiGaF0?ecver=2" class="embed-item" width="655" height="360" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>                    
            </div>
        </div>        
    </div>


    <div class="caixa-loagin-azul2">
        <p class="mb-2"> Olá! Gostaria de apresentar a vocês o curso de Circuito impresso, do zero ao profissional.
            Este curso foi criado para aqueles que desejam aprender a projetar placas de circuito 
            impresso e a desenvolver produtos eletrônicos de maneira profissional.</p>
        <p >Ao longo do curso, você terá a oportunidade de aprender sobre a análise do projeto,
            incluindo a definição das tecnologias e da viabilidade financeira. Além disso, você
            também vai aprender sobre os testes essenciais para garantir a qualidade do produto final,
            bem como sobre o desenho de placas de circuito e a prototipagem.</p>
        <div class="col-12 mt-4">
            
            <div class="prev-curso">
                <div class="col-3 text-center">
                    <img class="img-curso " src="<?php echo URL_BASE . "assets/img/escola/" ?>dv1.png">
                    <h3>Estudo de requisitos</h3>
                </div>
                <div class="col-3 text-center">
                    <img class="img-curso " src="<?php echo URL_BASE . "assets/img/escola/" ?>dv6.png">
                    <h3>Entradas e Saídas</h3>
                </div>
                <div class="col-3 text-center">
                    <img class="img-curso " src="<?php echo URL_BASE . "assets/img/escola/" ?>dv2.png">
                    <h3>EASYEDA completo</h3>
                </div>
                <div class="col-3 text-center">
                    <img class="img-curso" src="<?php echo URL_BASE . "assets/img/escola/" ?>dv4.png">
                    <h3>simulação e prototipagem</h3>
                </div>
            </div>
        </div> 
    </div>

    <div class="caixa-loagin-azul">
        <div class="col-8 pl-0">

            <p class="pl-1"> Este curso segue uma metodologia testada por mim e que você poderá seguir passo a passo até
                ter o seu próprio produto da forma mais prática possível. Para lhe ensinar essa metodologia,
                vamos desenvolver juntos o projeto de um CLP com arduino nano. Este case possui 9 entradas
                digitais PNP e 7 saídas digitais NPN 24V, além de um arduino nano como processador, uma fonte
                e terminais para ligar IHMs ou outros cases via I2C.</p>

            <p class="pl-1">Como bônus, ao adquirir o curso de Circuito impresso, do zero ao profissional, o aluno também receberá 
                o projeto completo do CLP com arduino nano, que poderá ser usado em seus próprios projetos e modificado 
                de acordo com suas necessidades.</p>
        </div>
        <div class="col-4">
            <img class="img-curso" src="<?php echo URL_BASE . "assets/img/escola/" ?>case.png">
        </div>
    </div>


    <div class="caixa-loagin-azul2">
        <div class="col-12 mt-4 text-center">
            <h2>
                GARANTIMOS SATISFAÇÃO OU DINHEIRO DE VOLTA  
            </h2>
        </div>
        <p class="pl-1 mt-2">Gostaríamos de lhe oferecer a oportunidade de testar o nosso curso de Circuito impresso, do zero ao profissional
            por uma semana sem qualquer risco. Se, ao final desse período, você não estiver satisfeito
            com o curso, basta entrar em contato conosco e solicitar o reembolso total do valor pago.</p>

        <p class="pl-1">Acreditamos que o nosso curso é de alta qualidade e que oferece uma excelente oportunidade para
            aqueles que desejam aprender sobre o desenvolvimento de produtos eletrônicos de maneira profissional.
            No entanto, entendemos que cada pessoa é única e que o que é ideal para uns pode não ser para outros.
            Por isso, oferecemos essa garantia de reembolso sem perguntas para que você possa testar o curso sem 
            qualquer preocupação.</p>

        <p class="pl-1">Não perca essa oportunidade de aprender sobre o desenvolvimento de produtos eletrônicos com total segurança.
            Inscreva-se agora mesmo e comece a desenvolver seus próprios produtos eletrônicos de maneira profissional!</p>
        <dialog >  
            <div id="fecharModal"><button>X</button></div>
            <iframe id="ifr" class="modalLogin" src="<?php echo URL_BASE ?>patio">...</iframe> 

        </dialog>


        <?php if ($_SESSION[SESSION_LOGIN]->id_usuario) { ?>
            <div class="mt-4 text-center botao-mp" id="botao-mp">             
                <script src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
                        data-preference-id="306339298-c49f7c6d-459d-45c4-987a-1652a708fcbb" data-source="button">
                </script>
            </div>
        <?php } else { ?>
            <div class="mt-4 text-center botao-mp">
                <button class="mt-4 text-center botao-mp" id="btnModal">Fazer login para comprar</button>
            </div>
        <?php } ?>
        <div class="col-12 mt-4 text-center">
            <h2>
                SÓ R$47,50 POR TEMPO LIMITADO.   
            </h2>
        </div>
    </div>
    <div class="caixa-loagin-azul">
        <div class="col-12">        
            Não é necessário ter experiência prévia em projeto de produtos eletrônicos para participar do nosso curso 
            de Circuito impresso, do zero ao profissional. Este curso foi criado para pessoas de todos os níveis de conhecimento 
            e habilidade, desde iniciantes até profissionais experientes procurando aperfeiçoar suas técnicas.
        </div>
    </div>

    <div class="caixa-loagin-azul2">
        <div class="col-12 mt-4 text-center">
            <h3>
                <img class="" src="<?php echo URL_BASE . "assets/img/escola/" ?>whatsapp.png"> 
                <a class="link-verde" href="https://api.whatsapp.com/send?phone=5547988121414&text=Vi%20seu%20curso%2C%20gostaria%20de%20mais%20informa%C3%A7%C3%B5es.">Fale diretamento comigo (47)98812-1414</a>
            </h3 >

        </div>
    </div>
</div>

<script>
    document.querySelector("#botao-mp > button").textContent = "COMPRAR"
</script>
