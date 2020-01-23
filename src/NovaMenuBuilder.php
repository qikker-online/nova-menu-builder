<?php

namespace QikkerOnline\NovaMenuBuilder;

use Illuminate\View\View;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use QikkerOnline\NovaMenuBuilder\Classes\MenuItemStaticURL;
use QikkerOnline\NovaMenuBuilder\Classes\MenuItemText;

class NovaMenuBuilder extends Tool
{
    protected static $defaultLinkableModels = [
        MenuItemStaticURL::class,
        MenuItemText::class,
    ];

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-menu', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-menu', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return View
     */
    public function renderNavigation()
    {
        return view('nova-menu::navigation');
    }

    public static function getLocales(): array
    {
        $localesConfig = config('nova-menu.locales', ['en' => 'English']);
        if (is_callable($localesConfig)) return call_user_func($localesConfig);
        if (is_array($localesConfig)) return $localesConfig;
        return ['en' => 'English'];
    }


    public static function getModels()
    {
        $configuredLinkableModels = config('nova-menu.linkable_models', []);
        return array_merge(
            static::$defaultLinkableModels,
            $configuredLinkableModels
        );
    }

    public static function getMenusTableName()
    {
        return config('nova-menu.menus_table_name', 'qo_menu_menus');
    }

    public static function getMenuItemsTableName()
    {
        return config('nova-menu.menu_items_table_name', 'qo_menu_menu_items');
    }
}
