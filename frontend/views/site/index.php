<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\materialicons\MD;
use common\models\Anuncio;
use common\models\ImagensAnuncio;

$this->title = 'Página Inicial';

?>

<div class="site-index">
    <div class="body-content">
        <div class="row" style="margin-bottom: 10%">
            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <form class="form" role="search">
                            <div class="col-md-12" style="margin-bottom: 10px">
                                <input type="text" class="form-control" placeholder="Pesquisar...">
                            </div>

                            <div class="col-md-5">
                                <?= Html::dropDownList('categoria', 'categoria', $categorias,
                                    ['class' => 'form-control', 'style' => "margin-bottom: 10px", 'prompt' => 'Categoria ...'])?>
                            </div>

                            <div class="col-md-4">
                                <?= Html::dropDownList('regiao', 'regiao', $regioes,
                                    ['class'=>'form-control', 'style' => "margin-bottom: 10px", 'prompt' => 'Região ...'])?>
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
                                <?= Html::a('Criar Anúncio','#', ['class' => 'btn btn-success btn-lg', 'id' => 'btn-create-anuncio'])?>
                            </div>
                        </div>
                    </div>

                    <?= $this->renderAjax('modal',[
                                'model' => $model,
                                'content' => '//forms/cliente']);?>

                <?php } ?>
            <?php } ?>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <p style="margin: 0">Recentes</p>
                    </div>

                    <div class="panel-body">

                        <?php 

                            $anuncios = Anuncio::find()->all();

                            foreach ($anuncios as $anuncio) {

                                if($anuncio !== null) {

                                    $imagens = ImagensAnuncio::findAll(['anuncio_id' => $anuncio->id]);
                                    
                                    if(!Yii::$app->user->isGuest) {
                                        echo $this->render('anuncio-cliente', ['anuncio' => $anuncio]);
                                    } else {
                                        echo $this->render('anuncio-guest', ['anuncio' => $anuncio]);
                                    } ?>

                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <p style="margin: 0">Destaques</p>
                        </div>

                        <div class="panel-body">

                            <?php 

                                $anuncios = Anuncio::find()->all();

                                foreach ($anuncios as $anuncio) {

                                    if($anuncio !== null) {

                                        $imagens = ImagensAnuncio::findAll(['anuncio_id' => $anuncio->id]);
                                        
                                        if(!Yii::$app->user->isGuest) {
                                            echo $this->render('anuncio-cliente', ['anuncio' => $anuncio]);
                                        } else {
                                            echo $this->render('anuncio-guest', ['anuncio' => $anuncio]);
                                        } ?>

                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
