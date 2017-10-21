<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Gii (temporário)', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    [
                        'label' => 'Estatísticas', 
                        'icon' => 'bar-chart-o', 
                        'url' => '#',
                        'items' => [
                            ['label' => 'Stat 1', 'icon' => 'circle-o', 'url' => '#'],
                            ['label' => 'Stat 2', 'icon' => 'circle-o', 'url' => '#'],
                            ['label' => 'Stat 3', 'icon' => 'circle-o', 'url' => '#'],
                        ]
                    ],
                    ['label' => 'Utilizadores', 'icon' => 'users', 'url' => ['site/index']],
                ],
            ]
        ) ?>

    </section>

</aside>
