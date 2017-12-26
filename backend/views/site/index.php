<?php

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
                                    <span class="info-box-text">Nº Anuncios</span>
                                    <span class="info-box-number">41,410</span>
                                </div>
                            </div>

                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-list-ul"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Nº Propostas</span>
                                    <span class="info-box-number">41,410</span>
                                </div>
                            </div>

                            <div class="info-box">
                                <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Nº Utilizadores</span>
                                    <span class="info-box-number">41,410</span>
                                </div>
                            </div>
                        </div>
                            <!--/TODOS-->

                            <!--ANUNCIOS-->
                        <div class="tab-pane fade" id="anuncios">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Column heading</th>
                                        <th>Column heading</th>
                                        <th>Column heading</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                            <!--/ANUNCIOS-->
                        <div class="tab-pane fade" id="propostas">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Column heading</th>
                                        <th>Column heading</th>
                                        <th>Column heading</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                        <td>Column content</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!--/PROPOSTAS-->
                        </div>
                            <!--UTILIZADORES-->
                        <div class="tab-pane fade" id="utilizadores">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    User 1
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    User 2
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    User 3
                                </div>
                            </div>

                            <!--/UTILIZADORES-->
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>      
</div>