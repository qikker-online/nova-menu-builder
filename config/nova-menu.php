<?php

use QikkerOnline\NovaMenuBuilder\Http\Resources\MenuResource;

return [
    /*
    |--------------------------------------------------------------------------
    | Resource
    |--------------------------------------------------------------------------
    |
    | Optionally override the original Menu resource.
    */

    'resource' => MenuResource::class,


    /*
    |--------------------------------------------------------------------------
    | Menus table name
    |--------------------------------------------------------------------------
    */

    'menus_table_name' => 'nova_menu_menus',


    /*
    |--------------------------------------------------------------------------
    | Menu items table name
    |--------------------------------------------------------------------------
    */

    'menu_items_table_name' => 'nova_menu_menu_items',


    /*
    |--------------------------------------------------------------------------
    | Locales
    |--------------------------------------------------------------------------
    |
    | Set all the available locales as either [key => name] pairs, a closure
    | or a callable (ie 'locales' => 'nova_lang_get_all_locales').
    */

    'locales' => ['en_US' => 'English'],


    /*
    |--------------------------------------------------------------------------
    | Linkable models
    |--------------------------------------------------------------------------
    |
    | Set all the linkable models in an array.
    */

    'linkable_models' => [],
];
