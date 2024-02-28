<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\RecebimentosService;
use app\core\Flash;
use app\models\service\Service;
use app\enums\StatusRecebimento;
use app\models\service\MatriculasService;
use app\models\service\LoginService;

class RecebimentosController extends Controller
{
    private $tabela = "recebimentos";
    private $campo = "recebimentos_id";
    private $usuario;

    //verifica se tem usuario logado(somente para telas que exigem)
    /*public function __construct()
    {
        $this->usuario = UtilService::getUsuario();
        if (!$this->usuario) {
            $this->redirect(URL_BASE  . "login");
            exit;
        }
    }*/

    public function index()
    {
        $dados["recebimentos"] = Service::lista($this->tabela);
        $dados["view"] = "Recebimentos/Show";
        $this->load("templateBootstrap", $dados);
    }

    public function aprove()
    {
        ob_start();
        $body = json_decode(file_get_contents("php://input"));
        if (isset($body->token)) {
            $resposta = RecebimentosService::aprove($body);

            echo $resposta;
            ob_end_flush();
            ob_start();
            $responseObj = json_decode($resposta);
            $recebimento = Service::get('recebimentos', 'recebimentos_id', $body->external_reference);

            $emailComprador = $body->payer->email;
            //se não esta logado verifica se o email da compra tem login e loga
            if (!isset($_SESSION['id'])) {
                $retornoUsusario = LoginService::loginPorEmail($emailComprador, 'aluno');
            }
            
            if ($responseObj->status == 'approved') {
                //aprova recebimento
                $recebimentos = new \stdClass();
                $recebimentos->recebimentos_id = $body->external_reference;
                $recebimentos->recebimento_status = StatusRecebimento::Aprovado->value;
                $recebimentos->recebimento_data_liberacao = date('Y-m-d H:i:s');
                $recebimentos->metodo = $body->payment_method_id;
                $recebimentos->id_mercado_pago = $responseObj->id;
                $recebimentos->email = $emailComprador;
                $recebimentos->usuarios_id = $_SESSION['id'];
                RecebimentosService::atualizaStatus($recebimentos, $this->campo, $this->tabela);

                //cria matricula
                $matriculas = new \stdClass();
                $matriculas->matriculas_id = 0;
                $matriculas->usuarios_id = $_SESSION['id'];
                $matriculas->cursos_id = $recebimento->cursos_id;
                $matriculas->recebimentos_id = $body->external_reference;
                MatriculasService::salvar($matriculas, 'matriculas_id', 'matriculas');                

                //manda email confirmando a compra
                $curso = Service::get('cursos', 'cursos_id', $recebimento->cursos_id);
                $usuario = Service::get('usuarios','usuarios_id',$_SESSION['id']);
                $titulo = "Sua Jornada de Aprendizado no $curso->nome Começa Agora";
                $mensagem = "
                    <!DOCTYPE html>
                    <html lang='pt'>
                    <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Bem-vindo ao Curso</title>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 20px auto; padding: 20px; }
                        .btn { display: inline-block; background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
                        .footer { margin-top: 20px; font-size: 0.9em; text-align: center; color: #666; }
                    </style>
                    </head>
                    <body>
                    <div class='container'>
                        <h2>Bem-vindo ao $curso->nome!</h2>
                        <p>Olá,</p>
                        <p>Estamos muito felizes por você ter escolhido nosso curso. Agradecemos pela confiança e estamos ansiosos para ajudá-lo(a) a alcançar seus objetivos.</p>
                        <p>Este curso foi cuidadosamente preparado para oferecer a melhor experiência de aprendizado. Você encontrará uma combinação de teoria, prática e atividades interativas que foram projetadas para enriquecer seu conhecimento e habilidades.</p>
                        <p>Para começar, clique no link abaixo para acessar o curso:</p>
                        <p><a href='". URL_BASE . "Cursos/" . $recebimento->cursos_id. "' class='btn'>Acessar o Curso</a></p>
                        <p>Se tiver alguma dúvida ou precisar de ajuda, não hesite em entrar em contato conosco. Estamos aqui para apoiá-lo(a) em sua jornada de aprendizado.</p>
                        <p>Atenciosamente,</p>
                        <p>Cursoswill</p>
                        <div class='footer'>
                            <p>© 2024 Cursoswill. Todos os direitos reservados.</p>
                        </div>
                    </div>
                    </body>
                    </html>
                    ";
                Service::email($usuario->email, $titulo, $mensagem, 'boasvindas@cursoswill.site','boasvindas@cursoswill.site' );
                Flash::limpaMsg();
            }

            ob_end_clean();
        }
    }

    public function adiquirirCurso($id_curso)
    {
        $usuario = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

        $curso = Service::get('cursos', 'cursos_id', $id_curso);

        $recebimentos = new \stdClass();
        $recebimentos->recebimentos_id = 0;
        $recebimentos->usuarios_id = $usuario;
        $recebimentos->cursos_id = $id_curso;
        $recebimentos->valor = $curso->preco;
        $recebimentos->recebimento_status = StatusRecebimento::Criado->value;

        $recebimentos_id = RecebimentosService::salvar($recebimentos, $this->campo, $this->tabela);
        if ($recebimentos_id > 1) //se é maior que um inseriu novo 
        {
            flash::limpaMsg();
            $this->redirect(URL_BASE . "Recebimentos/curso/" . $recebimentos_id);
        } else {
            if (isset($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                header(URL_BASE);
            }
        }
    }

    public function success()
    {
    }
    public function pending()
    {
    }
    public function failure()
    {
    }
    public function notify()
    {
    }
    public function curso($recebimentos_id)
    {

        $recebimento = Service::get('recebimentos', 'recebimentos_id', $recebimentos_id);

        $dados["curso"] = Service::get('cursos', 'cursos_id', $recebimento->cursos_id);

        $preferences = new \stdClass();
        $preferences->external_reference = $recebimentos_id;
        $preferences->amount = $recebimento->valor;
        $preferencesData = RecebimentosService::preferences($preferences);

        $dados["preference_id"] = $preferencesData->id;
        $dados["preference"] = $preferencesData;
        $dados["preco"] = $recebimento->valor;
        $dados["recebimento"] = $recebimento;
        $dados["view"] = "Recebimentos/Curso";
        $this->load("templateBootstrap", $dados);
    }

    public function edit($id)
    {
        $dados["recebimentos"] = Service::get($this->tabela, $this->campo, $id);
        $dados["view"] = "Recebimentos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function create()
    {
        $dados["recebimentos"] = Flash::getForm();
        $dados["view"] = "Recebimentos/Edit";
        $this->load("templateBootstrap", $dados);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $csrfToken = $_POST['csrf_token'];
            if ($csrfToken === $_SESSION['csrf_token']) {
                $id = $_POST['id'];
                RecebimentosService::excluir($this->tabela, $this->campo, $id);
            }
        }
    }

    public function save()
    {
        $csrfToken = $_POST['csrf_token'];
        if ($csrfToken === $_SESSION['csrf_token']) {

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $recebimentos = new \stdClass();
                if (isset($_POST["recebimentos_id"]) && is_numeric($_POST["recebimentos_id"]) && $_POST["recebimentos_id"] > 0) {
                    $recebimentos->recebimentos_id = $_POST["recebimentos_id"];
                } else {
                    $recebimentos->recebimentos_id = 0;
                }
                if (isset($_POST["usuarios_id"]))
                    $recebimentos->usuarios_id = $_POST["usuarios_id"];
                if (isset($_POST["cursos_id"]))
                    $recebimentos->cursos_id = $_POST["cursos_id"];
                if (isset($_POST["valor"]))
                    $recebimentos->valor = $_POST["valor"];
                if (isset($_POST["metodo"]))
                    $recebimentos->metodo = $_POST["metodo"];
                if (isset($_POST["transacao_id"]))
                    $recebimentos->transacao_id = $_POST["transacao_id"];
                if (isset($_POST["recebimento_data"]))
                    $recebimentos->recebimento_data = $_POST["recebimento_data"];
                if (isset($_POST["recebimento_status"]))
                    $recebimentos->recebimento_status = $_POST["recebimento_status"];
                if (isset($_POST["recebimento_data_liberacao"]))
                    $recebimentos->recebimento_data_liberacao = $_POST["recebimento_data_liberacao"];


            }


            Flash::setForm($recebimentos);
            if (RecebimentosService::salvar($recebimentos, $this->campo, $this->tabela) > 1) //se é maior que um inseriu novo 
            {
                $this->redirect(URL_BASE . "Recebimentos");
            } else {
                if (!$recebimentos->recebimentos_id) {
                    $this->redirect(URL_BASE . "Recebimentos/create");
                } else {
                    $this->redirect(URL_BASE . "Recebimentos/edit/" . $recebimentos->recebimentos_id);
                }
            }
        }
    }

}
