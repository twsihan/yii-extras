<?php

namespace twsihan\yii\helpers;

/**
 * Class Html
 *
 * @package twsihan\yii\helpers
 * @author twsihan <twsihan@gmail.com>
 */
class Html extends \yii\bootstrap\Html
{


    /**
     * 单按钮下拉菜单
     * @param string $name
     * @param array $items
     * @param array $options
     * @return string
     */
    public static function btnGroup($name = '操作', $items = [], $options = [])
    {
        $class = isset($options['class']) ? $options['class'] : 'btn btn-default dropdown-toggle';

        $spanHtml = static::tag('span', '', ['class' => 'caret']);
        $buttonHtml = static::tag('button', $name . $spanHtml, [
            'type' => 'button',
            'class' => $class,
            'data-toggle' => 'dropdown',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false',
        ]);

        $ulHtml = static::ul($items, [
            'class' => 'dropdown-menu',
            'role' => 'menu',
        ]);

        return static::tag('div', $buttonHtml . $ulHtml, ['class' => 'btn-group']);
    }

    /**
     * 分裂式按钮下拉菜单
     * @param $group
     * @param array $options
     * @return string
     */
    public static function btnGroupSplit($group, $options = [])
    {
        $class = isset($options['class']) ? $options['class'] : 'btn btn-default';
        $default = isset($group['default']) ? $group['default'] : 'Button';

        $defaultButtonHtml = static::tag('button', $default, [
            'type' => 'button',
            'class' => $class,
        ]);

        $buttonHtml = $ulHtml = '';
        if (isset($group['items']) && $group['items'] != []) {
            $spanCaretHtml = static::tag('span', '', ['class' => 'caret']);
            $spanSrOnlyHtml = static::tag('span', '', ['class' => 'sr-only']);

            $buttonHtml = static::tag('button', $spanCaretHtml . $spanSrOnlyHtml, [
                'type' => 'button',
                'class' => $class . ' dropdown-toggle',
                'data-toggle' => 'dropdown',
            ]);

            $ulHtml = static::ul($group['items'], [
                'class' => 'dropdown-menu',
                'role' => 'menu',
            ]);
        }

        $content = $defaultButtonHtml . $buttonHtml . $ulHtml;

        return static::tag('div', $content, ['class' => 'btn-group']);
    }
}
