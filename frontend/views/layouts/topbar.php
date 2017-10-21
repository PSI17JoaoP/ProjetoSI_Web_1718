<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

//$this->beginContent('@app/views/layouts/main.php');

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
        $menuItems[] =  Html::beginTag('li', ['class' => 'nav-item dropdown'])
            . Html::tag('a', Yii::$app->user->identity->username,
                ['class' => 'nav-link dropdown-toggle',
                'id' => 'navbarDropdownMenuLink',
                'data-toggle' => 'dropdown',
                'aria-haspopup' => true,
                'aria-expanded' => false])
            . Html::beginTag('div', ['class' => 'dropdown-menu', 'aria-labelledby' => 'navbarDropdownMenuLink'])
            . Html::a('Definições', 'site/index', ['class' => 'dropdown-item'])
            . Html::beginTag('a', ['class' => 'dropdown-item'])
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . Html::endTag('a') . Html::endTag('div') . Html::endTag('li');
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();

//$this->endContent();