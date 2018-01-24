<aside class="main-sidebar">

    <section class="sidebar">

    <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => 'Estatísticas', 
                        'icon' => '  fa-bar-chart-o',
                        'items' => 
                        [
                            ['label' => 'Anúncios', 'icon' => 'circle-o', 'url' => ['site/anuncios']],
                            ['label' => 'Propostas', 'icon' => 'circle-o', 'url' => ['site/propostas']],
                        ]
                    ],
                    [
                        'label' => 'Gestão', 
                        'icon' => '   fa-gear',
                        'items' => 
                        [
                            ['label' => 'Utilizadores', 'icon' => 'circle-o', 'url' => ['user/index']],
                            ['label' => 'Reports', 'icon' => 'circle-o', 'url' => ['report/index']],
                        ]
                    ],
                    
                ],
            ]
        ) ?>

    </section>

</aside>
