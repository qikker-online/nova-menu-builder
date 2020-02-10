<?php

namespace QikkerOnline\NovaMenuBuilder\Classes;

class MenuItemStaticURL extends MenuLinkable
{
    public static function getIdentifier(): string
    {
        return 'static-url';
    }

    public static function getName(): string
    {
        return 'External URL';
    }

    public static function getType(): string
    {
        return 'static-url';
    }
}
