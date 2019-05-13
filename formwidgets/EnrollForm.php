<?php namespace Jc91715\Widget\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * EnrollForm Form Widget
 */
class EnrollForm extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'jc91715_widget_enroll_form';

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
        return $this->makePartial('enrollform');
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
        $this->addCss('css/enrollform.css', 'yiyou.activity');
        $this->addJs('js/enrollform.js', 'yiyou.activity');
//        $this->addJs('http://cdn.jsdelivr.net/npm/vue/dist/vue.js');
        if(request()->getScheme()=='https'){
            $this->addJs('https://vuejs.org/js/vue.min.js');
        }else{
            $this->addJs('http://vuejs.org/js/vue.min.js');
        }

    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
