<?php

namespace twsihan\yii\assets;

use yii\helpers\Json;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class ICheckAsset
 *
 * @package twsihan\yii\assets
 * @author twsihan <twsihan@gmail.com>
 */
class ICheckAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/iCheck';
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];
    public $js = [
        'icheck.js',
    ];
    public $jsOptions = ['position' => View::POS_END];
    public $skin = 'minimal/green';


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->css[] = sprintf('%s.css', $this->skin);

        parent::init();
    }
}
