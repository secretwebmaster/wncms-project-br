<?php

namespace App\Models;

use App\Services\Managers\GameManager;
use Wncms\Models\BaseModel;

class GameLog extends BaseModel
{
    public static $modelKey = 'game_log';

    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
    ];

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

    public function game_log_template()
    {
        return $this->belongsTo(GameLogTemplate::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    //! Handle data
    public function render(Player $viewerPlayer)
    {
        $gm = new GameManager($this->game, $viewerPlayer);

        return $gm->renderGameLog($this, $viewerPlayer);
    }
}
