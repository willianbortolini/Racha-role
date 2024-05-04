<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Pedido_item_composicaoService;
use app\core\Flash;
use app\models\service\Service;

class Pedido_item_composicaoController extends Controller
{
    private $tabela = "pedido_item_composicao";
    private $campo = "pedido_item_composicao_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    public function __construct()
    {
        UtilService::validaUsuario();
    }

    public function index()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["pedido_item_composicao"] = Service::lista($this->tabela);
        $dados["view"] = "Pedido_item_composicao/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["pedido_item_composicao"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Pedido_item_composicao/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        UtilService::validaNivel(ADIMINISTRADOR);
        $dados["pedido_item_composicao"] = Flash::getForm();
        $dados["view"] = "Pedido_item_composicao/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];

                // Excluir a imagem, se existir               

                // Excluir
                Pedido_item_composicaoService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {
            $pedido_item_composicao = new \stdClass();
            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if (isset($_POST["pedido_item_composicao_id"]) && is_numeric($_POST["pedido_item_composicao_id"]) && $_POST["pedido_item_composicao_id"] > 0) {
                    $pedido_item_composicao->pedido_item_composicao_id = $_POST["pedido_item_composicao_id"];
                } else {
                    $pedido_item_composicao->pedido_item_composicao_id = 0;
                }
                if (isset($_POST["pedido_item_id"]))
                    $pedido_item_composicao->pedido_item_id = $_POST["pedido_item_id"];
                if (isset($_POST["composicao_id"]))
                    $pedido_item_composicao->composicao_id = $_POST["composicao_id"];
                if (isset($_POST["pedido_item_composicao_valor"]))
                    $pedido_item_composicao->pedido_item_composicao_valor = $_POST["pedido_item_composicao_valor"];
                if (isset($_POST["pedido_item_composicao_valorMonetario "]))
                    $pedido_item_composicao->pedido_item_composicao_valorMonetario = $_POST["pedido_item_composicao_valorMonetario "];
            }


            Flash::setForm($pedido_item_composicao);
            if (Pedido_item_composicaoService::salvar($pedido_item_composicao, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Pedido_item_composicao");
            } else {
                if (!$pedido_item_composicao->pedido_item_composicao_id) {
                    $this->redirect(URL_BASE . "Pedido_item_composicao/create");
                } else {
                    $this->redirect(URL_BASE . "Pedido_item_composicao/edit/" . $pedido_item_composicao->pedido_item_composicao_id);
                }
            }
        }
    }

    public function salvaJson()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // Recebe os dados do JSON enviado pelo JavaScript

            $json_data = file_get_contents("php://input");
            $data = json_decode($json_data, true);
            $erros = [];


            Pedido_item_composicaoService::excluir($this->tabela, 'pedido_item_id', $data[0]['pedido_item_id']);
            $valorTotalEnviado = $data[0]['valorTotal'];
            $l = $data[0]['largura'];
            $a = $data[0]['altura'];
            $q = $data[0]['quantidade'];
            $t = $data[0]['valorUnitarioTabel'];
            array_shift($data);

            $calorTotalCalculadoComposicao = 0;
            //valida se o valor esta certo
            foreach ($data as $item) {
                $itemComposicao = Service::get('composicao', 'composicao_id', $item['id']);

                $expressao = $itemComposicao->composicao_formula;
                $expressao = str_replace(['l', 'a', 'q', 't', 'v'], [$l, $a, $q, $t, $item['valor']], $expressao);
                $expressao = str_replace(',', '.', $expressao);

                $resultadoExpressao = eval ('return ' . $expressao . ';');

                if ($resultadoExpressao < 0) {
                    $resultadoExpressao = 0;
                }
                $calorTotalCalculadoComposicao = $calorTotalCalculadoComposicao + $resultadoExpressao;
            }

            $cortadoValue = round($calorTotalCalculadoComposicao * 100) / 100;
            $formattedValue = number_format($cortadoValue, 2, '.', '');

            if ($formattedValue != $valorTotalEnviado) {
                Flash::setMsg("Erro ao calcular o valor da composição, caso o problema persistir contate o suporte.", -1);
                echo json_encode(['success' => false, 'valorcalculado1' => $formattedValue, 'valorenviado' => $valorTotalEnviado]);
                exit;
            }

            foreach ($data as $item) {
                $pedido_item_composicao = new \stdClass();
                $pedido_item_composicao->pedido_item_id = $item['pedido_item_id'] ?? null;
                $pedido_item_composicao->composicao_id = $item['id'] ?? null;
                $pedido_item_composicao->pedido_item_composicao_valor = $item['valor'] ?? null;
                $pedido_item_composicao->pedido_item_composicao_valorMonetario = $item['valorMonetario'] ?? null;
                $pedido_item_composicao->texto = $item['texto'] ?? null;
                $pedido_item_composicao->pedido_item_composicao_id = 0;

                if (Pedido_item_composicaoService::salvar($pedido_item_composicao, $this->campo, $this->tabela) <= 1) {
                    // Se não inseriu, adiciona uma mensagem de erro ao array
                    $erros[] = 'Erro ao salvar no banco de dados';
                }
            }

            if (!empty($erros)) {
                echo json_encode(['success' => false, 'errors' => $erros]);
                exit;
            } else {
                echo json_encode(['success' => true, 'valor' => $data]);
                exit;
            }
        }
    }
}

