<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Página Inicial';

?>
<div class="site-index">


    <div class="body-content">

        <div class="row">
            <form class="form" role="search">
            <div class="col-lg-6">
                
                    <div class="col-lg-12">
                        <input type="text" class="form-control" placeholder="Pesquisar...">
                    </div>
                    <div class="col-xs-6">
                        <select class="form-control" id="categoria">
                            <option value="" disabled selected>Categorias</option>
                            <option value="brinquedos">Brinquedos</option>
                            <option value="jogos">Jogos</option>
                            <option value="eletronica">Eletrónica</option>
                            <option value="computadores">Computadores</option>
                            <option value="smartphones">Smartphones</option>
                            <option value="livros">Livros</option>
                            <option value="roupa">Roupa</option>
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <select class="form-control" id="regiao">
                            <option value="" disabled selected>Distrito</option>
                            <option value="Aveiro">Aveiro</option>
                            <option value="Beja">Beja</option>
                            <option value="Braga">Braga</option>
                            <option value="Bragança">Bragança</option>
                            <option value="Castelo Branco">Castelo Branco</option>
                            <option value="Coimbra">Coimbra</option>
                            <option value="Évora">Évora</option>
                            <option value="Faro">Faro</option>
                            <option value="Guarda">Guarda</option>
                            <option value="Leiria">Leiria</option>
                            <option value="Lisboa">Lisboa</option>
                            <option value="Portalegre">Portalegre</option>
                            <option value="Porto">Porto</option>
                            <option value="Santarém">Santarém</option>
                            <option value="Setúbal">Setúbal</option>
                            <option value="Viana do Castelo">Viana do Castelo</option>
                            <option value="Vila Real">Vila Real</option>
                            <option value="Viseu">Viseu</option>
                            <option value="Açores">Açores</option>
                            <option value="Madeira">Madeira</option>
                        </select>
                    </div>
                
            </div>
            <div class="col-lg-2" >
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </div>
            </form>

            <div class="col-lg-4">
            <?= Html::a('Criar Anúncio', ['anuncio/criar'], ['class' => 'btn btn-success'])?>
            </div>
        </div>
        <div class="row" style="padding-bottom:10%"></div>
        <div class="row">

            <div class="col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Anúncios mais recentes
                    </div>
                    <div class="panel-body">
                        <table id="tableRecent" class="table table-hover">
                            <tr height="100px">
                                <td width="40%">
                                    <img src="" width="75px" height="75px">
                                    <p>Troco: Exemplo Bem 1</p>
                                </td>
                                <td width="40%" >
                                    <img src="" width="75px" height="75px">
                                    <p>Por: Exemplo Bem 2</p>
                                </td>
                                <td width="20%" align="right" style="padding-top: 30px"><button class="btn btn-sm">Enviar proposta</button></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Anúncios recomendados
                    </div>
                    <div class="panel-body">
                        <table id="tableRecommend" class="table table-hover">
                            <tr height="100px">
                                <td width="40%">
                                    <img src="" width="75px" height="75px">
                                    <p>Troco: Exemplo Bem 1</p>
                                </td>
                                <td width="40%" >
                                    <img src="" width="75px" height="75px">
                                    <p>Por: Exemplo Bem 2</p>
                                </td>
                                <td width="20%" align="right" style="padding-top: 30px"><button class="btn btn-sm">Enviar proposta</button></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
