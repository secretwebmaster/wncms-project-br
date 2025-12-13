<?php

namespace App\Http\Controllers\Frontend;


use Illuminate\Http\Request;
use Wncms\Http\Controllers\Frontend\FrontendController;
use App\Traits\GameTraits;

class PlayerController extends FrontendController
{
    use GameTraits;

    public function move(Request $request)
    {
        info("player is moving");
        info($request->all());

        $this->player = $this->game->players()->whereRelation('user', 'users.id', auth()->id())->latest()->first();
        if (!$this->player) return response()->json(['status' => 'fail', 'message' => __('wncms::word.player_is_not_found')]);

        $this->gm->playerMove($this->player, $request->direction);
        $this->mapRange = $this->gm->getMapRange($this->player);

        //random event

        //cancel other action
        $this->player->actions()->where('status', 'pending')->update(['status' => 'cancelled']);
        info("Pending action count = " . $this->player->actions()->where('status', 'pending')->count());
        info("all action are cancelled");
        //generate random item
        $this->gm->generateRandomItem($this->mapRange['x'], $this->mapRange['y']);

        //check if there is item in current slot
        $tileItems = $this->gm->getItemOnTile($this->player->location_x, $this->player->location_y);
        info("Found " . $tileItems->count() . " tileItems");

        //check if there are other players
        $otherPlayers = $this->gm->getOhterPlayerOnTile($this->player);
        if ($otherPlayers->count()) {
            //pick one
            $randomPlayer = $otherPlayers->random(1)->first();
            $this->gm->log($this->player, 'player_meet_player', [
                'player_id' => $this->player->id,
                'other_player_id' => $randomPlayer->id,
            ]);

            $this->player->actions()->create([
                'type' => 'battle',
                'status' => 'pending',
                'options' => [
                    'attack' => ['target' => $randomPlayer],
                ],
            ]);
        }
        info("Found " . $otherPlayers->count() . " other players");

        if ($tileItems) {
            //genterate actions
            foreach ($tileItems as $tileItem) {
                $this->player->actions()->create([
                    'type' => 'item',
                    'status' => 'pending',
                    'options' => [
                        'pick' => ['item' => $tileItem->load('item_template')],
                    ],
                ]);
            }
        }

        //render view
        $mapView = $this->renderMap();
        $eventView = $this->renderEvent();
        $actionView = $this->renderAction();
        $inventoryView = $this->renderInventory();


        // info($mapView);
        return response()->json([
            'status' => 'success',
            'message' => __('wncms::word.successfully_created'),
            'mapView' => $mapView,
            'eventView' => $eventView,
            'actionView' => $actionView,
            'inventoryView' => $inventoryView,
            'locationX' => $this->player->location_x,
            'locationY' => $this->player->location_y,
        ]);
    }

    public function action(Request $request)
    {
        info($request->all());
        if (!$this->game) return response()->json(['status' => 'fail', 'message' => __('wncms::word.game_is_not_found')]);

        $this->player = $this->game->players()->whereRelation('user', 'users.id', auth()->id())->latest()->first();
        if (!$this->player) return response()->json(['status' => 'fail', 'message' => __('wncms::word.player_is_not_found')]);

        //get action
        $action = $this->player->actions()->find($request->actionId);
        if (!$action) {
            return response()->json([
                'status' => 'fail',
                'message' => __('wncms::word.player_action_is_not_found'),
            ]);
        }

        //update action
        $action->update([
            'status' => 'completed',
            'decision' => $request->decision,
        ]);

        //!update effect
        //update item
        if ($action->type == 'item') {
            if ($request->decision == 'pick') {
                $item = $this->game->items()
                    ->location($this->player->location_x, $this->player->location_y)
                    ->find($action->options['pick']['item']['id']);

                if (!$item) {
                    return response()->json([
                        'status' => 'success',
                        'message' => __('wncms::word.item_does_not_exist_probably_destroyed'),
                    ]);
                } else {
                    $item->update([
                        'player_id' => $this->player->id,
                        'x' => null,
                        'y' => null,
                        'z' => null,
                    ]);

                    $log = $this->gm->log($this->player, 'player_found_item', [
                        'player_id' => $this->player->id,
                        'item_id' => $item->id,
                    ]);
                    // info($log);
                }
                //TODO check if item already being picked

            }
        }

        // attack
        info($action);
        if ($action->type === 'battle' && $request->decision === 'attack') {

            $snapshot = $action->options['attack']['target'] ?? null;

            if (!$snapshot || empty($snapshot['id'])) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'invalid battle target',
                ]);
            }

            // re-fetch real target
            $target = $this->game->players()
                ->where('id', $snapshot['id'])
                ->first();

            if (!$target || $target->status !== 'alive') {
                return response()->json([
                    'status' => 'fail',
                    'message' => __('wncms::word.player_is_not_found'),
                ]);
            }

            // must still be on same tile (use snapshot location)
            if (
                $target->location_x !== $snapshot['location_x'] ||
                $target->location_y !== $snapshot['location_y']
            ) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'target already moved away',
                ]);
            }

            // ===== damage calculation (use snapshot stats) =====
            $attackerStr = max(1, (int) $this->player->str);
            $defenderVit = (int) ($snapshot['vit'] ?? $target->vit);

            $baseDamage = $attackerStr;
            $defense = floor($defenderVit / 2);
            $damage = max(1, $baseDamage - $defense);

            // critical hit (use snapshot luc)
            $luc = (int) ($this->player->luc ?? 0);
            $critChance = min(30, $luc * 2);
            $isCrit = rand(1, 100) <= $critChance;

            if ($isCrit) {
                $damage *= 2;
            }

            // ===== apply damage =====
            $hpBefore = $target->hp;
            $hpAfter = max(0, $hpBefore - $damage);

            $target->update([
                'hp' => $hpAfter,
                'status' => $hpAfter <= 0 ? 'dead' : 'alive',
                'died_at' => $hpAfter <= 0 ? now() : null,
            ]);

            // log
            $this->gm->log($this->player, 'player_attack_player', [
                'attacker_id' => $this->player->id,
                'defender_id' => $target->id,
                'damage' => $damage,
                'defender_hp' => $hpAfter,
                'killed' => $hpAfter <= 0,

                'is_critical' => $isCrit ? 1 : 0,
                'hp_before' => $hpBefore,
                'hp_after' => $hpAfter,
                'x' => $snapshot['location_x'],
                'y' => $snapshot['location_y'],
            ]);

            if ($hpAfter <= 0) {
                $this->player->increment('kill');

                $this->gm->log($this->player, 'player_killed_player', [
                    'player_id' => $this->player->id,
                    'other_player_id' => $target->id,
                ]);
            }
        }

        //update stat

        //render view
        $mapView = $this->renderMap();
        $eventView = $this->renderEvent();
        $actionView = $this->renderAction();
        $inventoryView = $this->renderInventory();


        return response()->json([
            'status' => 'success',
            'message' => __('wncms::word.action_confirmed'),
            'mapView' => $mapView,
            'eventView' => $eventView,
            'actionView' => $actionView,
            'inventoryView' => $inventoryView,
            'locationX' => $this->player->location_x,
            'locationY' => $this->player->location_y,
        ]);
    }

    public function equip(Request $request)
    {
        // info($request->all());
        if ($this->player->hp <= 0) {
            return response()->json([
                'status' => 'fail',
                'message' => 'user is dead',
            ]);
        };

        // info($this->player->hp);
        $item = $this->player->items()->find($request->itemId);
        if (!$item) {
            return response()->json([
                'status' => 'fail',
                'message' => 'item not found',
            ]);
        }

        //unequip same type item
        $this->player->items()->whereRelation('item_template', 'type', $item->item_template->type)->where('is_equipped', true)->update(['is_equipped' => false]);
        $success = $item->update(['is_equipped' => true]);

        if ($success) {
            $log = $this->gm->log($this->player, 'player_equipped_item', [
                'player_id' => $this->player->id,
                'item_id' => $item->id,
            ]);
        }

        //render view
        $mapView = $this->renderMap();
        $eventView = $this->renderEvent();
        $actionView = $this->renderAction();
        $inventoryView = $this->renderInventory();

        // info($inventoryView);

        if ($success) {
            return response()->json([
                'status' => 'success',
                'message' => __('wncms::word.item_equipped'),
                'mapView' => $mapView,
                'eventView' => $eventView,
                'actionView' => $actionView,
                'inventoryView' => $inventoryView,
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => __('wncms::word.item_not_equipped'),
                'mapView' => $mapView,
                'eventView' => $eventView,
                'actionView' => $actionView,
                'inventoryView' => $inventoryView,
            ]);
        }
    }

    public function unequip(Request $request)
    {
        // info($request->all());
        if ($this->player->hp <= 0) {
            return response()->json([
                'status' => 'fail',
                'message' => 'user is dead',
            ]);
        };

        // info($this->player->hp);
        $item = $this->player->items()->find($request->itemId);
        if (!$item) {
            return response()->json([
                'status' => 'fail',
                'message' => 'item not found',
            ]);
        }

        $success = $item->update(['is_equipped' => false]);


        if ($success) {
            $log = $this->gm->log($this->player, 'player_unequipped_item', [
                'player_id' => $this->player->id,
                'item_id' => $item->id,
            ]);
        }

        //render view
        $mapView = $this->renderMap();
        $eventView = $this->renderEvent();
        $actionView = $this->renderAction();
        $inventoryView = $this->renderInventory();

        if ($success) {

            return response()->json([
                'status' => 'success',
                'message' => 'item unequipped',
                'mapView' => $mapView,
                'eventView' => $eventView,
                'actionView' => $actionView,
                'inventoryView' => $inventoryView,
            ]);
        }
    }
}
