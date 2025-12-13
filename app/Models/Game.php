<?php

namespace App\Models;

use Wncms\Models\BaseModel;

class Game extends BaseModel
{
    public static $modelKey = 'game';

    protected $guarded = [];

    public const ICONS = [
        'fontawesome' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];

    public const STATUSES = [
        'active',
        'ended',
    ];

    public $menuPriority = 900;

    //! Relationship
    public function user()
    {
        return $this->belongsTo(wncms()->getModelClass('user'));
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function game_logs()
    {
        return $this->hasMany(GameLog::class);
    }

    public function map()
    {
        return $this->hasOne(Map::class);
    }

    public function saves()
    {
        return $this->hasMany(Save::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function monsters()
    {
        return $this->hasMany(Monster::class);
    }


    //! Handling data
    public function getPlayer()
    {
        return $this->players->where('user_id', auth()->id())->first();
    }

    public function getPlayerCount($status = null)
    {
        if ($status == 'alive') {
            return $this->players()->where('hp', '>', 0)->count();
        } elseif ($status == 'dead') {
            return $this->players()->where('hp', '<=', 0)->count();
        }
        return $this->players()->count();
    }

    public function getOtherPlayers(Player $player, GameLocation $game_location)
    {
        return $this->players()->where('id', '<>', $player->id)->location($game_location)->get();
    }
}
