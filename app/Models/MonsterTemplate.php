<?php

namespace App\Models;

use Wncms\Models\BaseModel;

class MonsterTemplate extends BaseModel
{
    public static $modelKey = 'monster_template';

    protected $guarded = [];

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];

    public function monsters()
    {
        return $this->hasMany(Monster::class);
    }
}
