<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\ComposicaoService;
use app\core\Flash;
use app\models\service\Service;

class ComposicaoController extends Controller
{
    private $tabela = "composicao";
    private $campo = "composicao_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        $this->usuario = UtilService::getUsuario();
        if (!$this->usuario) {
            $this->redirect(URL_BASE . "login");
            exit;
        }
    }

    public function show($produtos_id)
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["produto"] = Service::get('produtos', 'produtos_id', $produtos_id);
        $dados["composicao_padrao"] = Service::get('composicao', 'composicao_pai_id', -1, true, 'asc');
        $dados["composicaototal"] = ComposicaoService::composicao($produtos_id);
        $dados["composicao"] = Service::get('vw_composicao', 'produtos_id', $produtos_id, true, 'asc');
        $dados["composicao_tipo"] = Service::lista('composicao_tipo');
        $dados["view"] = "Composicao/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function showMapa($produtos_id)
    {
        $dados["composicao_tipo"] = Service::lista('composicao_tipo');
        $dados["composicao_padrao"] = Service::get('composicao', 'composicao_pai_id', -1, true, 'asc');
        $dados["posicoes_op"] = Service::lista('posicao_op');
        $dados["insumos"] = Service::get('produtos', 'he_produto_insumo', '1', true);
        $dados["produto"] = Service::get('produtos', 'produtos_id', $produtos_id);
        $dados["produtos_id"] = $produtos_id;
        $dados["view"] = "Composicao/Mapa";
        $this->load("templateBootstrap", $dados);
    }

    public function padrao()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["composicao"] = Service::get('vw_composicao', 'composicao_pai_id', -1, true, 'desc');
        $dados["view"] = "Composicao/Padrao_show";
        $this->load("templateBootstrap", $dados);
    }

    public function padrao_item($composicao_referencia)
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["composicao"] = ComposicaoService::composicoesDeUmaComposicao($composicao_referencia);
        $dados["composicaototal"] = ComposicaoService::composicao($composicao_referencia);
        $dados["composicao_referencia"] = $composicao_referencia;
        $dados["composicao_tipo"] = Service::lista('composicao_tipo');
        $dados["view"] = "Composicao/Show";
        $this->load("templateBootstrap", $dados);

    }

    public function copia($composicao_id)
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $arrayOriginal = ComposicaoService::composicoesDeUmaComposicao($composicao_id);
        // Mapeamento entre composicao_id originais e novos composicao_id
        $mapaComposicaoId = [];

        // Nova cópia do array
        $novaCopiaArray = [];

        // Função para criar cópia dos itens recursivamente
        function criarCopiaRecursiva($item, &$mapaComposicaoId, &$novaCopiaArray, $composicaoService)
        { 
            
            $composicao = new \stdClass();
            $composicao->composicao_id = 0;
            $composicao->composicao_nome = $item->composicao_nome;
            $composicao->composicao_tipo_id = $item->composicao_tipo_id;
            $composicao->produtos_id = $item->produtos_id;
            $composicao->composicao_formula = $item->composicao_formula;
            $composicao->composicao_padrao_id = $item->composicao_padrao_id;
            $composicao->ajuda_texto = $item->ajuda_texto;
            $composicao->composicao_ordem = $item->composicao_ordem;
            $composicao->composicao_obrigatoria = $item->composicao_obrigatoria;
            $composicao->composicao_op_posicao = $item->composicao_op_posicao;
            $composicao->composicao_op_formula = $item->composicao_op_formula;
            $composicao->insumo = $item->insumo;
            $composicao->quantidade_insumo = $item->quantidade_insumo;

            if ($item->composicao_pai_id !== -1) {
                $composicao->composicao_pai_id = $mapaComposicaoId[$item->composicao_pai_id];
            } else {
                $composicao->composicao_nome = 'copia - ' . $item->composicao_nome;
                $composicao->composicao_pai_id = -1;
            }

            $novoId = $composicaoService->salvar($composicao, "composicao_id", "composicao");

            $mapaComposicaoId[$item->composicao_id] = $novoId;

            $novoItem = clone $item;
            $novoItem->composicao_id = $novoId;

            if ($novoItem->composicao_pai_id !== -1) {
                $novoItem->composicao_pai_id = $mapaComposicaoId[$novoItem->composicao_pai_id];
            }
            $novaCopiaArray[] = $novoItem;
        }

        $composicaoService = new ComposicaoService();

        foreach ($arrayOriginal as $item) {
            criarCopiaRecursiva($item, $mapaComposicaoId, $novaCopiaArray, $composicaoService);
        }


        $this->redirect(URL_BASE . "/Composicao/padrao");
    }

    public function edit($id, $composicao_referencia = 0)
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["composicao_padrao"] = Service::get('composicao', 'composicao_pai_id', -1, true, 'asc');
        $dados["composicao"] = Service::get($this->tabela, $this->campo, $id);
        $dados["composicao_pai"] = Service::get($this->tabela, $this->campo, $dados["composicao"]->composicao_pai_id);
        $dados["composicao_tipo"] = Service::lista('composicao_tipo');
        //$dados["produtos"] = Service::lista('produtos');
        $dados["insumos"] = Service::get('produtos', 'he_produto_insumo', '1', true);
        $dados["composicao_referencia"] = $composicao_referencia;
        $dados["posicoes_op"] = Service::lista('posicao_op');
       
        $dados["view"] = "Composicao/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create($produtos_id, $composicao_pai_id = null, $composicao_referencia = null)
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["composicao_padrao"] = Service::get('composicao', 'composicao_pai_id', -1, true, 'asc');
        $dados["produtos_id"] = $produtos_id;
        $dados["composicao_pai_id"] = $composicao_pai_id;
        $dados["composicao_referencia"] = $composicao_referencia;
        $dados["composicao"] = Flash::getForm();
        $dados["composicao_tipo"] = Service::lista('composicao_tipo');
        $dados["posicoes_op"] = Service::lista('posicao_op');
        $dados["produtos"] = Service::lista('produtos');
        $dados["insumos"] = Service::get('produtos', 'he_produto_insumo', '1', true);
        $dados["view"] = "Composicao/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function composicaoProduto($id)
    {
        echo json_encode(ComposicaoService::composicao($id));
        //echo json_encode(Service::get('composicao', 'produtos_id', $id, true, 'asc'));
    }

    public function delete()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];

                // Excluir a imagem, se existir               
                $existe_imagem = service::get($this->tabela, $this->campo, $id);
                if (isset($existe_imagem->ajuda_imagem) && $existe_imagem->ajuda_imagem != '') {
                    UtilService::deletarImagens($existe_imagem->ajuda_imagem);
                }
                ComposicaoService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {

            if (isset($_POST["composicao_referencia"]))
                $composicao_referencia = $_POST["composicao_referencia"];

            $composicao = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["composicao_id"]) && is_numeric($_POST["composicao_id"]) && $_POST["composicao_id"] > 0) {
                    $composicao->composicao_id = $_POST["composicao_id"];
                } else {
                    $composicao->composicao_id = 0;
                }
                if (isset($_POST["composicao_nome"]))
                    $composicao->composicao_nome = $_POST["composicao_nome"];
                if (isset($_POST["composicao_tipo_id"]))
                    $composicao->composicao_tipo_id = $_POST["composicao_tipo_id"];

                if (isset($_POST["composicao_pai_id"]) && is_numeric($_POST["composicao_pai_id"])) {
                    $composicao->composicao_pai_id = $_POST["composicao_pai_id"];
                } else {
                    $composicao->composicao_pai_id = 0;
                }
                if (isset($_POST["produtos_id"]))
                    $composicao->produtos_id = $_POST["produtos_id"];
                if (isset($_POST["composicao_formula"]))
                    $composicao->composicao_formula = $_POST["composicao_formula"];
                if (isset($_POST["composicao_padrao_id"]))
                    $composicao->composicao_padrao_id = $_POST["composicao_padrao_id"];

                if (isset($_POST["ajuda_texto"]))
                    $composicao->ajuda_texto = $_POST["ajuda_texto"];

                if (isset($_POST["composicao_ordem"])) {
                    $composicao->composicao_ordem = $_POST["composicao_ordem"];
                } else {
                    $composicao->composicao_ordem = 0;
                }

                $composicao->composicao_obrigatoria = (isset($_POST["composicao_obrigatoria"])) ? 1 : 0;

                if (isset($_POST["composicao_op_posicao"]))
                    $composicao->composicao_op_posicao = $_POST["composicao_op_posicao"];
                if (isset($_POST["composicao_op_formula"]))
                    $composicao->composicao_op_formula = $_POST["composicao_op_formula"];
                if (isset($_POST["insumo"]))
                    $composicao->insumo = $_POST["insumo"];
                if (isset($_POST["quantidade_insumo"]))
                    $composicao->quantidade_insumo = $_POST["quantidade_insumo"];

            }
            Flash::setForm($composicao);
            if (ComposicaoService::salvar($composicao, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                if ($composicao->produtos_id == -1) {
                    $this->redirect(URL_BASE . "Composicao/padrao_item/" . $composicao_referencia);
                } else {
                    $this->redirect(URL_BASE . "Composicao/show/" . $composicao->produtos_id);
                }
            } else {
                if (!$composicao->composicao_id) {
                    $this->redirect(URL_BASE . "Composicao/create");
                } else if ((isset($composicao_referencia) && ($composicao_referencia > 0))) {
                    $this->redirect(URL_BASE . "Composicao/edit/" . $composicao->composicao_id . "/" . $composicao_referencia);
                } else {
                    $this->redirect(URL_BASE . "Composicao/edit/" . $composicao->composicao_id);
                }
            }
        }
    }

}
