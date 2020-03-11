<?php

namespace QikkerOnline\NovaMenuBuilder\Http\Resources;

use Eminiarts\Tabs\TabsOnEdit;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use QikkerOnline\NovaMenuBuilder\BuilderResourceTool;
use QikkerOnline\NovaMenuBuilder\Http\Resources\Helpers\Translatable;
use QikkerOnline\NovaMenuBuilder\Models\Menu;
use QikkerOnline\NovaMenuBuilder\NovaMenuBuilder;

class MenuResource extends Resource
{
    use TabsOnEdit;

    public static $model = Menu::class;
    public static $search = ['name', 'slug'];
    public static $displayInNavigation = false;

    public function fields(Request $request)
    {
        $menusTableName = NovaMenuBuilder::getMenusTableName();
        $locales = NovaMenuBuilder::getLocales();

        $translatableFields = [
            Text::make(__('Name'), 'name')
                ->sortable(),

            Text::make(__('Slug'), 'slug')
                ->sortable(),
        ];

        return [
            Translatable::make('Translations', $translatableFields, $locales, $request),
            BuilderResourceTool::make()->withMeta(['locales' => $locales]),
        ];
    }

    public static function label()
    {
        return 'Menus';
    }

    public static function singularLabel()
    {
        return 'Menu';
    }

    public static function uriKey()
    {
        return 'nova-menu';
    }

    public function title()
    {
        return $this->name.' ('.$this->slug.')';
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
//        if (NovaMenuBuilder::hasNovaLang()) {
//            $query->where(NovaMenuBuilder::getMenusTableName().'.locale', nova_lang_get_active_locale());
//        }
        return $query;
    }
}
