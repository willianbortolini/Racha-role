<?php

namespace Usuario_tipoControllerTest;
//define('app\util\URL_BASE', 'http://example.com');
//define('app\core\DOCKER_CONTAINER', 'false');
require_once 'config/config.php';
use PHPUnit\Framework\TestCase;
use app\models\dao\Usuario_tipoDao;
use app\models\validacao\Usuario_tipoValidacao;
use app\util\UtilService;
use app\models\service\Service;

use GuzzleHttp\Client;
session_start();
class Usuario_tipoControllerTest extends TestCase
{
    /*public function testRespostaDaUrl()
    {
        // Crie uma instância do cliente Guzzle
        $client = new Client();

        // Faça a requisição para a URL do seu site
        $response = $client->get('http://localhost');

        // Verifique o código de status da resposta
        $this->assertEquals(200, $response->getStatusCode());
        // Verifique o conteúdo da resposta
        $conteudoEsperado = "d-flex flex-column min-vh-100";
        $this->assertStringContainsString($conteudoEsperado, (string) $response->getBody());
    }*/

   /* public function testUsuariosComTipo()
    {
        
        $_SESSION['id'] = 2;
        // Teste do método usuariosComTipo
        $result = Usuario_tipoService::usuariosComTipo(REPRESENTANTE);
        // Verifica se o resultado é igual à lista de usuários simulada
        $this->assertNotEmpty($result);
    }*/
}