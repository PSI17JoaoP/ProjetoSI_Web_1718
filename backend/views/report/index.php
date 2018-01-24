<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Gestão de Reports';
dmstr\web\AdminLteAsset::register($this);
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Lista de Utilizadores</h3>
                    </div>
                    <div class="box-body">
                        <table id="tableListaReports" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Troca</th>
                                    <th>Por</th>
                                    <th>Nº Reports</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="listaReports">
                                <?php
                                   foreach ($dados as $key => $anuncio) 
                                   {
                                ?>
                                    <tr>
                                        <td><?= $anuncio["titulo"] ?></td>
                                        <td><?= $anuncio["cat_oferecer"] ?></td>
                                        <td><?= $anuncio["cat_receber"] ?></td>
                                        <td><?= $anuncio["nReports"] ?></td>
                                        <td id="acao<?= $anuncio['id']?>">
                                            <button type="button" class="btn btn-danger fechar" data-id="<?= $anuncio['id']?>" data-url="<?= Url::toRoute(['report/fechar']) ?>">Fechar anúncio</button>
                                        </td>
                                    </tr>
                                <?php
                                   }
                                ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>