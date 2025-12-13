<?php

namespace App\Models;

use Wncms\Models\BaseModel;

class Battle extends BaseModel
{
    public static $modelKey = 'battle';
    
    protected $guarded = [];

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];
    

}
