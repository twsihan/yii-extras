<?php

namespace twsihan\yii\data;

/**
 * Class GridView
 *
 * @package twsihan\yii\data
 * @author twsihan <twsihan@gmail.com>
 */
class GridView extends \yii\grid\GridView
{
    /**
     * @var array the HTML attributes for the grid table element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $tableOptions = ['class' => 'table table-bordered dataTable table-hover table-condensed'];
    /**
     * @var string whether the filters should be displayed in the grid view. Valid values include:
     *
     * - [[FILTER_POS_HEADER]]: the filters will be displayed on top of each column's header cell.
     * - [[FILTER_POS_BODY]]: the filters will be displayed right below each column's header cell.
     * - [[FILTER_POS_FOOTER]]: the filters will be displayed below each column's footer cell.
     */
    public $filterPosition = self::FILTER_POS_FOOTER;


    /**
     * Initializes the grid view.
     * This method will initialize required property values and instantiate [[columns]] objects.
     */
    public function init()
    {
        $this->layout = <<< HTML
<div class="dataTables_wrapper form-inline dt-bootstrap">
    <div class="row">
        <div class="col-sm-12">{items}</div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="dataTables_info">{summary}</div>
        </div>
        <div class="col-sm-7">
            <div class="dataTables_paginate paging_simple_numbers pull-right">{pager}</div>
        </div>
    </div>
</div>
HTML;
        parent::init();
    }
}
