<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    /*
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    */

    public $sourcePath = '@vendor/almasaeed2010/adminlte/';
    public $js = [
        'bower_components/chart.js/Chart.min',
        '../../../web/js/custom.js'
    ];
    public $css = [

    ];
    public $depends = [
        'dmstr\web\AdminLteAsset',
    ];
}

/*class AdminLtePluginAsset extends AssetBundle
{
    //Conteudo em cima da definição desta classe
}*/
