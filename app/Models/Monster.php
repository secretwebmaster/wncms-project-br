<?php

namespace App\Models;

use Wncms\Models\BaseModel;

class Monster extends BaseModel
{
    public static $modelKey = 'monster';

    protected $guarded = [];

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];

    public function monster_template()
    {
        return $this->belongsTo(MonsterTemaplte::class);
    }

    public function monsters()
    {
        return $this->hasMany(Monster::class);
    }
}
