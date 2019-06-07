<?php

namespace twsihan\yii\assets;

use yii\web\AssetBundle;

/**
 * Class DataTablesAsset
 *
 * @package twsihan\yii\assets
 * @author twsihan <twsihan@gmail.com>
 */
class DataTablesAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/datatables.net';
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];
    public $css = [
    ];
    public $js = [
        'js/jquery.dataTables.js',
    ];
}
