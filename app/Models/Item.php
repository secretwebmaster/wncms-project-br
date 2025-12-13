<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Wncms\Models\BaseModel;

class Item extends BaseModel
{
    public static $modelKey = 'item';

    protected $guarded = [];

    protected $casts = [
        'value' => 'array',
    ];

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];

    //!Scope
    public function scopeLocation(Builder $query, $x, $y): void
    {
        $query->where('x', $x)->where('y', $y);
    }

    public function item_template()
    {
        return $this->belongsTo(ItemTemplate::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }


}
