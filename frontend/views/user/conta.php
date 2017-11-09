<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


?>
<!--
<div class="col-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            Dados de utilizador
        </div>
        
        <div class="panel-body">
           
            <div class="row" style="padding-bottom: 5%">
                <div class="col-md-4" >
                    <img src="../web/assets/cfa4ff67/img/avatar.png"  width="125px" height="125px" >
                    <button class="btn btn-default btn-sm">Escolher Imagem...</button>
                </div>

                <div class="col-md-8">
                    <label for="nomeUser">Nome:</label>
                    <input type="text" class="form-control" id="nomeUser">

                    <label for="telefoneUser">Nº Telemóvel:</label>
                    <input type="text" class="form-control" id="telefoneUser">

                    <label for="emailUser">Email:</label>
                    <input type="email" class="form-control" id="emailUser">

                    <label for="regiaoUser">Região:</label>
                    <select class="form-control" id="regiaoUser">
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

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Categoria(s) preferida(s)
                        </div>
                        <div class="panel-body">
                            <div class="checkbox">
                                <label><input type="checkbox" value="brinquedos">Brinquedos</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="jogos">Jogos</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="eletronica">Eletrónica</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="computadores">Computadores</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="smartphones">Smartphones</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="livros">Livros</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="roupa">Roupa</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-footer" align="right">
            <button class="btn btn-default btn-lg">Concluído</button>
        </div>
    </div>
</div>
-->


<div class="col-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            Dados de utilizador
        </div>
                    <div class="box-body">
                        <?php $form = ActiveForm::begin(['id' => 'conta-form']); ?>

                        <div class="row" style="padding-bottom: 5%">
                <div class="col-md-4" >
                    <img src="../web/assets/cfa4ff67/img/avatar.png"  width="125px" height="125px" >
                    <button class="btn btn-default btn-sm">Escolher Imagem...</button>
                </div>

                <div class="col-md-8">
                    <label for="nomeUser">Nome:</label>
                    <?= $form->field($model, 'nome_completo')->textInput() ?>

                    <label for="telefone">Nº Telemóvel:</label>
                    <?= $form->field($model, 'telefone')->textInput(['type' => 'number']) ?>

                    <label for="emailUser">Email:</label>
                    <?= $form->field($model, 'email')->input("email") ?>

                    <label for="regiaoUser">Região:</label>
                    <?
                    

                        $form->field($model, 'regiao')
                            ->dropDownList(
                                $items,           // Flat array ('id'=>'label')
                                ['prompt'=>'']    // options
                            );
                    ?>
                    
                    <select class="form-control" id="regiaoUser">
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

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Categoria(s) preferida(s)
                        </div>
                        <div class="panel-body">
                            <div class="checkbox">
                                <label><input type="checkbox" value="brinquedos">Brinquedos</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="jogos">Jogos</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="eletronica">Eletrónica</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="computadores">Computadores</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="smartphones">Smartphones</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="livros">Livros</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="roupa">Roupa</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer" align="right">
            <button class="btn btn-default btn-lg">Concluído</button>
        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>