<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Wncms\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;


class Player extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    public static $modelKey = 'player';

    protected $guarded = [];

    protected $casts = [
        'died_at' => 'datetime',
    ];

    public $menuPriority = 800;

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];

    public const STATUSES = [
        'alive',
        'dead',
    ];

    public const TYPES = [
        'player',
        'npc',
    ];

    /**
     * --------------------------------------------------------------------------
     * Media
     * --------------------------------------------------------------------------
     */

    // 註冊玩家縮圖（單一檔案）
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('player_thumbnail')->singleFile();
    }

    /**
     * --------------------------------------------------------------------------
     * Query Scopes
     * --------------------------------------------------------------------------
     */

    // 依地圖座標查詢玩家
    public function scopeLocation(Builder $query, $x, $y): void
    {
        $query->where('location_x', $x)->where('location_y', $y);
    }

    /**
     * --------------------------------------------------------------------------
     * Attribute Accessors
     * --------------------------------------------------------------------------
     */

    // 取得玩家縮圖 URL
    public function getThumbnailAttribute()
    {
        $media = $this->getMedia('player_thumbnail')->first();
        if ($media) return $media->getUrl();

        return $this->external_thumbnail;
    }

    /**
     * --------------------------------------------------------------------------
     * Relationships
     * --------------------------------------------------------------------------
     */

    // 對應使用者
    public function user()
    {
        return $this->belongsTo(wncms()->getModelClass('user'));
    }

    // 所屬遊戲
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    // 遊戲事件紀錄
    public function game_logs()
    {
        return $this->hasMany(GameLog::class);
    }

    // 玩家擁有的物品
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // 玩家可執行的行為
    public function actions()
    {
        return $this->hasMany(PlayerAction::class);
    }

    /**
     * --------------------------------------------------------------------------
     * Game / Inventory Helpers
     * --------------------------------------------------------------------------
     */

    // 取得玩家可見的遊戲紀錄（含 public）
    public function getGameLogs()
    {
        return $this->game->game_logs()
            ->where(function ($q) {
                $q->where('player_id', $this->id)
                    ->orWhere('type', 'public');
            })
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();
    }

    // 取得玩家目前所在的地圖格子
    public function getCurrentGameLocation()
    {
        return GameLocation::where('game_id', $this->game->id)
            ->where('x', $this->location_x)
            ->where('y', $this->location_y)
            ->first();
    }

    // 取得玩家物品（可依 type / stackable / 是否分組）
    public function getItems($type = null, $is_stackable = false, $group = false)
    {
        $q = $this->items();

        if ($type) {
            if (is_string($type)) {
                $q->whereHas('item_template', fn($q) => $q->where('type', $type));
            } elseif (is_array($type)) {
                $q->whereHas('item_template', fn($q) => $q->whereIn('type', $type));
            }
        }

        if ($is_stackable !== 'all') {
            $q->whereHas(
                'item_template',
                fn($q) => $q->where('is_stackable', (bool) $is_stackable)
            );
        }

        $items = $q->get();

        return $group ? $items->groupBy('item.name') : $items;
    }

    // 依名稱 / slug / id 取得第一個物品
    public function getFirstItem($name)
    {
        return $this->items()
            ->whereHas('item', function ($q) use ($name) {
                $q->where('name', $name)
                    ->orWhere('slug', $name)
                    ->orWhere('id', $name);
            })
            ->first();
    }

    /**
     * --------------------------------------------------------------------------
     * Equipment & Stat Aggregation
     * --------------------------------------------------------------------------
     */

    // 取得玩家目前已裝備的物品
    public function equippedItems()
    {
        return $this->items()
            ->where('is_equipped', true)
            ->whereHas('item_template', function ($q) {
                $q->whereNotNull('slot');
            });
    }

    public function equippedItemsInSlot(string $slot)
    {
        return $this->equippedItems()
            ->whereHas('item_template', function ($q) use ($slot) {
                $q->where('slot', $slot);
            });
    }



    // 聚合所有已裝備物品的數值加成（內部使用）
    protected function aggregateEquippedItemStats(): array
    {
        $stats = [];

        $items = $this->equippedItems()
            ->with('item_template')
            ->get();

        foreach ($items as $item) {
            foreach ($item->getEffectiveValue() as $key => $value) {
                if (!is_numeric($value)) continue;

                $stats[$key] = ($stats[$key] ?? 0) + $value;
            }
        }

        return $stats;
    }

    /**
     * --------------------------------------------------------------------------
     * Final Stat Accessors（唯一對外的裝備後能力值）
     * --------------------------------------------------------------------------
     */

    // 力量（base + 裝備加成）
    public function getFinalStrAttribute(): int
    {
        return (int) $this->str + ($this->aggregateEquippedItemStats()['str'] ?? 0);
    }

    // 體力
    public function getFinalVitAttribute(): int
    {
        return (int) $this->vit + ($this->aggregateEquippedItemStats()['vit'] ?? 0);
    }

    // 敏捷
    public function getFinalDexAttribute(): int
    {
        return (int) $this->dex + ($this->aggregateEquippedItemStats()['dex'] ?? 0);
    }

    // 智力
    public function getFinalIntAttribute(): int
    {
        return (int) $this->int + ($this->aggregateEquippedItemStats()['int'] ?? 0);
    }

    // 幸運
    public function getFinalLucAttribute(): int
    {
        return (int) $this->luc + ($this->aggregateEquippedItemStats()['luc'] ?? 0);
    }

    // 最大 HP（只影響上限，不改當前 hp）
    public function getFinalMaxHpAttribute(): int
    {
        return (int) $this->max_hp + ($this->aggregateEquippedItemStats()['hp'] ?? 0);
    }

    // 最大 MP（只影響上限，不改當前 mp）
    public function getFinalMaxMpAttribute(): int
    {
        return (int) $this->max_mp + ($this->aggregateEquippedItemStats()['mp'] ?? 0);
    }

    // 平面攻擊加成（交由 battle system 使用）
    public function getFinalAtkAttribute(): int
    {
        return (int) ($this->aggregateEquippedItemStats()['atk'] ?? 0);
    }

    // 平面防禦加成
    public function getFinalDefAttribute(): int
    {
        return (int) ($this->aggregateEquippedItemStats()['def'] ?? 0);
    }

    // 爆擊加成
    public function getFinalCritAttribute(): int
    {
        return (int) ($this->aggregateEquippedItemStats()['crit'] ?? 0);
    }

    /**
     * Equip an item for this player (v1 auto-replace by slot).
     */
    public function equipItem(Item $item): void
    {
        if ((int) $item->player_id !== (int) $this->id) {
            throw new InvalidArgumentException('Item does not belong to this player.');
        }

        $template = $item->item_template;
        if (!$template) {
            throw new InvalidArgumentException('Item template not found.');
        }

        if (!$template->isEquippable()) {
            throw new InvalidArgumentException('Item is not equippable.');
        }

        $slot = (string) $template->slot;

        DB::transaction(function () use ($item, $slot) {
            // Unequip all items in same slot first (v1 auto-replace)
            $this->equippedItemsInSlot($slot)->update([
                'is_equipped' => false,
            ]);

            // Equip target item
            $item->update([
                'is_equipped' => true,
            ]);
        });
    }

    /**
     * Unequip an item for this player.
     */
    public function unequipItem(Item $item): void
    {
        if ((int) $item->player_id !== (int) $this->id) {
            throw new InvalidArgumentException('Item does not belong to this player.');
        }

        $item->update([
            'is_equipped' => false,
        ]);
    }
}
