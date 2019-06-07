<?php

namespace twsihan\yii\widgets;

use twsihan\yii\assets\EChartsAsset;
use twsihan\yii\helpers\ArrayHelper;
use twsihan\yii\helpers\Html;
use yii\bootstrap\Widget;
use yii\helpers\Json;
use yii\web\View;

/**
 * Class ECharts
 *
 * @package twsihan\yii\widgets
 * @author twsihan <twsihan@gmail.com>
 */
class ECharts extends Widget
{
    public static $autoIdPrefix = 'echarts';
    /**
     * @var array the HTML attributes for the container tag of the grid view.
     * The "tag" element specifies the tag name of the container element and defaults to "div".
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    public $pluginOptions = [];
    /**
     * @var integer the registration position for the Krajee dialog JS client code.
     */
    public $jsPosition = View::POS_END;
    public $type = 'pie';
    public $categourp = [];
    public $bgcolor = [];
    public $ajax;


    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();

        $this->echarts();

        $this->initOptions();

        $this->registerAssets();
    }

    public function echarts()
    {
        echo Html::tag('div', '', $this->options);
    }

    /**
     * Initialize the dialog buttons.
     * @throws \yii\base\InvalidConfigException
     */
    public function initOptions()
    {
        $options = ['class' => $this->getId()];

        $this->options = ArrayHelper::merge($options, $this->options);
    }

    /**
     * Registers the needed assets
     * @param $options
     * @throws \yii\base\InvalidConfigException
     */
    public function registerAssets()
    {
        $view = $this->getView();

        EChartsAsset::register($view);

        $defaultsVar = 'echarts' . hash('crc32', $this->getId());
        $opts = Json::htmlEncode($this->pluginOptions);
        $view->registerJs("var {$defaultsVar} = echarts.init(document.getElementById('" . $this->getId() . "'));", $this->jsPosition);
        $view->registerJs("{$defaultsVar}.setOption({$opts}, true);", $this->jsPosition);
    }
}
