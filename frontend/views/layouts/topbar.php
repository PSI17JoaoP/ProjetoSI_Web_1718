<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\models\Anuncio;

    NavBar::begin([
        'brandLabel' => 'Sistema de Trocas',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top navbar',
        ],
    ]);
    $menuItems = [];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        $menuItems[] = ['label' => 'Registo', 'url' => ['/site/signup']];
    } else {

        if(Anuncio::findOne(['id_user' => Yii::$app->user->identity->getId()]) !== null) {
            $menuItems[] = Html::beginTag('li')
                . Html::a('Criar Anúncio', ['anuncio/create'], ['class' => 'btn btn-success btn-lg', 'style' => 'color: #fff; padding: 10px; margin-top: 4px;'])
                . Html::endTag('li');
        }

        $menuItems[] =  Html::beginTag('li', ['class' => 'nav-item dropdown'])
            . Html::tag('a','Notificações',
                ['class' => 'nav-link dropdown-toggle',
                    'id' => 'navbarDropdownMenuNotif',
                    'data-toggle' => 'dropdown',
                    'aria-haspopup' => true,
                    'aria-expanded' => false])
            . Html::beginTag('div', ['class' => 'dropdown-menu', 'aria-labelledby' => 'navbarDropdownMenuNotif']);

        foreach($notificacoes as $notificacao)
        {
            if (strpos($notificacao->mensagem, 'proposta') !== false) 
            {
                $menuItems[] = Html::a($notificacao->mensagem, Url::toRoute(['user/propostas', 'id_notificacao' => $notificacao->id]), ['class' => 'dropdown-item btn']);
            }else {
                $menuItems[] = Html::a($notificacao->mensagem, Url::toRoute(['user/anuncios', 'id_notificacao' => $notificacao->id]), ['class' => 'dropdown-item btn']);
            }

        }

        $menuItems[] = Html::endTag('div') . Html::endTag('li');

        $menuItems[] =  Html::beginTag('li', ['class' => 'nav-item dropdown'])
            . Html::tag('a', Yii::$app->user->identity->username,
                ['class' => 'nav-link dropdown-toggle',
                'id' => 'navbarDropdownMenuLink',
                'data-toggle' => 'dropdown',
                'aria-haspopup' => true,
                'aria-expanded' => false])
            . Html::beginTag('div', ['class' => 'dropdown-menu', 'aria-labelledby' => 'navbarDropdownMenuLink'])
            . Html::a('Anúncios', ['user/anuncios'], ['class' => 'dropdown-item btn'])
            . Html::a('Propostas', ['user/propostas'], ['class' => 'dropdown-item btn'])
            . Html::a('Histórico', ['user/historico'], ['class' => 'dropdown-item btn'])
            . Html::a('Definições', ['user/conta'], ['class' => 'dropdown-item btn'])
            . Html::beginTag('a', ['class' => 'dropdown-item'])
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout',
                ['class' => 'dropdown-item btn btn-link logout']
            )
            . Html::endForm()
            . Html::endTag('a') . Html::endTag('div') . Html::endTag('li');
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();