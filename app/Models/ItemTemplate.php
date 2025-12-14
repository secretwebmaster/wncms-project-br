<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Wncms\Models\BaseModel;
use Wncms\Translatable\Traits\HasTranslations;

class ItemTemplate extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
    use HasTranslations;

    public static $modelKey = 'item_template';

    protected $guarded = [];

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
        'armor',
        'consumable',
        'quest',
        'relic',
    ];

    public const SLOTS = [
        'head',
        'body',
        'hand',
        'foot',
        'shield',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('item_template_thumbnail')->singleFile();
    }

    /**
     * ----------------------------------------------------------------------------------------------------
     * Relationship
     * ----------------------------------------------------------------------------------------------------
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * ----------------------------------------------------------------------------------------------------
     * Attributes Accessor
     * ----------------------------------------------------------------------------------------------------
     */
    public function getThumbnailAttribute()
    {
        $media = $this->getMedia('item_template_thumbnail')->first();
        if ($media) return $media->getUrl();
    }

    public function isEquippable(): bool
    {
        // v1 rule: equippable when type is weapon/armor and slot is valid
        if (!in_array($this->type, ['weapon', 'armor'])) return false;
        if (empty($this->slot)) return false;

        return in_array($this->slot, self::SLOTS);
    }

    public function isConsumable(): bool
    {
        return $this->type === 'consumable';
    }
}
