<aside class="main-sidebar">

    <section class="sidebar">

    <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Estatísticas', 'options' => ['class' => 'header']],
                    ['label' => 'Anúncios', 'icon' => 'circle-o', 'url' => '#'],
                    ['label' => 'Propostas', 'icon' => 'circle-o', 'url' => '#'],
                    ['label' => 'Utilizadores', 'icon' => 'circle-o', 'url' => ['user/index']],
                ],
            ]
        ) ?>

    </section>

</aside>
