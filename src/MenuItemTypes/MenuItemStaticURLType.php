<?php

namespace Outl1ne\MenuBuilder\MenuItemTypes;

use Laravel\Nova\Fields\Text;

class MenuItemStaticURLType extends BaseMenuItemType
{
    public static function getIdentifier(): string
    {
        return 'static-url';
    }

    public static function getName(): string
    {
        return 'Static URL';
    }

    public static function getType(): string
    {
        return 'static-url';
    }
    public static function getRules(): array
    {
        return [
            'static_url' => 'required',
        ];
    }
    public static function getFields(): array
    {
        return [
            Text::make(__('novaMenuBuilder.staticUrl'), 'static_url')
                ->sortable()
        ];
    }

}
