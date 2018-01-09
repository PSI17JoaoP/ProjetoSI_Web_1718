<?php
namespace common\tests\unit\models;


use common\models\User;

class UserTest extends \Codeception\Test\Unit
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

    public function testUserCompleto()
    {
        $user = new User();
        $user->username = 'UnitTestUser';
        $user->email = 'unit@test.com';
        $user->setPassword('UNIT');
        $user->generateAuthKey();

        $this->assertTrue($user->save());

        $this->tester->seeRecord('common\models\User', [
            'username' => 'UnitTestUser',
            'email' => 'unit@test.com'
        ]);

        $userCriado = $this->tester->grabRecord('common\models\User', [
            'username' => 'UnitTestUser',
            'email' => 'unit@test.com'
        ]);

        $userCriado->username = 'UnitTestUserAlterado';

        $this->assertEquals('UnitTestUserAlterado', $userCriado->username);

        $this->assertFalse($userCriado->isNewRecord);

        $this->assertTrue($userCriado->save());

        $this->tester->seeRecord('common\models\User', [
            'username' => 'UnitTestUserAlterado',
            'email' => 'unit@test.com'
        ]);

        $this->tester->dontSeeRecord('common\models\User', [
            'username' => 'UnitTestUser',
            'email' => 'unit@test.com'
        ]);

        $userAlterado = $this->tester->grabRecord('common\models\User', [
            'username' => 'UnitTestUserAlterado',
            'email' => 'unit@test.com'
        ]);

        $this->assertNotFalse($userAlterado->delete());

        $this->tester->dontSeeRecord('common\models\User', [
            'username' => 'UnitTestUserAlterado',
            'email' => 'unit@test.com'
        ]);
    }
}