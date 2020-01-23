<?php

namespace QikkerOnline\NovaMenuBuilder\Http\Resources;

use Eminiarts\Tabs\TabsOnEdit;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
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
        ];

//        if (MenuBuilder::hasNovaLang()) {
//            $fields[] = \OptimistDigital\NovaLang\NovaLangField\NovaLangField::make('Locale', 'locale', 'locale_parent_id')->onlyOnForms();
//        } else {
//            $fields[] = LocaleField::make('Locale', 'locale', 'locale_parent_id')->locales($locales)->onlyOnForms();
//        }

//        if (count($locales) > 1) {
//            $fields[] = LocaleField::make('Locale', 'locale', 'locale_parent_id')
//                ->locales($locales)
//                ->exceptOnForms();
//        } else if ($hasManyDifferentLocales) {
//            $fields[] = Text::make('Locale', 'locale')->exceptOnForms();
//        }
//
//        $fields[] = BuilderResourceTool::make()->withMeta(['locale' => $resourceLocale]);
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
