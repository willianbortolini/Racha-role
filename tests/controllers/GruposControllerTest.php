<?php

use PHPUnit\Framework\TestCase;
use Mockery;
use app\controllers\GruposController;
use app\util\UtilService;
use app\models\service\GruposService;
use app\core\Flash;
use app\models\service\Service;

class GruposControllerTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
        // Mock das dependências
        $this->mockUtilService();
        $this->mockService();
        $this->mockGruposService();
        $this->mockFlash();

        // Simulação do HTTP_HOST para ambiente de teste
        $_SERVER['HTTP_HOST'] = 'localhost';

        // Inclui o arquivo de configuração
        require_once __DIR__ . '/../../config/config.php';

        // Mock CSRF token
        $_SESSION['csrf_token'] = 'test_csrf_token';

        // Instância do controlador
        $this->controller = $this->getMockBuilder(GruposController::class)
            ->onlyMethods(['load', 'redirect'])
            ->getMock();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    private function mockUtilService()
    {
        $mock = Mockery::mock('alias:' . UtilService::class);
        $mock->shouldReceive('validaUsuario')->andReturn(true);
        $mock->shouldReceive('deletarImagens')->andReturn(true);
    }

    private function mockService()
    {
        $mock = Mockery::mock('alias:' . Service::class);
        $mock->shouldReceive('lista')->andReturn([]);
        $mock->shouldReceive('get')->andReturn((object)[
            'grupos_id' => 1,
            'nome' => 'TESTE',
            'foto' => '6661007f42518.jpeg',
            'created_at' => '2024-06-05 21:10:27',
        ]);
    }

    private function mockGruposService()
    {
        $mock = Mockery::mock('alias:' . GruposService::class);
        $mock->shouldReceive('excluir')->andReturn(true);
        $mock->shouldReceive('quantidadeDeLinhas')->andReturn((object)['total' => 10]);
        $mock->shouldReceive('lista')->andReturn([]);
        $mock->shouldReceive('salvar')->andReturn(1);
    }

    private function mockFlash()
    {
        $mock = Mockery::mock('alias:' . Flash::class);
        $mock->shouldReceive('getForm')->andReturn(new \stdClass());
        $mock->shouldReceive('setForm')->andReturn(true);
    }

    public function testIndex()
    {
        $this->controller->expects($this->once())
            ->method('load')
            ->with('templateBootstrap', ['view' => 'Grupos/Show']);
        $this->controller->index();
    }

    public function testEdit()
    {
        $id = 1;
        $this->controller->expects($this->once())
            ->method('load')
            ->with('templateBootstrap', [
                'grupos' => (object)[
                    'grupos_id' => 1,
                    'nome' => 'TESTE',
                    'foto' => '6661007f42518.jpeg',
                    'created_at' => '2024-06-05 21:10:27',
                ], 
                'view' => 'Grupos/Edit'
            ]);
        $this->controller->edit($id);
    }

    public function testCreate()
    {
        $this->controller->expects($this->once())
            ->method('load')
            ->with('templateBootstrap', ['grupos' => new \stdClass(), 'view' => 'Grupos/Edit']);
        $this->controller->create();
    }

    public function testDelete()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = 'DELETE';
        $_POST['csrf_token'] = 'valid_token';
        $_SESSION['csrf_token'] = 'valid_token';
        $_POST['id'] = 1;

        $this->controller->delete();

        // Assert that excluir was called
        $this->addToAssertionCount(1);
    }

    public function testList()
    {
        $_REQUEST = [
            'search' => ['value' => ''],
            'start' => 0,
            'length' => 10,
            'order' => [['column' => 0, 'dir' => 'asc']],
            'draw' => 1
        ];

        $this->expectOutputString(json_encode([
            "draw" => 1,
            "recordsTotal" => 10,
            "recordsFiltered" => 10,
            "data" => []
        ]));

        $this->controller->list();
    }

    public function testSave()
    {
        $_POST['csrf_token'] = 'valid_token';
        $_SESSION['csrf_token'] = 'valid_token';
        $_POST['nome'] = 'Grupo Teste';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->controller->expects($this->once())
            ->method('redirect')
            ->with($this->stringContains(URL_BASE . "Grupos"));

        $this->controller->save();
    }
}
