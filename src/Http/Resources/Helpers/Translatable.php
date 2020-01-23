<?php

namespace QikkerOnline\NovaMenuBuilder\Http\Resources\Helpers;

use Eminiarts\Tabs\Tabs;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;

class Translatable extends Field
{

    public static function make(...$arguments)
    {
        $name = $arguments[0];
        /** @var Field[] $fields */
        $fields = $arguments[1];
        $locales = $arguments[2] ?? [];
        $request = $arguments[3];

        if ($request->editMode !== 'create') {
            // todo: when creating a products the locale is unknown because the region isn't set yet
        }

        if (count($locales) === 0) {
            return new Tabs($name, [
                'No region selected' => $fields,
            ]);
        }

        $tabs = [];

        $localeOnIndex = \App::getLocale();
        if (!in_array($localeOnIndex, $locales)) {
            $localeOnIndex = reset($locales);
        }

        foreach ($locales as $locale => $name) {
            $tabs[$name] = [];

            // Iterate over provided field and set the resolve and fill methods
            // to take translations into account.
            foreach ($fields as $field) {
                $field = clone $field;

                if ($locale !== $localeOnIndex) {
                    $field->hideFromIndex();
                }

                $field
                    ->withMeta([
                        'attribute' => $field->attribute.'_'.$locale,
                    ])
                    ->resolveUsing(function ($value, Model $model) use ($locale, $field, $request) {

                        $translation = $model->getTranslations($field->attribute)[$locale] ?? null;

                        if ($request instanceof ResourceIndexRequest) {
                            return '('.$locale.') - '.$translation ?? 'no translation set';
                        }

                        return $translation;
                    })
                    ->fillUsing(function (NovaRequest $novaRequest, Model $model) use ($locale, $field) {
                        $model->setTranslation(
                            $field->attribute,
                            $locale,
                            $novaRequest->get($field->attribute.'_'.$locale)
                        );
                    });

                $tabs[$name][] = $field;
            }
        }

        return new Tabs($name, $tabs);
    }
}
