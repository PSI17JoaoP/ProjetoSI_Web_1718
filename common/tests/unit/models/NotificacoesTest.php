<?php
namespace common\tests\unit\models;


use common\fixtures\UserFixture;
use common\models\Notificacoes;

class NotificacoesTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    protected $userId;

    protected function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);

        $this->tester->seeRecord('common\models\User', [
            'username' => 'bayer.hudson',
            'email' => 'nicole.paucek@schultz.info'
        ]);

        $user = $this->tester->grabRecord('common\models\User', [
            'username' => 'bayer.hudson',
            'email' => 'nicole.paucek@schultz.info'
        ]);

        $this->userId = $user->id;
    }

    public function testNotificacaoMensagemErrada()
    {
        $notificacao = new Notificacoes();
        $notificacao->id_user = $this->userId;
        $notificacao->lida = 0;

        $notificacao->mensagem = null;

        $this->assertFalse($notificacao->save());

        $notificacao->mensagem = [];

        $this->assertFalse($notificacao->save());

        $notificacao->mensagem = 123123;

        $this->assertFalse($notificacao->save());

        $notificacao->mensagem = 'asdasgdjsskfeuhasfkahlsdkefzuhlalseihzuksrekhuzedlsfeghflzjilhzdjhuhzdeukasehulfzilhfziblrhflihfzdablshfujdgilfjzrlhgejfdhkgrsflfsoihspohsijpoispospklshisqweqweqweqweqweqweqweqweqweqweqweqweqweqwqweqweqweqweqweqweqweqweqweqweqweqweqweqweqweqweqweqweqwqweqweqweqweqwe';

        $this->assertFalse($notificacao->save());

        $notificacao->mensagem = 'Mensagem';

        $this->assertNotFalse($notificacao->save());

        $this->tester->seeRecord('common\models\Notificacoes', [
            'id_user' => $this->userId,
            'mensagem' => 'Mensagem',
            'lida' => 0
        ]);
    }
}