<?php

namespace twsihan\yii\widgets;

use twsihan\yii\assets\ICheckAsset;
use twsihan\yii\helpers\ArrayHelper;
use twsihan\yii\helpers\Html;
use yii\bootstrap\InputWidget;

/**
 * Class ICheck
 *
 * @package twsihan\yii\widgets
 * @author twsihan <twsihan@gmail.com>
 */
class ICheck extends InputWidget
{
    const SKIN_ALL = 'all';
    const SKIN_FLAT = 'flat/_all';
    const SKIN_FLAT_AERO = 'flat/aero';
    const SKIN_FLAT_BLUE = 'flat/blue';
    const SKIN_FLAT_FLAT = 'flat/flat';
    const SKIN_FLAT_GREEN = 'flat/green';
    const SKIN_FLAT_GREY = 'flat/grey';
    const SKIN_FLAT_ORANGE = 'flat/orange';
    const SKIN_FLAT_PINK = 'flat/pink';
    const SKIN_FLAT_PURPLE = 'flat/purple';
    const SKIN_FLAT_RED = 'flat/red';
    const SKIN_FLAT_YELLOW = 'flat/yellow';
    const SKIN_FUTURICO = 'futurico/futurico';
    const SKIN_LINE = 'line/_all';
    const SKIN_LINE_AERO = 'line/aero';
    const SKIN_LINE_BLUE = 'line/blue';
    const SKIN_LINE_GREEN = 'line/green';
    const SKIN_LINE_GREY = 'line/grey';
    const SKIN_LINE_LINE = 'line/line';
    const SKIN_LINE_ORANGE = 'line/orange';
    const SKIN_LINE_PINK = 'line/pink';
    const SKIN_LINE_PURPLE = 'line/purple';
    const SKIN_LINE_RED = 'line/red';
    const SKIN_LINE_YELLOW = 'line/yellow';
    const SKIN_MINIMAL = 'minimal/_all';
    const SKIN_MINIMAL_AERO = 'minimal/aero';
    const SKIN_MINIMAL_BLUE = 'minimal/blue';
    const SKIN_MINIMAL_GREEN = 'minimal/green';
    const SKIN_MINIMAL_GREY = 'minimal/grey';
    const SKIN_MINIMAL_LINE = 'minimal/minimal';
    const SKIN_MINIMAL_ORANGE = 'minimal/orange';
    const SKIN_MINIMAL_PINK = 'minimal/pink';
    const SKIN_MINIMAL_PURPLE = 'minimal/purple';
    const SKIN_MINIMAL_RED = 'minimal/red';
    const SKIN_MINIMAL_YELLOW = 'minimal/yellow';
    const SKIN_POLARIS = 'polaris/polaris';
    const SKIN_SQUARE = 'square/_all';
    const SKIN_SQUARE_AERO = 'square/aero';
    const SKIN_SQUARE_BLUE = 'square/blue';
    const SKIN_SQUARE_GREEN = 'square/green';
    const SKIN_SQUARE_GREY = 'square/grey';
    const SKIN_SQUARE_LINE = 'square/square';
    const SKIN_SQUARE_ORANGE = 'square/orange';
    const SKIN_SQUARE_PINK = 'square/pink';
    const SKIN_SQUARE_PURPLE = 'square/purple';
    const SKIN_SQUARE_RED = 'square/red';
    const SKIN_SQUARE_YELLOW = 'square/yellow';

    /**
     * Text input type
     */
    const INPUT_TEXT = 'textInput';
    /**
     * Checkbox input type
     */
    const INPUT_CHECKBOX = 'checkbox';
    /**
     * Position label to the left of the checkbox
     */
    const LABEL_LEFT = 'left';
    /**
     * Position label to the right of the checkbox
     */
    const LABEL_RIGHT = 'right';
    /**
     * @var string initialization input type. Note, the widget by default uses a text input to initialize the plugin
     * instead of checkbox for better label styling, alignment and using templates within ActiveField. Can be one of
     * [[INPUT_TEXT]] or [[INPUT_CHECKBOX]]. Defaults to [[INPUT_TEXT]].
     */
    public $initInputType = self::INPUT_CHECKBOX;
    /**
     * @var boolean automatically generate, style, and position labels with respect to the checkbox x. If this is
     * `true`, the labels will automatically be positioned and styled based on label settings. When this is set to
     * `true` and you have set the `model` and `attribute`, the label will be automatically generated. If you are not
     * using this with a model, then  you must set the property `labelSettings['label']` for automatic label styling
     * to work.
     *
     * NOTE: If this is `true`, and you are using the widget within yii ActiveField, then you must disable the active
     * field label generation to avoid duplicate labels. For example:
     *
     * ```php
     * echo $form->field($model, 'attr')->widget(CheckboxX::class, [
     *      'autoLabel'=>true
     * ])->label(false);
     * ```
     */
    public $autoLabel = false;
    /**
     * @var array the settings for the label. The following properties are recognized
     * - `label`: _string_, the label to be used. When using with model, this will be automatically generated
     *   if not set.
     * - `position`: _string_, the position of the label with respect to the checkbox. Must be one of[[LABEL_LEFT]] or
     *   [[LABEL_RIGHT]]. Defaults to [[LABEL_RIGHT]] if not set.
     * - `options`: _array_, the HTML attributes for the label.
     */
    public $labelSettings = [];
    /**
     * @inheritdoc
     */
    public $pluginName = 'checkboxX';
    public $disabled;
    public $readonly;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->registerAssets();

        $this->initMarkup();
    }

    /**
     * Registers the client assets for the [[CheckboxX]] widget.
     */
    public function registerAssets()
    {
        $view = $this->getView();
        ICheckAsset::register($view);
    }

    public function initMarkup()
    {
        $label = ArrayHelper::getValue($this->labelSettings, 'label', '');
        $options = ArrayHelper::getValue($this->labelSettings, 'options', []);
        $position = ArrayHelper::getValue($this->labelSettings, 'position', self::LABEL_RIGHT);
        if ($this->disabled || $this->readonly ||
            ArrayHelper::getValue($this->options, 'disabled', false) ||
            ArrayHelper::getValue($this->options, 'readonly', false)
        ) {
            Html::addCssClass($options, 'disabled');
        }
        $label = $this->hasModel() && empty($label) ?
            Html::activeLabel($this->model, $this->attribute, $options) :
            Html::label($label, $this->options['id'], $options);
        if ($this->initInputType !== self::INPUT_TEXT) {
            $this->options['label'] = '';
        }
        $input = $this->getInput($this->initInputType);
        echo $this->hasModel() ? $input : (($position === self::LABEL_RIGHT) ? $input . $label : $label . $input);
    }

    /**
     * Generates an input.
     * @param string $type the input type
     * @param boolean $list whether the input is of dropdown list type
     * @return string the rendered input markup
     */
    protected function getInput($type, $list = false)
    {
        if ($this->hasModel()) {
            $input = 'active' . ucfirst($type);
            $inputContent = $list ?
                Html::$input($this->model, $this->attribute, $this->data, $this->options) :
                Html::$input($this->model, $this->attribute, $this->options);
        } else {
            $input = $type;
            $checked = false;
            if ($type == 'radio' || $type == 'checkbox') {
                $checked = ArrayHelper::remove($this->options, 'checked', '');
                if (empty($checked) && !empty($this->value)) {
                    $checked = ($this->value == 0) ? false : true;
                } elseif (empty($checked)) {
                    $checked = false;
                }
            }
            $inputContent = $list ?
                Html::$input($this->name, $this->value, $this->data, $this->options) :
                (($type == 'checkbox' || $type == 'radio') ?
                    Html::$input($this->name, $checked, $this->options) :
                    Html::$input($this->name, $this->value, $this->options));
        }
        return $inputContent;
    }
}
