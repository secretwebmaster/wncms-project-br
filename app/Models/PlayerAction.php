<?php

namespace App\Models;

use Wncms\Models\BaseModel;

class PlayerAction extends BaseModel
{
    public static $modelKey = 'player_action';

    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
    ];

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];

    public const STATUSES = [
        'pending',
        'completed',
        'cancelled',
    ];

    // public const TYPES = [
    //     'move',
    //     'pick_item',
    //     'battle',
    //     'use_item',
    //     'quest',
    // ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
