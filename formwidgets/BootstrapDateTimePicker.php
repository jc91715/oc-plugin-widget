<?php namespace Jc91715\Widget\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * bootstrapDateTimePicker Form Widget
 */
class BootstrapDateTimePicker extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'jc91715_widget_bootstrap_date_time_picker';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('bootstrapdatetimepicker');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/bootstrapdatetimepicker.css', 'jc91715.widget');
        $this->addJs('js/bootstrapdatetimepicker.js', 'jc91715.widget');
        $this->addJs('js/bootstrap-datetimepicker.zh-CN.js', 'jc91715.widget');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
