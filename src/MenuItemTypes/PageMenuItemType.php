<?php

namespace Outl1ne\MenuBuilder\MenuItemTypes;

use Q7digitalmedia\NovaQuisBase\Models\Page;
use Laravel\Nova\Fields\Select;
use Q7digitalmedia\NovaQuisBase\Nova\Fields\Multiselect;

class PageMenuItemType extends MenuItemSelectType
{
    public static function getType(): string
    {
        return 'page';
    }

    /**
     * Get the menu link identifier that can be used to tell different custom
     * links apart (ie 'page' or 'product').
     *
     * @return string
     **/
    public static function getIdentifier(): string {
        return 'page';
    }

    /**
     * Get menu link name shown in  a dropdown in CMS when selecting link type
     * ie ('Product Link').
     *
     * @return string
     **/
    public static function getName(): string {
        return __('novaMenuBuilder.page');
    }

    /**
     * Get list of options shown in a select dropdown.
     *
     * Should be a map of [key => value, ...], where key is a unique identifier
     * and value is the displayed string.
     *
     * @return array
     **/
    public static function getOptions($locale): array {
        return config('nova-quis-base.base_page_model')::all()->pluck('name', 'url->' . $locale)->toArray();
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
        if ($data['page']) {
            $page = config('nova-quis-base.base_page_model')::where('id', $data['page'])
                ->first();

            $value = $page->getTranslation('url', $locale);
        }

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
            Multiselect::make(__('novaMenuBuilder.page'), 'page')
                ->sortable()
                ->singleSelect()
                ->rules('required', 'max:255')
                ->options(config('nova-quis-base.base_page_model')::all()->pluck('name', 'id')->toArray())
        ];
    }

    /**
     * Get the rules for the resource.
     *
     * @return array A key-value map of attributes and rules.
     */
    public static function getRules(): array
    {
        return [];
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
