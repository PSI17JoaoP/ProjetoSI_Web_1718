<?php
namespace common\tests\unit\models;


use common\models\TipoRoupas;

class TipoRoupasTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testTipoRoupasCompleto()
    {
        $tipo = new TipoRoupas();
        $tipo->nome = 'Camisa';

        $this->assertTrue($tipo->save());

        $this->tester->seeRecord('common\models\TipoRoupas', [
            'nome' => 'Camisa'
        ]);

        $tipoCriado = $this->tester->grabRecord('common\models\TipoRoupas', [
            'nome' => 'Camisa'
        ]);

        $tipoCriado->nome = 'Camisola';

        $this->assertEquals('Camisola', $tipoCriado->nome);

        $this->assertFalse($tipoCriado->isNewRecord);

        $this->assertTrue($tipoCriado->save());

        $this->tester->seeRecord('common\models\TipoRoupas', [
            'nome' => 'Camisola'
        ]);

        $this->tester->dontSeeRecord('common\models\TipoRoupas', [
            'nome' => 'Camisa'
        ]);

        $tipoAlterado = $this->tester->grabRecord('common\models\TipoRoupas', [
            'nome' => 'Camisola'
        ]);

        $this->assertNotFalse($tipoAlterado->delete());

        $this->tester->dontSeeRecord('common\models\TipoRoupas', [
            'nome' => 'Camisola'
        ]);
    }
}