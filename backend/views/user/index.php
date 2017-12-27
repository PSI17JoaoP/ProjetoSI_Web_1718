<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Gestão de Utilizadores';
dmstr\web\AdminLteAsset::register($this);
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Lista de Utilizadores</h3>
                    </div>
                    <!-- Master -->
                    <div class="box-body">
                        <table id="tableListaUsers" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nome do cliente</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($clientes as $key => $cliente) 
                                    { 
                                        echo "
                                        <tr class='rowListaUsers' data-url='". Url::toRoute(['user/detalhes']) ."' data-id='". $cliente['id'] ."'>
                                            <td>". $cliente['nome_completo'] ."</td>
                                            <td>". $cliente['email'] ."</td>
                                        </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Detalhes do Utilizador</h3>
                    </div>
                    <!-- Detail. Import vista (render) -->
                    <div id="userInfo" style="display:none" class="box-body box-profile">
                        <?= $this->render('user-info.php'); ?>
                    </div>
                    <div class="pesquisa_loading" align="center" style="display:none">
                        <img src="../../web/assets/loading.gif" style="padding-top:10%; padding-bottom:10%"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
