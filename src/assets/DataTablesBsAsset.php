<?php

namespace twsihan\yii\assets;

use yii\web\AssetBundle;

/**
 * Class DataTablesBsAsset
 *
 * @package twsihan\yii\assets
 * @author twsihan <twsihan@gmail.com>
 */
class DataTablesBsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/datatables.net-bs';
    /**
     * @inheritdoc
     */
    public $depends = [
        'twsihan\yii\assets\DataTablesAsset',
    ];
    public $css = [
        'css/dataTables.bootstrap.css',
    ];
    public $js = [
        'js/dataTables.bootstrap.js',
    ];
}
