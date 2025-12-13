<?php

namespace App\Models;

use Wncms\Models\BaseModel;

class Map extends BaseModel
{
    public static $modelKey = 'map';

    protected $guarded = [];

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];

    public const TYPES = [
        'standard',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function items()
    {
        return $this->hasMany(Items::class);
    }

    public function monsters()
    {
        return $this->hasMany(Monsters::class);
    }
}
