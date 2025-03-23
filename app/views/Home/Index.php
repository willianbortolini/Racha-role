<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Racha Role - Divida despesas com amigos sem complicações</title>
    <style>
        :root {
            --primary-color: #FF6B6B;
            --secondary-color: #4ECDC4;
            --dark-color: #292F36;
            --light-color: #F7FFF7;
            --accent-color: #FFE66D;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            color: var(--dark-color);
            line-height: 1.6;
        }

        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem;
            position: fixed;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.5rem 1rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .logo-icon {
            margin-right: 10px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        .btn {
            background-color: white;
            color: var(--primary-color);
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: var(--accent-color);
            color: var(--dark-color);
        }

        section {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        #hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: url('/api/placeholder/800/600') no-repeat center center/cover;
            position: relative;
            color: white;
            padding-top: 7rem;
        }

        #hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(78, 205, 196, 0.7), rgba(255, 107, 107, 0.7));
            z-index: -1;
        }

        h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .tagline {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            max-width: 800px;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .phone-mockup {
            max-width: 100%;
            margin-top: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .feature-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        #como-funciona {
            background-color: var(--light-color);
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .step-number {
            background-color: var(--primary-color);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .step-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .testimonials {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .testimonial {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 1rem;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .author-info {
            line-height: 1.3;
        }

        .author-name {
            font-weight: 600;
        }

        .author-role {
            color: #777;
            font-size: 0.9rem;
        }

        .team-members {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .team-member {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .team-member:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .member-photo {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .member-info {
            padding: 1.5rem;
            text-align: center;
        }

        .member-name {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .member-role {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .social-links a {
            color: var(--dark-color);
            font-size: 1.2rem;
            transition: 0.3s;
        }

        .social-links a:hover {
            color: var(--primary-color);
        }

        .faq-container {
            max-width: 800px;
            margin: 3rem auto 0;
        }

        .faq-item {
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .faq-question {
            background-color: white;
            padding: 1.5rem;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-answer {
            padding: 0 1.5rem 1.5rem;
            border-top: 1px solid #eee;
            display: none;
        }

        #contato {
            background-color: var(--light-color);
        }

        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        input,
        textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            transition: opacity 0.5s ease-out;
        }

        .loading-logo {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-logo {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .footer-links h3 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .footer-links h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 40px;
            height: 2px;
            background-color: var(--primary-color);
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .pwa-badge {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }

        .copyright {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #bbb;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            .tagline {
                font-size: 1.2rem;
            }

            .nav-links {
                display: none;
            }

            .footer-content {
                text-align: center;
            }

            .footer-links h3::after {
                left: 50%;
                transform: translateX(-50%);
            }
        }

        a {
            text-decoration: none;
            /* Tira o sublinhado */
            color: inherit;
            /* Faz o link herdar a cor do elemento pai */
        }
    </style>
</head>

<body>
    <!-- Loading Screen -->
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-logo">
            <span class="logo-icon">🎯</span> Racha Role
        </div>
        <div class="loading-spinner"></div>
    </div>

    <!-- Header -->
    <header>
        <nav>
            <a href="#" class="logo"><span class="logo-icon">🎯</span> Racha Role</a>
            <div class="nav-links">
                <a href="#recursos">Recursos</a>
                <a href="#como-funciona">Como Funciona</a>
                <a href="#depoimentos">Depoimentos</a>
                <a href="#equipe">Equipe</a>
                <a href="#faq">FAQ</a>
                <a href="#contato">Contato</a>
            </div>
            <a href="<?php echo URL_BASE . 'login'?>" class="btn">Comece Agora</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="hero">
        <h1>Divida despesas de rolês sem complicações</h1>
        <p class="tagline">Chega de calculadoras, discussões e amizades arruinadas por dinheiro. Com o Racha Role, dividir contas nunca foi tão simples e justo!</p>
        <div class="cta-buttons">
            <a href="#comece-agora" class="btn">Comece Agora - É Grátis!</a>
            <a href="#como-funciona" class="btn btn-secondary">Como Funciona</a>
        </div>
        <!--<img src="/api/placeholder/300/600" alt="Racha Role App Screenshot" class="phone-mockup"> -->
    </section>

    <!-- Features Section -->
    <section id="recursos">
        <h2>Por que escolher o Racha Role?</h2>
        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">💻</div>
                <h3 class="feature-title">Acesse de Qualquer Lugar</h3>
                <p>O Racha Role funciona em qualquer dispositivo com acesso à internet, sem precisar baixar nada.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🧮</div>
                <h3 class="feature-title">Divisão Inteligente</h3>
                <p>Algoritmos avançados que dividem as despesas de forma justa, até mesmo quando consumos são diferentes.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔔</div>
                <h3 class="feature-title">Lembretes Amigáveis</h3>
                <p>Notificações automáticas para lembrar os amigos de pagar sem causar desconforto.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔄</div>
                <h3 class="feature-title">Sincronização em Tempo Real</h3>
                <p>Todas as alterações são sincronizadas instantaneamente entre todos os participantes do rolê.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💸</div>
                <h3 class="feature-title">Informações de Pagamento</h3>
                <p>Compartilhe facilmente dados do Pix ou outras formas de pagamento diretamente pelo app.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3 class="feature-title">Relatórios Detalhados</h3>
                <p>Acompanhe seus gastos em grupo e veja exatamente como seu dinheiro está sendo gasto.</p>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="como-funciona">
        <h2>Como Funciona</h2>
        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <h3 class="step-title">Crie um Rolê</h3>
                <p>Inicie um novo rolê para uma viagem, festa, happy hour ou qualquer ocasião que exija divisão de despesas.</p>
                <!--<img src="/api/placeholder/250/150" alt="Criar Rolê" style="margin-top: 1rem; border-radius: 10px;"> -->
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h3 class="step-title">Adicione Despesas</h3>
                <p>Registre as despesas facilmente, especificando quem pagou e como deve ser dividido entre os participantes.</p>
                <!--<img src="/api/placeholder/250/150" alt="Adicionar Despesas" style="margin-top: 1rem; border-radius: 10px;"> -->
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h3 class="step-title">Veja o Balanço</h3>
                <p>O app calcula automaticamente quem deve quanto a quem, simplificando os pagamentos.</p>
                <!--<img src="/api/placeholder/250/150" alt="Ver Balanço" style="margin-top: 1rem; border-radius: 10px;"> -->
            </div>
            <div class="step">
                <div class="step-number">4</div>
                <h3 class="step-title">Acerte as Contas</h3>
                <p>Compartilhe informações de pagamento e marque como liquidado quando as dívidas forem pagas.</p>
                <!--<img src="/api/placeholder/250/150" alt="Acertar Contas" style="margin-top: 1rem; border-radius: 10px;"> -->
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="depoimentos">
        <h2>O que nossos usuários dizem</h2>
        <div class="testimonials">
            <div class="testimonial">
                <p class="testimonial-text">"Depois que comecei a usar o Racha Role, nunca mais tivemos problemas com divisão de contas nos nossos rolês de fim de semana. É simplesmente perfeito!"</p>
                <div class="testimonial-author">
                    <!--<img src="/api/placeholder/50/50" alt="Mariana Silva" class="author-avatar"> -->
                    <div class="author-info">
                        <div class="author-name">Mariana Silva</div>
                        <div class="author-role">Organizadora de rolês</div>
                    </div>
                </div>
            </div>
            <div class="testimonial">
                <p class="testimonial-text">"Morar em república ficou muito mais fácil! Dividimos todas as despesas da casa no Racha Role e nunca mais tivemos discussões sobre dinheiro."</p>
                <div class="testimonial-author">
                    <!--<img src="/api/placeholder/50/50" alt="Lucas Mendonça" class="author-avatar"> -->
                    <div class="author-info">
                        <div class="author-name">Lucas Mendonça</div>
                        <div class="author-role">Estudante universitário</div>
                    </div>
                </div>
            </div>
            <div class="testimonial">
                <p class="testimonial-text">"A melhor parte é não precisar baixar nada! Acesso pelo navegador do celular e tudo funciona perfeitamente. Simplesmente incrível!"</p>
                <div class="testimonial-author">
                    <!--<img src="/api/placeholder/50/50" alt="Fernanda Oliveira" class="author-avatar"> -->
                    <div class="author-info">
                        <div class="author-name">Fernanda Oliveira</div>
                        <div class="author-role">Profissional de marketing</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="equipe">
        <h2>Conheça Nossa Equipe</h2>
        <div class="team-members">
            <div class="team-member">
                <!-- <img src="/api/placeholder/250/250" alt="Bruno Oliveira" class="member-photo"> -->
                <div class="member-info">
                    <h3 class="member-name">Willian Bortolini</h3>
                    <div class="member-role">Desenvolvedor Full-Stack</div>
                    <p>Especialista em desenvolvimento web, Willian é responsável pela infraestrutura robusta que permite que o Racha Role funcione perfeitamente em qualquer dispositivo.</p>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/in/willian-bortolini-a509a41b2/"><span>🔗</span></a>
                        <a href="https://www.instagram.com/willian_bortolini/"><span>📷</span></a>
                        <a href="mailto:willian.borto@gmail.com"><span>📧</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq">
        <h2>Perguntas Frequentes</h2>
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question">
                    O app é gratuito?
                    <span>+</span>
                </div>
                <div class="faq-answer">
                    <p>Sim, o Racha Role é totalmente gratuito para uso básico. Oferecemos também uma versão premium com recursos adicionais como exportação de relatórios, grupos ilimitados e personalização avançada.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    Preciso baixar algum aplicativo?
                    <span>+</span>
                </div>
                <div class="faq-answer">
                    <p>Não! O Racha Role é um aplicativo web progressivo (PWA) que funciona diretamente no navegador de qualquer dispositivo. Você pode acessá-lo pelo navegador e até mesmo adicionar à tela inicial do seu celular para uma experiência semelhante a um aplicativo nativo.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    Como funciona a divisão desigual de despesas?
                    <span>+</span>
                </div>
                <div class="faq-answer">
                    <p>O Racha Role permite que você divida as despesas de várias formas: igualmente entre todos, por porcentagens específicas, ou por valores exatos. Por exemplo, se foram pedidas bebidas diferentes com preços diferentes, você pode especificar exatamente quanto cada pessoa deve pagar.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    É possível usar o app offline?
                    <span>+</span>
                </div>
                <div class="faq-answer">
                    <p>Sim! Por ser um PWA, o Racha Role funciona mesmo quando você está offline. Você pode adicionar despesas sem conexão com a internet e quando seu dispositivo se conectar novamente, todas as informações serão sincronizadas automaticamente.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    Como faço para convidar amigos para um rolê?
                    <span>+</span>
                </div>
                <div class="faq-answer">
                    <p>Existem várias formas de convidar amigos: você pode compartilhar um link direto para o rolê, enviar um código QR, ou convidar diretamente pelo e-mail ou número de telefone se a pessoa já tiver uma conta no Racha Role.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contato">
        <h2>Entre em Contato</h2>
        <div class="contact-form">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" placeholder="Seu nome completo">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" placeholder="seu@email.com">
            </div>
            <div class="form-group">
                <label for="subject">Assunto</label>
                <input type="text" id="subject" placeholder="Sobre o que você quer falar?">
            </div>
            <div class="form-group">
                <label for="message">Mensagem</label>
                <textarea id="message" placeholder="Sua mensagem aqui..."></textarea>
            </div>
            <button type="submit" class="btn btn-secondary" style="width: 100%;">Enviar Mensagem</button>
        </div>
    </section>

    <!-- Get Started Section -->
    <section id="comece-agora" style="text-align: center;">
        <h2>Comece a Usar o Racha Role Agora</h2>
        <p style="max-width: 700px; margin: 0 auto 2rem;">Não é necessário baixar nada! Acesse nossa aplicação web em qualquer dispositivo e comece a dividir despesas com seus amigos de forma simples e sem estresse!</p>
        <div class="cta-buttons" style="justify-content: center;">
            <a href="<?php echo URL_BASE . 'login'?>" class="btn btn-secondary" style="font-size: 1.2rem; padding: 0.8rem 2rem;">Acessar o Racha Role</a>
        </div>
        <p style="margin-top: 1.5rem;">Dica: Adicione à tela inicial do seu celular para uma experiência completa!</p>
        <div class="pwa-badge">
            <!--<img src="/api/placeholder/200/60" alt="Adicione à tela inicial" style="margin-top: 1rem;">-->
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-about">
                <a href="#" class="footer-logo"><span class="logo-icon">💰</span> Racha Role</a>
                <p>Simplificando a divisão de despesas entre amigos desde 2022. Nossa missão é tornar as contas compartilhadas mais fáceis e transparentes para todos.</p>
                <div class="download-badges">
                    <!--<img src="/api/placeholder/120/40" alt="Download na App Store" class="download-badge">-->
                    <!--<img src="/api/placeholder/120/40" alt="Download no Google Play" class="download-badge">-->
                </div>
            </div>
            <div class="footer-links">
                <h3>Links Rápidos</h3>
                <ul>
                    <li><a href="#recursos">Recursos</a></li>
                    <li><a href="#como-funciona">Como Funciona</a></li>
                    <li><a href="#depoimentos">Depoimentos</a></li>
                    <li><a href="#equipe">Equipe</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h3>Suporte</h3>
                <ul>
                    <li><a href="#">Central de Ajuda</a></li>
                    <li><a href="#">Tutoriais</a></li>
                    <li><a href="#">Política de Privacidade</a></li>
                    <li><a href="#">Termos de Uso</a></li>
                    <li><a href="#contato">Contato</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h3>Contato</h3>
                <ul>
                    <li>📧 willian.borto@gmail.com</li>
                    <li>📱 (47) 98812-1414</li>
                </ul>
                <div class="social-links" style="margin-top: 1rem;">
                    <a href="#"><span>🔗</span></a>
                    <a href="#"><span>📱</span></a>
                    <a href="#"><span>📧</span></a>
                    <a href="#"><span>📷</span></a>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 Racha Role. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Loading screen
        window.addEventListener('load', function() {
            setTimeout(function() {
                const loadingOverlay = document.getElementById('loading-overlay');
                loadingOverlay.style.opacity = '0';
                setTimeout(function() {
                    loadingOverlay.style.display = 'none';
                }, 500);
            }, 1500); // Ajuste o tempo de carregamento conforme necessário
        });

        // FAQ accordion que abre um e fecha os outros
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const isOpen = answer.style.display === 'block';

                // Fecha todos primeiro
                document.querySelectorAll('.faq-answer').forEach(item => {
                    item.style.display = 'none';
                });

                document.querySelectorAll('.faq-question span').forEach(item => {
                    item.textContent = '+';
                });

                // Se não tava aberto, abre o clicado
                if (!isOpen) {
                    answer.style.display = 'block';
                    question.querySelector('span').textContent = '-';
                }
            });
        });

        // Smooth scrolling para links de ancoragem
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Animação para os cards de recursos
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card, .step, .testimonial, .team-member').forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(item);
        });

        // Validação simples do formulário de contato
        const contactForm = document.querySelector('.contact-form');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();

                let isValid = true;
                const name = document.getElementById('name');
                const email = document.getElementById('email');
                const message = document.getElementById('message');

                if (!name.value.trim()) {
                    isValid = false;
                    name.style.borderColor = 'red';
                } else {
                    name.style.borderColor = '#ddd';
                }

                if (!email.value.trim() || !email.value.includes('@')) {
                    isValid = false;
                    email.style.borderColor = 'red';
                } else {
                    email.style.borderColor = '#ddd';
                }

                if (!message.value.trim()) {
                    isValid = false;
                    message.style.borderColor = 'red';
                } else {
                    message.style.borderColor = '#ddd';
                }

                if (isValid) {
                    // Simulação de envio
                    const submitButton = contactForm.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;
                    submitButton.textContent = 'Enviando...';
                    submitButton.disabled = true;

                    setTimeout(() => {
                        alert('Mensagem enviada com sucesso! Entraremos em contato em breve.');
                        contactForm.reset();
                        submitButton.textContent = originalText;
                        submitButton.disabled = false;
                    }, 1500);
                } else {
                    alert('Por favor, preencha todos os campos obrigatórios corretamente.');
                }
            });
        }

        // Detectar quando o usuário rola a página para mostrar/ocultar o botão de voltar ao topo
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');

            if (window.scrollY > 100) {
                header.style.background = 'var(--dark-color)';
                header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.3)';
            } else {
                header.style.background = 'linear-gradient(135deg, var(--primary-color), var(--secondary-color))';
                header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
            }
        });

        // Estatísticas de usuários
        // Simulando números que aumentam progressivamente
        function animateValue(obj, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerHTML = Math.floor(progress * (end - start) + start).toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Adicionar contador de estatísticas (poderia ser adicionado a uma seção)
        // Esta funcionalidade está comentada, mas pode ser implementada adicionando
        // os elementos HTML correspondentes

        const userCountElement = document.getElementById('user-count');
        const groupCountElement = document.getElementById('group-count');
        const transactionCountElement = document.getElementById('transaction-count');

        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (userCountElement) animateValue(userCountElement, 0, 150000, 2000);
                    if (groupCountElement) animateValue(groupCountElement, 0, 75000, 2000);
                    if (transactionCountElement) animateValue(transactionCountElement, 0, 1500000, 2000);
                    statsObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            statsObserver.observe(statsSection);
        }
    </script>
</body>

</html>