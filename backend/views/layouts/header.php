<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$count_notifications = count($notifications);
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">ST</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-danger"><?= $count_notifications ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Tem <?= $count_notifications ?> notificações</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">

                                <?php
                                    foreach ($notifications as $key => $notification) {
                                        echo "<li>
                                                <a href='#'>
                                                    <i class='fa fa-info text-aqua'></i> $notification
                                                </a>
                                            </li>";
                                    }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <div class="box box-widget widget-user-2" style="margin-bottom: 0px">
                            <div class="widget-user-header bg-blue">
                                <h3 class="widget-user-username"><?= Yii::$app->user->identity->username ?></h3>
                                <h5 class="widget-user-desc">Admin</h5>
                            </div>
                        </div>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sair',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
