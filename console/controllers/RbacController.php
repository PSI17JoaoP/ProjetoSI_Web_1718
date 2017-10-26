<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Temos que definir as permissões de cada utilizador;

        //--------------------------Permissões-----------------------------------------

        //----------------------------Cliente----------------------------------
        $criarAnuncio = $auth->createPermission('criarAnuncio');
        $criarAnuncio->description = 'Criar um anúncio';
        $auth->add($criarAnuncio);

        $pesquisarAnuncios = $auth->createPermission('pesquisarAnuncios');
        $pesquisarAnuncios->description = 'Pesquisar Anúncios';
        $auth->add($pesquisarAnuncios);

        $enviarProposta = $auth->createPermission('enviarProposta');
        $enviarProposta->description = 'Enviar uma proposta a um anúncio';
        $auth->add($enviarProposta);

        $aceitarProposta = $auth->createPermission('aceitarProposta');
        $aceitarProposta->description = 'Aceitar uma proposta a um anúncio';
        $auth->add($aceitarProposta);

        $recusarProposta = $auth->createPermission('recusarProposta');
        $recusarProposta->description = 'Recusar uma proposta a um anúncio';
        $auth->add($recusarProposta);

        $gerarPINMovel = $auth->createPermission('gerarPINMovel');
        $gerarPINMovel->description = 'Gerar PIN para a aplicação móvel';
        $auth->add($gerarPINMovel);
        //---------------------------------------------------------------------

        //----------------------------Administrador----------------------------
        $criarCliente = $auth->createPermission('criarCliente');
        $criarCliente->description = 'Criar um cliente';
        $auth->add($criarCliente);

        $alterarCliente = $auth->createPermission('alterarCliente');
        $alterarCliente->description = 'Alterar um cliente';
        $auth->add($alterarCliente);

        $eliminarCliente = $auth->createPermission('eliminarCliente');
        $eliminarCliente->description = 'Eliminar um cliente';
        $auth->add($eliminarCliente);
        //---------------------------------------------------------------------

        //-----------------------------------------------------------------------------



        //-----------------------------------Roles-------------------------------------

        //---------------------Cliente--------------------------
        $cliente = $auth->createRole('cliente');
        $auth->add($cliente);
        $auth->addChild($cliente, $criarAnuncio);
        $auth->addChild($cliente, $pesquisarAnuncios);
        $auth->addChild($cliente, $enviarProposta);
        $auth->addChild($cliente, $recusarProposta);
        $auth->addChild($cliente, $aceitarProposta);
        $auth->addChild($cliente, $gerarPINMovel);
        //------------------------------------------------------

        //-------------------Administrador----------------------
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $criarCliente);
        $auth->addChild($admin, $alterarCliente);
        $auth->addChild($admin, $eliminarCliente);
        //------------------------------------------------------

        //-----------------------------------------------------------------------------
    }
}