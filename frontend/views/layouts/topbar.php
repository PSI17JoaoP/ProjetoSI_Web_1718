<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

    NavBar::begin([
        'brandLabel' => 'Sistema de Trocas',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top navbar',
        ],
    ]);
    $menuItems = [];

    //Comentem o if e o else para efeito de desenvolvimento na parte autenticada
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        $menuItems[] = ['label' => 'Registo', 'url' => ['/site/signup']];
    } else {
        $menuItems[] =  Html::beginTag('li', ['class' => 'nav-item dropdown'])
            . Html::tag('a','Notificações',
                ['class' => 'nav-link dropdown-toggle',
                    'id' => 'navbarDropdownMenuLink',
                    'data-toggle' => 'dropdown',
                    'aria-haspopup' => true,
                    'aria-expanded' => false])
            . Html::beginTag('div', ['class' => 'dropdown-menu', 'aria-labelledby' => 'navbarDropdownMenuLink'])

                /*foreach($notificacoes as $notificacao)
                {
                    //Imprimir HTML da notificação
                }*/

            . Html::endTag('div') . Html::endTag('li');

        $menuItems[] =  Html::beginTag('li', ['class' => 'nav-item dropdown'])
            . Html::tag('a', Yii::$app->user->identity->username,
                ['class' => 'nav-link dropdown-toggle',
                'id' => 'navbarDropdownMenuLink',
                'data-toggle' => 'dropdown',
                'aria-haspopup' => true,
                'aria-expanded' => false])
            . Html::beginTag('div', ['class' => 'dropdown-menu', 'aria-labelledby' => 'navbarDropdownMenuLink'])
            . Html::a('Definições', 'index', ['class' => 'dropdown-item btn'])
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