<?php

namespace Outl1ne\MenuBuilder\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Outl1ne\MenuBuilder\MenuBuilder;
use Q7digitalmedia\NovaQuisEshop\Factories\MenuFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(MenuBuilder::getMenusTableName());
    }

    public function rootMenuItems()
    {
        return $this
            ->hasMany(MenuBuilder::getMenuItemClass())
            ->where('parent_id', null)
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public function formatForAPI($locale)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'locale' => $locale,
            'menuItems' => $this->rootMenuItems
                ->where('locale', $locale)
                ->values()
                ->map(function ($menuItem) {
                    return $this->formatMenuItem($menuItem);
                })
        ];
    }

    public function formatMenuItem($menuItem)
    {
        $return = [
            'id' => $menuItem->id,
            'name' => $menuItem->name,
            'type' => $menuItem->type,
            'value' => $menuItem->customValue,
            'target' => $menuItem->target,
            'enabled' => $menuItem->enabled,
            'data' => $menuItem->customData,
            'children' => empty($menuItem->children) ? [] : $menuItem->children->map(function ($item) {
                return $this->formatMenuItem($item);
            })
        ];

        if ($menuItem->type == 'page') {
            $page = config('nova-quis-base.base_page_model')::query()
                ->where('id', $menuItem->customData['page'])
                ->first();

            $return['page'] = $page;
        }

        return $return;
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): MenuFactory
    {
        return MenuFactory::new();
    }
}
