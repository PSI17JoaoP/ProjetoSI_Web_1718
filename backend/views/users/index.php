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
                        <table class="table table-bordered">
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                            </tr>
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
                    <div class="box-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>