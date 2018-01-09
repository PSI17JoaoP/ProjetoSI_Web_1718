<?php
namespace common\tests\unit\models;


use common\models\GeneroJogos;

class GeneroJogosTest extends \Codeception\Test\Unit
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

    public function testGeneroJogosCompleto()
    {
        $genero = new GeneroJogos();
        $genero->nome = 'RTS';

        $this->assertTrue($genero->save());

        $this->tester->seeRecord('common\models\GeneroJogos', [
            'nome' => 'RTS'
        ]);

        $generoCriado= $this->tester->grabRecord('common\models\GeneroJogos', [
            'nome' => 'RTS'
        ]);

        $generoCriado->nome = 'RPG';

        $this->assertEquals('RPG', $generoCriado->nome);

        $this->assertFalse($generoCriado->isNewRecord);

        $this->assertTrue($generoCriado->save());

        $this->tester->seeRecord('common\models\GeneroJogos', [
            'nome' => 'RPG'
        ]);

        $this->tester->dontSeeRecord('common\models\GeneroJogos', [
            'nome' => 'RTS'
        ]);

        $generoAlterado = $this->tester->grabRecord('common\models\GeneroJogos', [
            'nome' => 'RPG'
        ]);

        $this->assertNotFalse($generoAlterado->delete());

        $this->tester->dontSeeRecord('common\models\GeneroJogos', [
            'nome' => 'RPG'
        ]);
    }
}