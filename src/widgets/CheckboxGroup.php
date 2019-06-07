<?php

namespace twsihan\yii\widgets;

use twsihan\yii\assets\ICheckAsset;
use twsihan\yii\helpers\ArrayHelper;
use twsihan\yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget as YiiInputWidget;

/**
 * Class CheckboxGroup
 *
 * @package twsihan\yii\widgets
 * @author twsihan <twsihan@gmail.com>
 */
class CheckboxGroup extends YiiInputWidget
{
    public $items;


    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        $this->checkboxGroup($this->items, $this->options);
        $this->registerAssets($this->options);
    }

    public function checkboxGroup($items, $options = [])
    {
        $name = isset($options['name']) ? $options['name'] : Html::getInputName($this->model, $this->attribute);
        $value = isset($options['value']) ? $options['value'] : Html::getAttributeValue($this->model, $this->attribute);
        $ulContent = Html::ul(ArrayHelper::map($items, 'name', 'description'), [
            'item' => function ($item, $index) use ($name, $items, $value, $options) {
                $id = sprintf('%s-%s', $options['id'], $index);
                $children = ArrayHelper::map($items[$index]['items'], 'name', 'description');
                $array = [];
                $count = 0;
                foreach ($children as $key => $val) {
                    $checked = false;
                    if (is_array($value) && key_exists($key, $value)) {
                        $count++;
                        $checked = true;
                    }
                    $array[] = Html::checkbox("{$name}[child][{$index}][]", $checked, [
                        'label' => $val,
                        'value' => $key,
                        'class' => $id,
                    ]);
                }
                $parentChecked = (count($children) === $count) ? true : false;
                $content = Html::checkbox("{$name}[parent][{$index}]", $parentChecked, [
                    'label' => $item,
                    'value' => $index,
                    'id' => $id,
                ]);
                $separator = ArrayHelper::remove($options, 'separator', '');
                $liContent = Html::tag('li', implode($separator, $array), ['class' => 'list-group-item']);
                $ulContent = Html::tag('ul', $liContent, ['class' => 'list-group']);
                return Html::tag('li', $content . $ulContent, ['class' => 'list-group-item']);
            },
            'class' => 'list-group checkbox-group',
        ]);
        $hidden = Html::activeHiddenInput($this->model, $this->attribute, [
            'value' => $value ? 1 : 0,
        ]);
        echo $hidden . $ulContent;
    }

    /**
     * Registers the needed assets
     * @param $options
     * @throws \yii\base\InvalidConfigException
     */
    public function registerAssets($options)
    {
        $id = $options['id'];
        $formatJs = <<< SCRIPT
$(function () {
    var checkboxGroup = $('.checkbox-group'),
        isParent = function (that) {
            return $(that).attr('id') ? true : false;
        },
        parentName = function (that) {
            return (isParent(that) === true) ? $(that).attr('id') : $(that).attr('class');
        },
        parentItem = function (that) {
            return checkboxGroup.find('#' + parentName(that));
        },
        childItem = function (that) {
            return checkboxGroup.find('.' + parentName(that));
        };
    checkboxGroup.find('input[type="checkbox"]').on('ifClicked', function (event) {
        if (!$(this).is(':checked')) {
            if (isParent(this) === true) {
                childItem(this).iCheck('check');
            } else {
                if (childItem(this).not(':checked').length == 1) {
                    parentItem(this).iCheck('check');
                }
            }
            $('#$id').val(1);
        } else {
            if (isParent(this) === true) {
                childItem(this).iCheck('uncheck');
            } else {
                parentItem(this).iCheck('uncheck');
            }
            if (checkboxGroup.find('input:checked').length == 0) {
                $('#$id').val('');
            }
        }
    });
});
SCRIPT;
        $view = $this->getView();
        $skin = ICheckAsset::register($view)->skin;
        if ($skin !== 'all') {
            $cssClassSuffix = str_replace('/', '-', $skin);
            $json = Json::encode([
                'checkboxClass' => sprintf('icheckbox_%s', $cssClassSuffix),
                'radioClass' => sprintf('iradio_%s', $cssClassSuffix),
                'increaseArea' => '20%',
            ]);
            $view->registerJs('$("input").iCheck(' . $json . ');', $view::POS_END);
        }
        $view->registerJs($formatJs, $view::POS_END);
    }
}
