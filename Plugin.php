<?php namespace Jc91715\Widget;

use Backend;
use System\Classes\PluginBase;

/**
 * Widget Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Widget',
            'description' => 'No description provided yet...',
            'author'      => 'Jc91715',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Jc91715\Widget\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'jc91715.widget.some_permission' => [
                'tab' => 'Widget',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'widget' => [
                'label'       => 'Widget',
                'url'         => Backend::url('jc91715/widget/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['jc91715.widget.*'],
                'order'       => 500,
            ],
        ];
    }
}
