<?php

namespace App\Models;


use Wncms\Models\BaseModel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Wncms\Translatable\Traits\HasTranslations;

class ItemTemplate extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
    use HasTranslations;

    public static $modelKey = 'item_template';

    protected $guarded = [];

    protected $equippable_types = [
        'weapon',
        'hand',
        'foot',
        'body',
        'head',
    ];
    protected $consumable_types = [
        'poison',
        'food',
        'bomb',
        'material',
    ];

    protected $casts = [
        'value' => 'array',
    ];

    protected $translatable = ['name', 'description'];

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];

    public const STATUSES = [
        'active',
        'inactive',
    ];

    public const TYPES = [
        'weapon',
        'comsumable',
        'equipment',
        'quest',
        'relic',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('item_template_thumbnail')->singleFile();
    }

    /**
     * ----------------------------------------------------------------------------------------------------
     * ! Relationship
     * ----------------------------------------------------------------------------------------------------
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * ----------------------------------------------------------------------------------------------------
     * ! Attributes Accessor
     * ----------------------------------------------------------------------------------------------------
     */
    public function getThumbnailAttribute()
    {
        $media = $this->getMedia('item_template_thumbnail')->first();
        if ($media) return $media->getUrl();
    }


    public function is_equippable()
    {
        return in_array($this->type, $this->equippable_types);
    }
    public function is_consumable()
    {
        return in_array($this->type, $this->consumable_types);
    }
}
