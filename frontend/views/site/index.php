<?php

/* @var $this yii\web\View */

use common\models\ImagensAnuncio;
use yii\helpers\Html;
use common\models\Anuncio;
use yii\materialicons\MD;

$this->title = 'Página Inicial';

?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <form class="form" role="search">
                            <div class="col-md-12" style="margin-bottom: 10px">
                                <input type="text" class="form-control" placeholder="Pesquisar...">
                            </div>
                            <div class="col-md-5">
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
                            <div class="col-md-4">
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
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Pesquisar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php

            if(!Yii::$app->user->isGuest)
            {
                if(Anuncio::findOne(['id_user' => Yii::$app->user->identity->getId()]) === null) { ?>
                    <div class="col-md-4">
                        <div class="panel panel-success">
                            <div class="panel-body" style="text-align: center; background-color: #449d44">
                                <p class="text-center" style="color: white">É a sua primeira vez online ?</p>
                                <p class="text-center" style="color: white">Crie agora um anúncio !!</p>
                                <?= Html::a('Criar Anúncio', ['anuncio/create'], ['class' => 'btn btn-success btn-lg'])?>
                            </div>
                        </div>
                    </div>
            <?php } ?>
        <?php } ?>
    </div>






        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <p style="margin: 0">Recentes</p>
                    </div

                    <div class="panel-body">

                        <?php

                        $anuncios = Anuncio::find()->all();

                        foreach ($anuncios as $anuncio) {

                            if($anuncio !== null) {

                                $imagens = ImagensAnuncio::findAll(['anuncio_id' => $anuncio->id]) ?>

                                <div class="panel panel-info">
                                    <div class="panel-body">
                                        <div class="col-md-3">
                                            <?= Html::img('', ['width' => '75px', 'height' => '75px']) ?>
                                        </div>

                                        <div class="col-md-2">
                                            <?= MD::icon(MD::_SWAP_HORIZ, ['width' => '50px', 'height' => '50px']) ?>
                                        </div>

                                        <div class="col-md-3">
                                            <?= Html::img('', ['width' => '75px', 'height' => '75px']) ?>
                                        </div>

                                        <div class="col-md-4">

                                            <?php

                                                if($anuncio->quant_receber !== null) {
                                                    echo Html::a('Enviar Proposta', ['proposta/create', 'anuncioId' => $anuncio->id],
                                                        ['class' => 'btn btn-info',
                                                        'data' => ['method' => 'post'],
                                                        'style' => 'margin-left: 17px; margin-top: 15px']);
                                                }

                                                else {
                                                    echo Html::a('Enviar Proposta', ['proposta/create', 'anuncioId' => $anuncio->id],
                                                        ['class' => 'btn btn-info',
                                                        'style' => 'margin-left: 17px; margin-top: 15px']);
                                                }

                                            ?>

                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>

            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <p style="margin: 0">Destaques</p>
                    </div

                    <div class="panel-body">

                        <?php

                        $anuncios = Anuncio::find()->all();

                        foreach ($anuncios as $anuncio) {

                            if($anuncio !== null) {

                                $imagens = ImagensAnuncio::findAll(['anuncio_id' => $anuncio->id]) ?>

                                <div class="panel panel-info">
                                    <div class="panel-body">
                                        <div class="col-md-3">
                                            <?= Html::img('', ['width' => '75px', 'height' => '75px']) ?>
                                        </div>

                                        <div class="col-md-2">
                                            <?= MD::icon(MD::_SWAP_HORIZ, ['width' => '50px', 'height' => '50px']) ?>
                                        </div>

                                        <div class="col-md-3">
                                            <?= Html::img('', ['width' => '75px', 'height' => '75px']) ?>
                                        </div>

                                        <div class="col-md-4">

                                            <?php

                                                if($anuncio->quant_receber !== null) {
                                                    echo Html::a('Enviar Proposta', ['proposta/create', 'anuncioId' => $anuncio->id], [
                                                        'class' => 'btn btn-info',
                                                        'data' => ['method' => 'post'],
                                                        'style' => 'margin-left: 17px; margin-top: 15px']);
                                                }

                                                else {
                                                    echo Html::a('Enviar Proposta', ['proposta/create', 'anuncioId' => $anuncio->id], [
                                                        'class' => 'btn btn-info',
                                                        'style' => 'margin-left: 17px; margin-top: 15px']);
                                                }

                                            ?>

                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
