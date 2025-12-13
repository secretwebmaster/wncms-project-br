<?php

namespace App\Models;

use Wncms\Models\BaseModel;

class Achievement extends BaseModel
{
    protected $guarded = [];

    public static $modelKey = 'achievement';

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];
}
