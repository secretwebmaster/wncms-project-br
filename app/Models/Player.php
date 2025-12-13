<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Builder;
use Wncms\Models\BaseModel;

class Player extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    public static $modelKey = 'player';

    protected $guarded = [];

    protected $casts = [
        'died_at' => 'datetime',
    ];

    public $menuPriority = 800;

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];

    public const STATUSES = [
        'alive',
        'dead',
    ];

    public const TYPES = [
        'player',
        'npc',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('player_thumbnail')->singleFile();
    }


    /**
     * ----------------------------------------------------------------------------------------------------
     * ! Scope
     * ----------------------------------------------------------------------------------------------------
     */
    public function scopeLocation(Builder $query, $x, $y): void
    {
        $query->where('location_x', $x)->where('location_y', $y);
    }


    /**
     * ----------------------------------------------------------------------------------------------------
     * ! Attributes Accessor
     * ----------------------------------------------------------------------------------------------------
     */
    public function getThumbnailAttribute()
    {
        $media = $this->getMedia('player_thumbnail')->first();
        if ($media) return $media->getUrl();
        return $this->external_thumbnail;
    }





    //! Relationship
    public function user()
    {
        return $this->belongsTo(wncms()->getModelClass('user'));
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function game_logs()
    {
        return $this->hasMany(GameLog::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function actions()
    {
        return $this->hasMany(PlayerAction::class);
    }


    //! Handling data

    //! Query
    public function getGameLogs()
    {
        return $this->game->game_logs()
            ->where(function ($q) {
                $q->where('player_id', $this->id)->orWhere('type', 'public');
            })
            ->orderBy('id', 'desc')->limit(100)->get();
    }

    public function getCurrentGameLocation()
    {
        return GameLocation::where('game_id', $this->game->id)->where('x', $this->location_x)->where('y', $this->location_y)->first();
    }

    public function getItems($type = null, $is_stackable = false, $group = false)
    {
        $q = $this->items();

        if ($type) {
            if (gettype($type) == 'string') {
                $q->whereHas('item_template', fn($q) => $q->where('type', $type));
            } elseif (gettype($type) == 'array') {
                $q->whereHas('item_template', fn($q) => $q->whereIn('type', $type));
            }
        }

        if ($is_stackable === 'all') {
        } elseif (!$is_stackable) {
            $q->whereHas('item_template', fn($q) => $q->where('is_stackable', false));
        } else {
            $q->whereHas('item_template', fn($q) => $q->where('is_stackable', true));
        }



        if ($group) {
            $items = $q->get()->groupBy('item.name');
        } else {
            $items = $q->get();
        }

        return $items;
    }

    public function getFirstItem($name)
    {
        return $this->items()->whereHas('item', function ($q) use ($name) {
            $q->where('name', $name)->orWhere('slug', $name)->orWhere('id', $name);
        })->first();
    }
}
