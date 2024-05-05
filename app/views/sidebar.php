<?php if ((isset($_SESSION['he_administrador'])) or (isset($_SESSION['he_colaborador']))) { ?>
    <div class="col-auto px-0">
        <div id="sidebar" class="collapse collapse-horizontal show border-end">
            <div id="sidebar-nav" class="list-group border-0 rounded-0 text-sm-start min-vh-100">
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start  text-dark" id="menu">
                    <li class="nav-item">
                        <a href="<?php echo URL_BASE ?>" class="nav-link text-truncate text-dark mt-md-4">
                            <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <!--<li class="nav-item">
                  <a href="<?php echo URL_BASE . 'home/DashboardAdministrador' ?>" class="nav-link text-truncate text-dark">
                    <i class="fs-5 bi-speedometer2"></i><span class="ms-1 d-none d-sm-inline">Dashboard</span>
                  </a>
                </li>
                <li>
                <a href="#submenu1" data-bs-toggle="collapse" class="nav-link text-truncate text-dark">
                  <i class="fs-5 bi-speedometer2"></i><span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
              </li>-->
                    <?php if (in_array(TELA_FINANCEIRO_FATURAS, $_SESSION['acessos'])) { ?>
                        <li>
                            <a href="<?php echo URL_BASE . "faturas" ?>" class="nav-link text-truncate text-dark">
                                <i class="bi bi-bar-chart-line"></i><span class="ms-1 d-none d-sm-inline">Faturas</span></a>
                        </li>
                    <?php } ?>
                    <?php if (in_array(TELA_PRODUCAO, $_SESSION['acessos'])) { ?>
                        <li>
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#producao-collapse" aria-expanded="false">
                                <i class="fs-5 bi-gear"></i><span class="ms-1 d-none d-sm-inline">Produção </span><i
                                    class="bi bi-chevron-down"></i>
                            </button>
                            <div class="collapse" id="producao-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <?php if (in_array(TELA_PRODUCAO_ORDEMDEPRODUCAO, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "ordem_producao" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Ordens de
                                                    Produção</strong></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(TELA_PRODUCAO_PEDIDOSORDENS, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "ordem_producao/pedidos_ordens_producao" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Pedidos e Ordens de
                                                    Produção</strong></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(TELA_PRODUCAO_POSICOESORDEM, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "posicao_op" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Posições Ordem
                                                    Produção</strong></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </li>
                    <?php } ?>
                    <li>
                        <?php if (in_array(TELA_ESTOQUE, $_SESSION['acessos'])) { ?>
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#estoque-collapse" aria-expanded="false">
                                <i class="fs-5 bi-box"></i><span class="ms-1 d-none d-sm-inline">Estoque </span><i
                                    class="bi bi-chevron-down"></i>
                            </button>
                            <div class="collapse" id="estoque-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <?php if (in_array(TELA_ESTOQUE_CONSULTA, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "produtos/consultaEstoque" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Consulta estoque</strong></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(TELA_ESTOQUE_RESERVAS, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "reserva" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Reservas de
                                                    estoque</strong></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(TELA_ESTOQUE_RESERVASPORPEDIDO, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "Reserva/pesquisar" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Reservas por
                                                    pedido</strong></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(TELA_ESTOQUE_MOVIMENTACOES, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "Movimentacao_estoque" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Movimentações</strong></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(TELA_ESTOQUE_MOVIMENTACAOMANUAL, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "Movimentacao_estoque/MovimentacaoManual" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Movimentação manual de
                                                    estoque</strong></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </li>
                    <!--<li>
                  <a href="#" class="nav-link text-truncate text-dark">
                    <i class="fs-5 bi-box"></i><span class="ms-1 d-none d-sm-inline">Estoque</span></a>
                </li>-->
                    <li>
                        <?php if (in_array(TELA_USUARIOS, $_SESSION['acessos'])) { ?>
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#usuario-collapse" aria-expanded="false">
                                <i class="fs-5 bi-people"></i><span class="ms-1 d-none d-sm-inline">Usuários </span><i
                                    class="bi bi-chevron-down"></i>
                            </button>
                            <div class="collapse" id="usuario-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <?php if (in_array(TELA_USUARIOS_REPRESENTANTES, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "user/representantes" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Representantes</strong></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(TELA_USUARIOS_CLIENTES, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "user/clientes" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Clientes</strong></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(TELA_USUARIOS_COLABORADORES, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "user/colaboradores" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Colaboradores</strong></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </li>
                    <li>
                        <?php if (in_array(TELA_PRODUTOS, $_SESSION['acessos'])) { ?>
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                                data-bs-target="#produto-collapse" aria-expanded="false">
                                <i class="fs-5 bi-grid"></i><span class="ms-1 d-none d-sm-inline">Serviços </span><i
                                    class="bi bi-chevron-down"></i>
                            </button>
                            <div class="collapse" id="produto-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <?php if (in_array(TELA_PRODUTOS_PRODUTOS, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "Produtos" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Serviços</strong></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(TELA_PRODUTOS_INSUMOS, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "Produtos/insumos" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Insumos</strong></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(TELA_PRODUTOS_COMPOSICAOPADRAO, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "Composicao/padrao" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Composições
                                                    padrão</strong></a></li>
                                    <?php } ?>
                                    <?php if (in_array(TELA_PRODUTOS_TABELADEPRECO, $_SESSION['acessos'])) { ?>
                                        <li><a href="<?php echo URL_BASE . "Tabela_preco" ?>"
                                                class="nav-link link-dark text-truncate text"><strong>Tabela de preço</strong></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </li>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function () {
        // Verifica se o estado do sidebar está armazenado no localStorage
        var sidebarState = localStorage.getItem('sidebarState');
        console.log(sidebarState);
        // Verifica o tamanho da tela ao carregar a página

        if (sidebarState === null) {
            if ($(window).width() < 768) {
                $('#sidebar').collapse('hide');
                menuIcon.classList.add('bi-chevron-right');
            } else {
                $('#sidebar').collapse('show');
            }
        } else {
            // Caso contrário, aplica o estado armazenado
            if (sidebarState === 'hidden') {
                $('#sidebar').collapse('hide');
                menuIcon.classList.add('bi-chevron-right');
            } else {
                $('#sidebar').collapse('show');
            }
        }

        // Salva o estado do sidebar no localStorage quando o usuário o oculta/mostra
        $('#sidebar').on('hidden.bs.collapse', function () {
            localStorage.setItem('sidebarState', 'hidden');
        });

        $('#sidebar').on('shown.bs.collapse', function () {
            localStorage.setItem('sidebarState', 'shown');
        });
    })
</script>