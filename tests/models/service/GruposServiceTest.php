<?php
namespace tests\models\service;

use PHPUnit\Framework\TestCase;
use app\models\service\GruposService;
use app\models\service\Service;
use app\models\validacao\GruposValidacao;
use app\util\UtilService;

class GruposServiceTest extends TestCase
{
    protected function setUp(): void
    {
        // Simulação do HTTP_HOST para ambiente de teste
        $_SERVER['HTTP_HOST'] = 'localhost';

        // Inclui o arquivo de configuração
        require_once __DIR__ . '/../../../config/config.php';
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        // Limpeza do ambiente de teste, incluindo banco de dados
        // Realize a limpeza necessária para deixar o ambiente de teste consistente
    }    

    public function testQuantidadeDeLinhas()
    {
        // Parâmetro de teste
        $valorPesquisa = 'test';

        // Chama o método que você deseja testar
        $result = GruposService::quantidadeDeLinhas($valorPesquisa);

        // Verifica se o resultado é um objeto
        $this->assertIsObject($result);

        // Verifica se o objeto contém a propriedade 'total'
        $this->assertTrue(property_exists($result, 'total'));

        // Verifica se 'total' é um número inteiro
        $this->assertIsInt($result->total);
    }

    public function testListaService()
    {
        // Parâmetros de teste
        $parametros = [
            'valor_pesquisa' => '',
            'colunaOrder' => 'grupos_id',
            'direcaoOrdenacao' => 'asc',
            'inicio' => 0,
            'quantidade' => 10
        ];

        // Chama o método que você deseja testar
        $result = GruposService::lista($parametros);

        // Verifica se o resultado é um array
        $this->assertIsArray($result);

        // Verifica se o array contém objetos
        foreach ($result as $item) {
            $this->assertIsObject($item);

            // Verifica se cada objeto contém a propriedade 'grupos_id'
            $this->assertTrue(property_exists($item, 'grupos_id'));
            $this->assertTrue(property_exists($item, 'nome'));
            $this->assertTrue(property_exists($item, 'foto'));
            $this->assertTrue(property_exists($item, 'created_at'));

        }

        // Exemplo de assert para garantir que pelo menos um resultado foi retornado
        $this->assertNotEmpty($result);
    }

    public function testSalvarComImagemRemovida()
    {
        // Mock da validação retornando array vazio
        GruposService::setValidationMock([]);

        // Configura as variáveis globais
        $_POST['remove_foto'] = '1';

        // Mock para Service::get
        $mockGrupos = (object) ['grupos_id' => 1, 'foto' => 'existing_image.jpg'];
        $this->mockStaticMethod(Service::class, 'get', $mockGrupos);

        // Mock para UtilService::deletarImagens
        $this->mockStaticMethod(UtilService::class, 'deletarImagens', 'ok');

        // Mock para Service::salvar
        $this->mockStaticMethod(Service::class, 'salvar', 1);

        $grupo = new \stdClass();
        $grupo->grupos_id = 1;

        // Chama o método salvar
        $result = GruposService::salvar($grupo);
        var_dump($result);
        // Verifica o resultado
       // $this->assertIsInt($result);
        //$this->assertGreaterThanOrEqual(-1, $result);
    }

    /*public function testSalvarComImagemUpload()
    {
        // Mock da validação retornando array vazio
        GruposService::setValidationMock([]);

        // Configura as variáveis globais
        $_FILES['foto'] = [
            'name' => 'new_image.jpg',
            'error' => UPLOAD_ERR_OK
        ];

        // Mock para Service::get
        $mockGrupos = (object) ['grupos_id' => 1, 'foto' => 'existing_image.jpg'];
        $this->mockStaticMethod(Service::class, 'get', $mockGrupos);

        // Mock para UtilService::deletarImagens
        $this->mockStaticMethod(UtilService::class, 'deletarImagens', true);

        // Mock para UtilService::uploadImagem
        $this->mockStaticMethod(UtilService::class, 'uploadImagem', 'uploaded_image.jpg');

        // Mock para Service::salvar
        $this->mockStaticMethod(Service::class, 'salvar', true);

        $grupo = new \stdClass();
        $grupo->grupos_id = 1;

        // Chama o método salvar
        $result = GruposService::salvar($grupo);

        // Verifica o resultado
        $this->assertTrue($result);
    }*/

    private function mockStaticMethod($class, $method, $returnValue)
    {
        $mock = $this->getMockBuilder($class)
                     ->disableOriginalConstructor()
                     ->onlyMethods([$method])
                     ->getMock();
        $mock->method($method)->willReturn($returnValue);
        return $mock;
    }
}
