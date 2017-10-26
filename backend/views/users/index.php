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
                                    <th>Nome</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- TEMP! -->
                                <tr class="rowListaUsers" data-info="1">
                                    <td>Nome1</td>
                                    <td>Email1</td>
                                </tr>
                                <tr class="rowListaUsers" data-info="2">
                                    <td>Nome2</td>
                                    <td>Email2</td>
                                </tr>
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
                    <div class="box-body box-profile">
                        <?= $this->render('user-info.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
    $this->registerJs(
        '$(".rowListaUsers").click(function() {
            var testID = $(this).data("info");
            $("#userProfileName").html("Nome " + testID);
        })'
    );
?>