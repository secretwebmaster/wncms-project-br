<?php

namespace App\Models;

use Wncms\Translatable\Traits\HasTranslations;
use Wncms\Models\BaseModel;

class GameLogTemplate extends BaseModel
{
    use HasTranslations;

    public static $modelKey = 'game_log_template';

    protected $guarded = [];

    protected $translatable = ['content'];

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];

    public const TYPES = [
        'item',
        'battle',
        'story',
        'event',
    ];

    public function variants()
    {
        return $this->hasMany(GameLogTemplateVariant::class);
    }
}
