<?php

namespace twsihan\yii\assets;

use yii\web\AssetBundle;

/**
 * Class EChartsAsset
 *
 * @package twsihan\yii\assets
 * @author twsihan <twsihan@gmail.com>
 */
class EChartsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];
    public $css = [
    ];
    public $js = [
        'http://echarts.baidu.com/dist/echarts.js',
    ];
}
