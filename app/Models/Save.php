<?php

namespace App\Models;

use Wncms\Models\BaseModel;

//% Seem dont neet this because the entire database is the save. Maybe just use to backup
class Save extends BaseModel
{
    public static $modelKey = 'save';

    protected $guarded = [];

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
