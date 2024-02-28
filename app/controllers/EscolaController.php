<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\models\service\UsuarioService;
use app\models\service\EscolaService;
use app\models\service\Cliente_cursoService;
use app\util\UtilService;

//use app\models\service\LoginService;

class EscolaController extends Controller
{

    private $tabela = "usuarios";
    private $campo = "id_usuario";
    private $usuario;
    public function __construct()
    {
        $this->usuario = UtilService::getUsuario();
        if (!$this->usuario) {
            $this->redirect(URL_BASE . "login");
            exit;
        }
    }

    public function index()
    {
        $dados["cursos"] = EscolaService::meusCursos($_SESSION[SESSION_LOGIN]->id_usuario);
        $dados["aulasAssistidas"] = EscolaService::aulas_assistidas();
        $dados["view"] = "Escola/Index";
        $this->load("Escola/templateescola", $dados);
    }

    public function dashboard()
    {
        /*if ($_SESSION['nivel'] <> 10) {
            $this->redirect(URL_BASE . "escola");
            exit();
        }*/
        $dados["ultimosCadastrados"] = EscolaService::ultimosCadastrados();
        $dados["comentarios"] = EscolaService::comentariosResponder();
        $dados["recentes"] = EscolaService::acessosRecentes();
        $dados["cursos"] = Service::lista("curso");
        $dados["view"] = "Escola/dashboard";
        $this->load("Escola/templateescola", $dados);
    }

    public function criarCurso($curso_id, $aula_id = 0)
    {
        /*if ($_SESSION['nivel'] <> 10) { 
            $this->redirect(URL_BASE . "escola");
            exit();
        }*/
        $dados["aulas"] = EscolaService::aulasCapitulo($curso_id);
        $dados["pergunta"] = Service::getSemEmpresa("pergunta", "aula_id", $aula_id);
        $dados["opcoes"] = Service::getSemEmpresa("pergunta_opcao", "id_pergunta", $dados["pergunta"]->id_pergunta, true);
        $dados["dowloads"] = Service::getSemEmpresa("download", "aula_id", $aula_id, true);
        $dados["curso_id"] = $curso_id;
        $dados["aulaIn"] = Service::getSemEmpresa("aula", "aula_id", $aula_id);
        $dados["view"] = "Escola/curso_create";
        $this->load("Escola/templateescola", $dados);
    }

    public function adicionaCapitulo($curso_id)
    {
        $capitulo = new \stdClass();
        $capitulo->curso_id = $curso_id;
        $capitulo->titulo_capitulo = "novo capitulo";

        $erros = [];
        $capitulo_id = Service::salvar($capitulo, "capitulo_id", $erros, "capitulo");
        $novoCapitulo = Service::getSemEmpresa("capitulo", "capitulo_id", $capitulo_id);

        //nova aula
        $aula = new \stdClass();
        $aula->capitulo_id = $capitulo_id;
        $aula->curso_id = $curso_id;
        $aula->ordem_aula = 1;
        $aula->aula = "aula nova";
        $aula_id = Service::salvar($aula, "aula_id", $erros, "aula");

        $this->redirect(URL_BASE . "escola/criarCurso/" . $curso_id);
    }

    public function adicionaAula($curso_id, $capitulo_id)
    {

        //nova aula
        $aula = new \stdClass();
        $aula->capitulo_id = $capitulo_id;
        $aula->curso_id = $curso_id;
        $aula->ordem_aula = EscolaService::proximaOrdemAula($capitulo_id, $curso_id);
        $aula->aula = "aula nova";
        $erros = [];
        $aula_id = Service::salvar($aula, "aula_id", $erros, "aula");

        $this->redirect(URL_BASE . "escola/criarCurso/" . $curso_id);
    }

    public function adicionaDownload($curso_id, $aula_id)
    {

        //nova aula
        $download = new \stdClass();
        $download->aula_id = $aula_id;
        $erros = [];
        Service::salvar($download, "id_download", $erros, "download");

        $this->redirect(URL_BASE . "escola/criarCurso/" . $curso_id . "/" . $aula_id);
    }

    public function excluiDownload($id_download, $curso_id, $aula_id)
    {
        Service::excluir("download", "id_download", $id_download);
        $this->redirect(URL_BASE . "escola/criarCurso/" . $curso_id . "/" . $aula_id);
    }

    public function excluiPergunta($id_pergunta, $curso_id, $aula_id)
    {
        Service::excluir("pergunta", "id_pergunta", $id_pergunta);
        Service::excluir("pergunta_opcao", "id_pergunta", $id_pergunta);
        $this->redirect(URL_BASE . "escola/criarCurso/" . $curso_id . "/" . $aula_id);
    }

    public function salvarAula()
    {

        $erros = [];

        $opcao1 = new \stdClass();
        $opcao1->id_pergunta_opcao = $_POST["id_pergunta_opcao1"];
        $opcao1->opcao = $_POST["opcao1"];
        $opcao1->correta = ($_POST["opcaoCorreta"] == $_POST["id_pergunta_opcao1"]) ? 1 : 0;

        Service::salvar($opcao1, "id_pergunta_opcao", $erros, "pergunta_opcao");

        $opcao2 = new \stdClass();
        $opcao2->id_pergunta_opcao = $_POST["id_pergunta_opcao2"];
        $opcao2->opcao = $_POST["opcao2"];
        $opcao2->correta = ($_POST["opcaoCorreta"] == $_POST["id_pergunta_opcao2"]) ? 1 : 0;
        Service::salvar($opcao2, "id_pergunta_opcao", $erros, "pergunta_opcao");

        $opcao3 = new \stdClass();
        $opcao3->id_pergunta_opcao = $_POST["id_pergunta_opcao3"];
        $opcao3->opcao = $_POST["opcao3"];
        $opcao3->correta = ($_POST["opcaoCorreta"] == $_POST["id_pergunta_opcao3"]) ? 1 : 0;
        Service::salvar($opcao3, "id_pergunta_opcao", $erros, "pergunta_opcao");

        $opcao4 = new \stdClass();
        $opcao4->id_pergunta_opcao = $_POST["id_pergunta_opcao4"];
        $opcao4->opcao = $_POST["opcao4"];
        $opcao4->correta = ($_POST["opcaoCorreta"] == $_POST["id_pergunta_opcao4"]) ? 1 : 0;
        Service::salvar($opcao4, "id_pergunta_opcao", $erros, "pergunta_opcao");

        $pergunta = new \stdClass();
        $pergunta->id_pergunta = $_POST["id_pergunta"];
        $pergunta->pergunta = $_POST["pergunta"];
        Service::salvar($pergunta, "id_pergunta", $erros, "pergunta");


        $aula = new \stdClass();
        $aula->aula_id = $_POST["aula_id"];
        $aula->curso_id = $_POST["curso_id"];
        $aula->aula = $_POST["titulo_aula"];
        $aula->embed = $_POST["embed"];
        $aula->duracao_aula = $_POST["duracao"];
        $aula->ordem_aula = $_POST["ordem"];

        Service::salvar($aula, "aula_id", $erros, "aula");

        $download1 = new \stdClass();
        $download1->titulo_download = $_POST["titulo_dowload1"];
        $download1->path = $_POST["link_dowload1"];
        $download1->id_download = $_POST["id_download1"];
        Service::salvar($download1, "id_download", $erros, "download");

        $download2 = new \stdClass();
        $download2->titulo_download = $_POST["titulo_dowload2"];
        $download2->path = $_POST["link_dowload2"];
        $download2->id_download = $_POST["id_download2"];
        Service::salvar($download2, "id_download", $erros, "download");

        $download3 = new \stdClass();
        $download3->titulo_download = $_POST["titulo_dowload3"];
        $download3->path = $_POST["link_dowload3"];
        $download3->id_download = $_POST["id_download3"];
        Service::salvar($download3, "id_download", $erros, "download");

        $download4 = new \stdClass();
        $download4->titulo_download = $_POST["titulo_dowload4"];
        $download4->path = $_POST["link_dowload4"];
        $download4->id_download = $_POST["id_download4"];
        Service::salvar($download4, "id_download", $erros, "download");

        $this->redirect(URL_BASE . "escola/criarCurso/" . $aula->curso_id . "/" . $aula->aula_id);
    }

    public function adicionaPergunta($curso_id, $aula_id)
    {

        //nova aula
        $pergunta = new \stdClass();
        $pergunta->aula_id = $aula_id;
        $pergunta->pergunta = "Digite aqui a pergunta";
        $erros = [];
        $id_pergunta = Service::salvar($pergunta, "id_pergunta", $erros, "pergunta");

        for ($i = 1; $i <= 4; $i++) {
            $resposta = new \stdClass();
            $resposta->id_pergunta = $id_pergunta;
            $resposta->opcao = "opção " . $i;
            Service::salvar($resposta, "id_pergunta_opcao", $erros, "pergunta_opcao");
        }
        $this->redirect(URL_BASE . "escola/criarCurso/" . $curso_id . "/" . $aula_id);
    }

    public function salvarResposta()
    {
        $resposta = new \stdClass();
        $resposta->resposta = $_POST["resposta"];
        $resposta->aula_id = $_POST["aula_id"];
        $resposta->id_comentario = $_POST["id_comentario"];
        $resposta->id_usuario = $_POST["id_usuario"];
        $resposta->data_resposta = dataHoraSP();
        $erros = [];
        service::salvar($resposta, "id_resposta", $erros, "resposta");
        $this->redirect(URL_BASE . "escola/dashboard");
    }

    public function salvarPergunta()
    {
        $resposta = new \stdClass();
        $resposta->id_pergunta = $_POST["id_pergunta"];
        $resposta->id_pergunta_opcao = $_POST["resposta"];
        $resposta->id_usuario = $_SESSION[SESSION_LOGIN]->id_usuario;

        if (EscolaService::jaRespondeu($resposta->id_pergunta) > 0) {
            $this->redirect(URL_BASE . "escola/aula/" . $_POST["aula_id"]);
        } else {
            $erros = [];
            service::salvar($resposta, "id_pergunta_cliente", $erros, "pergunta_cliente");
            $this->redirect(URL_BASE . "escola/aula/" . $_POST["aula_id"]);
        }
    }

    public function compra_aguardando($curso)
    {
        $usuario = new \stdClass();
        $usuario->curso_id = $curso;
        $usuario->id_usuario = $_SESSION[SESSION_LOGIN]->id_usuario;
        $usuario->data_compra = dataHoraSP();
        $erros = [];
        service::salvar($usuario, "id_usuario_aguardando", $erros, "cliente_aguardando");
        $dados["view"] = "Escola/compra_aguardando";
        $this->load("Escola/templateescola", $dados);
    }

    public function compra_ok($curso)
    {
        EscolaService::compraCurso($curso);
        $this->redirect(URL_BASE . "escola/curso/" . $curso);
    }

    public function meuscursos()
    {
        $dados["cursos"] = EscolaService::todosCursos($_SESSION[SESSION_LOGIN]->id_usuario);
        $dados["view"] = "Escola/meus_cursos";
        $this->load("Escola/templateescola", $dados);
    }

    public function perfil()
    {
        $id = $_SESSION[SESSION_LOGIN]->id_usuario;
        $dados["usuario"] = Service::getSemEmpresa("usuarios", "id_usuario", $id);
        $dados["view"] = "Escola/perfil";
        $this->load("Escola/templateescola", $dados);
    }

    public function editar()
    {
        $id = $_SESSION[SESSION_LOGIN]->id_usuario;
        $dados["usuario"] = Service::getSemEmpresa("usuarios", "id_usuario", $id);
        $dados["editando"] = true;
        $dados["view"] = "Escola/perfil";
        $this->load("Escola/templateescola", $dados);
    }

    public function comentario()
    {
        $dados["comentarios"] = EscolaService::comentario();
        $dados["view"] = "Escola/comentario";
        $this->load("Escola/templateescola", $dados);
    } 

    public function salvarComentario($aula)
    {
        $comentario = new \stdClass();
        $comentario->id_usuario = $_SESSION[SESSION_LOGIN]->id_usuario;
        $comentario->comentario = $_POST["comentario"];
        $comentario->aula_id = $aula;
        $comentario->curso_id = Service::getSemEmpresa("aula", "aula_id", $aula)->curso_id;
        $comentario->data_comentario = dataHoraSP();
        $erros = [];
        Service::salvar($comentario, "id_comentario", $erros, "comentario");
        $this->redirect(URL_BASE . "escola/aula/" . $aula);
    }

    public function aula($aula)
    {
        $temAula = Cliente_cursoService::verificaCursandoAula($aula);
        if ($temAula == true) {
            
            $dados["aula"] = Service::getSemEmpresa("aula", "aula_id", $aula);
            $dados["curso"] = Service::getSemEmpresa("curso", "curso_id", $dados["aula"]->curso_id);
            $dados["capitulo"] = Service::getSemEmpresa("capitulo", "capitulo_id", $dados["aula"]->capitulo_id);
            $dados["aulas"] = EscolaService::aulasCapitulo($dados["aula"]->curso_id);
            $dados["proximaAula"] = EscolaService::proxima_aula($dados["aula"]->ordem_aula, $dados["aula"]->curso_id);
            $dados["aulaAnterior"] = EscolaService::aulaAnterior($dados["aula"]->ordem_aula, $dados["aula"]->curso_id);
            $dados["dowloads"] = Service::getSemEmpresa("download", "aula_id", $aula, true);
            $dados["ultimaAulaAssistida"] = EscolaService::ultimaAulaAssistida($dados["aula"]->curso_id);
            $dados["centConcluido"] = EscolaService::centConcluido($dados["aula"]->curso_id);
            $dados["duracaoCurso"] = EscolaService::duracaoCurso($dados["aula"]->curso_id);
            $dados["comentarios"] = EscolaService::comentarioAula($aula);           
            //pergunta
            $dados["pergunta"] = Service::getSemEmpresa("pergunta", "aula_id", $aula);
            $dados["opcoes"] = Service::getSemEmpresa("pergunta_opcao", "id_pergunta", $dados["pergunta"]->id_pergunta, true);
            $dados["jaRespondeu"] = EscolaService::jaRespondeu($dados["pergunta"]->id_pergunta);
            if ($dados["jaRespondeu"] > 0) {
                $dados["correta"] = EscolaService::correta($dados["pergunta"]->id_pergunta);
            }

            //se é a primeira vez que entra na aula salva  
            $dados["aulaAssistida"] = EscolaService::getAulaAssistida($_SESSION[SESSION_LOGIN]->id_usuario, $aula, $dados["aula"]->curso_id);
            if (!$dados["aulaAssistida"]) {
                $aulaassistida = new \stdClass();
                date_default_timezone_set('America/Sao_Paulo');
                $hoje = date('Y-m-d H:i:s');
                $aulaassistida->data_assistida = $hoje;
                $aulaassistida->aula_id = $aula;
                $aulaassistida->id_usuario = $_SESSION[SESSION_LOGIN]->id_usuario;
                $aulaassistida->curso_id = $dados["aula"]->curso_id;
                $validacao = [];
                Service::salvar($aulaassistida, "aula_assistida_id", $validacao, "aula_assistida");
            }
           
            $dados["view"] = "Escola/aula";
            $this->load("Escola/templateescola", $dados);
        } else {
            $this->redirect(URL_BASE . "escola/meuscursos");
        }
    }

    public function create()
    {
        $dados["usuario"] = Flash::getForm();
        $dados["view"] = "Usuario/Create";
        $this->load("template", $dados);
    }

    public function edit($id)
    {
        //$empresa = $_SESSION[SESSION_LOGIN]->id_usuario;
        $usuario = Service::get($this->tabela, $this->campo, $id);
        $dados["categoria"] = Service::lista("categoria", $empresa);
        $dados["unidade"] = Service::lista("unidade");
        if (!$usuario) {
            $this->redirect(URL_BASE . "usuario");
        }

        $dados["usuario"] = $usuario;
        $dados["view"] = "Usuario/Create";
        $this->load("template", $dados);
    }

    public function salvarusuario()
    {
        $usuario = new \stdClass();
        $usuario->id_usuario = $_SESSION[SESSION_LOGIN]->id_usuario;
        $usuario->usuario = $_POST["usuario"];
        $usuario->nome_completo = $_POST["nome_completo"];
        $usuario->email = $_POST["email"];
        $usuario->cpf = $_POST["cpf"];
        $usuario->data_nascimento = $_POST["data_nascimento"];
        $usuario->fone = $_POST["telefone"];
        $usuario->profissao = $_POST["profissao"];
        $usuario->bairro = $_POST["bairro"];
        $usuario->cidade = $_POST["cidade"];
        $usuario->rua = $_POST["rua"];
        $usuario->estado = $_POST["estado"];
        $usuario->cep = $_POST["cep"];
        $usuario->complemento = $_POST["complemento"];
        $usuario->numero = $_POST["numero"];

        Flash::setForm($usuario);

        if (UsuarioService::Editar($usuario, 'id_usuario', 'usuarios')) {
            $this->redirect(URL_BASE . "/Escola/perfil");
        } else {
            $this->redirect(URL_BASE . "/Escola/perfil");
        }
    }

    public function buscar($q)
    {
        $usuario = Service::getLike($this->tabela, "usuario", $q, true);
        echo json_encode($usuario);
    }

    public function mudaNomeAula($aula_id, $nome)
    {
        $aula = [
            "aula_id" => $aula_id,
            "aula" => $nome,
        ];
        Service::editar($aula, "aula_id", "aula");
    }

    public function mudaNomeCapitulo($capitulo_id, $nome)
    {
        $capitulo = [
            "capitulo_id" => $capitulo_id,
            "titulo_capitulo" => $nome,
        ];
        Service::editar($capitulo, "capitulo_id", "capitulo");
    }

}
