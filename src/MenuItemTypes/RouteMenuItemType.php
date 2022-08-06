<?php

namespace Outl1ne\MenuBuilder\MenuItemTypes;

use Laravel\Nova\Fields\Text;
use Outl1ne\MenuBuilder\Rules\RouteExists;

class RouteMenuItemType extends BaseMenuItemType
{
    public static function getType(): string
    {
        return 'route';
    }

    /**
     * Get the menu link identifier that can be used to tell different custom
     * links apart (ie 'page' or 'product').
     *
     * @return string
     **/
    public static function getIdentifier(): string {
        return 'route';
    }

    /**
     * Get menu link name shown in  a dropdown in CMS when selecting link type
     * ie ('Product Link').
     *
     * @return string
     **/
    public static function getName(): string {
        return __('novaMenuBuilder.route');
    }

    /**
     * Get the subtitle value shown in CMS menu items list.
     *
     * @param $value
     * @param $data The data from item fields.
     * @param $locale
     * @return string
     **/
    public static function getDisplayValue($value, ?array $data, $locale) {
         return $value;
    }

    /**
     * Get the value of the link visible to the front-end.
     *
     * Can be anything. It is up to you how you will handle parsing it.
     *
     * This will only be called when using the nova_get_menu()
     * and nova_get_menus() helpers or when you call formatForAPI()
     * on the Menu model.
     *
     * @param $value The key from options list that was selected.
     * @param $data The data from item fields.
     * @param $locale
     * @return any
     */
    public static function getValue($value, ?array $data, $locale)
    {
        return $value;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array An array of fields.
     */
    public static function getFields(): array
    {
        return [
            Text::make(__('novaMenuBuilder.route'), 'route')
                ->sortable()
        ];
    }

    /**
     * Get the rules for the resource.
     *
     * @return array A key-value map of attributes and rules.
     */
    public static function getRules(): array
    {
        return [
            'route' => [
                new RouteExists(),
                'required',
                'max:255',
            ]
        ];
    }

    /**
     * Get data of the link visible to the front-end.
     *
     * Can be anything. It is up to you how you will handle parsing it.
     *
     * This will only be called when using the nova_get_menu()
     * and nova_get_menus() helpers or when you call formatForAPI()
     * on the Menu model.
     *
     * @param null $data Field values
     * @return any
     */
    public static function getData($data = null)
    {
        return $data;
    }
}
