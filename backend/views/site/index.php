<?php

use common\models\Tools;

/* @var $this yii\web\View */

$this->title = 'Dashboard - Back Office';

dmstr\web\AdminLteAsset::register($this);
?>
<div class="site-index">
    <div class="col-4 col-md-6">
        <div class="box box-info">
            <div class="box-body">

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

    <div class="col-4 col-md-6">
        <div class="row">
            <div class="box box-info">
                <div class="box-header">
                    <h4>Estatísticas</h4>
                </div>
                <!-- /.box-header -->
                <div class="box-body nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#todos" data-toggle="tab">Todos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#anuncios" data-toggle="tab">Anúncios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#propostas" data-toggle="tab">Propostas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#utilizadores" data-toggle="tab">Utilizadores</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!--TODOS-->
                        <div class="tab-pane fade active" id="todos">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-newspaper-o"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Nº Anuncios Ativos</span>
                                    <span class="info-box-number"><?= $stats[0] ?></span>
                                </div>
                            </div>

                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-list-ul"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Nº Propostas p/ Anúncio (+/-)</span>
                                    <span class="info-box-number"><?= $stats[1] ?></span>
                                </div>
                            </div>

                            <div class="info-box">
                                <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Nº Utilizadores</span>
                                    <span class="info-box-number"><?= $stats[2] ?></span>
                                </div>
                            </div>
                        </div>
                            <!--/TODOS-->

                            <!--ANUNCIOS-->
                        <div class="tab-pane fade" id="anuncios">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <td>Nº de Anúncios Ativos</td>
                                        <td><?= $stats[0] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nº de Anúncios este Mês</td>
                                        <td><?= $stats[3] ?></td>
                                    </tr>
                                    <?php
                                        foreach ($stats[4] as $key => $catCount) 
                                        {
                                            $cat = array_values(Tools::listaCategorias())[$key];
                                            $val = array_keys($catCount)[0];

                                            echo "<tr>
                                                    <td>Nº de Anúncios de $cat</td>
                                                    <td>$catCount[$val]</td>
                                                </tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                            <!--/ANUNCIOS-->
                            <!--Propostas-->

                        <div class="tab-pane fade" id="propostas">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <td>Nº de Propostas p/ Anúncio (+/-)</td>
                                        <td><?= $stats[1] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nº de Propostas Pendentes</td>
                                        <td><?= $stats[5] ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <!--/PROPOSTAS-->
                        </div>
                            <!--UTILIZADORES-->
                        <div class="tab-pane fade" id="utilizadores">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <td>Nº de Utilizadores</td>
                                        <td><?= $stats[2] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Utilizador com mais anúncios</td>
                                        <td><?= $stats[6] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Categoria preferida mais comum</td>
                                        <td><?= $stats[7] ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <!--/UTILIZADORES-->
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>      
</div>