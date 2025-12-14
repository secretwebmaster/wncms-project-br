<?php

namespace App\Http\Controllers\Frontend;

use App\Services\Managers\PlayerManager;
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
        $otherPlayers = $this->gm->getOtherPlayerOnTile($this->player);
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
        // info($action);

        if (!$action) {
            return response()->json([
                'status' => 'fail',
                'message' => __('wncms::word.player_action_is_not_found'),
            ]);
        }

        if ($action->status !== 'pending') {
            return response()->json([
                'status' => 'fail',
                'message' => 'action already processed',
            ]);
        }

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

            $playerManager = app(PlayerManager::class);

            $result = $playerManager->attack(
                $this->player,
                $target,
                $snapshot
            );

            $logData = [
                'attacker_id' => $this->player->id,
                'defender_id' => $target->id,
                'damage'      => $result['damage'],
                'defender_hp' => $result['hp_after'],
                'killed'      => $result['killed'],
                'is_critical' => $result['is_critical'] ? 1 : 0,
                'hp_before'   => $result['hp_before'],
                'hp_after'    => $result['hp_after'],
                'x'           => $snapshot['location_x'],
                'y'           => $snapshot['location_y'],
            ];

            info("Attack result: " . print_r($logData, true));

            // log attack
            $this->gm->log($this->player, 'player_attack_player', $logData);

            if ($result['killed']) {
                $this->gm->log($this->player, 'player_killed_player', [
                    'player_id'       => $this->player->id,
                    'other_player_id' => $target->id,
                ]);
            }
        }

        //update action
        $action->update([
            'status' => 'completed',
            'decision' => $request->decision,
        ]);

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
        if ($this->player->hp <= 0) {
            return response()->json([
                'status' => 'fail',
                'message' => 'user is dead',
            ]);
        }

        $request->validate([
            'itemId' => 'required|integer',
        ]);

        $item = $this->player->items()
            ->with('item_template')
            ->find($request->itemId);

        if (!$item) {
            return response()->json([
                'status' => 'fail',
                'message' => 'item not found',
            ]);
        }

        try {
            $this->gm->equipItem($this->player, $item);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }

        // render view
        return response()->json([
            'status' => 'success',
            'message' => __('wncms::word.item_equipped'),
            'mapView' => $this->renderMap(),
            'eventView' => $this->renderEvent(),
            'actionView' => $this->renderAction(),
            'inventoryView' => $this->renderInventory(),
        ]);
    }

    public function unequip(Request $request)
    {
        if ($this->player->hp <= 0) {
            return response()->json([
                'status' => 'fail',
                'message' => 'user is dead',
            ]);
        }

        $request->validate([
            'itemId' => 'required|integer',
        ]);

        $item = $this->player->items()->find($request->itemId);

        if (!$item) {
            return response()->json([
                'status' => 'fail',
                'message' => 'item not found',
            ]);
        }

        try {
            $this->gm->unequipItem($this->player, $item);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('wncms::word.item_unequipped'),
            'mapView' => $this->renderMap(),
            'eventView' => $this->renderEvent(),
            'actionView' => $this->renderAction(),
            'inventoryView' => $this->renderInventory(),
        ]);
    }

    public function editProfile($id)
    {
        $player = $this->modelClass::where('id', $id)->whereRelation('user', 'users.id', auth()->id())->first();
        if (!$player) {
            return redirect()->back();
        }

        return $this->view("{$this->theme}::players.profile", [
            'player' => $player,
        ]);
    }

    public function updateProfile(Request $request, $id)
    {
        // dd($request->all());

        $player = $this->modelClass::where('id', $id)->whereRelation('user', 'users.id', auth()->id())->first();
        if (!$player) {
            return redirect()->back();
        }

        $request->validate([
            'name' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->name !== null) {
            $player->update([
                'name' => $request->name,
            ]);
        }

        if ($request->hasFile('thumbnail')) {
            $player
                ->clearMediaCollection('player_thumbnail')
                ->addMediaFromRequest('thumbnail')
                ->toMediaCollection('player_thumbnail');
        }

        return redirect()->route('frontend.games.play', [
            'game' => $player->game->id,
        ])->with('success', __('wncms::word.successfully_updated'));
    }
}
