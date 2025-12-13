@extends("$themeId::layouts.app")
@section('content')

<div class="row g-5 g-xl-8 game-render">
    {{-- Stat + Items --}}
    <div class="col-xl-3">
        {{-- Stat --}}
        <div class="stat-render">
            @include("$themeId::parts.player_stat")
        </div>

        {{-- Items --}}
        <div class="inventory-render">
            @include("$themeId::parts.inventory")
        </div>

        <div class="card mb-3">
            <div class="card-body p-2">
                <h2>@lang('wncms::word.all_players')</h2>
                <div class="bg-dark p-1 my-1">
                    <ul class="ms-0 mb-0 py-2 text-white box-game-logs">
                        @foreach($game->players as $game_player)
                            <li>
                                <span>{{ $game_player->id }}</span>
                                <span>{{ $game_player->name }}</span>
                                <span class="text-warning">({{ $game_player->exp }} / {{ $game_player->exp_next }})</span>
                                <span class="text-success">({{ $game_player->hp }} / {{ $game_player->max_hp }})</span>
                                <span class="float-end me-3">({{ $game_player->location_x }},{{ $game_player->location_y }})</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>

    {{-- Middel --}}
    <div class="col-xl-6">
        {{-- Map --}}
        <div class="map-render">
            @include("$themeId::parts.map")
        </div>

        {{-- Events --}}
        <div class="event-render">
            @include("$themeId::parts.event")
        </div>
    </div>

    {{-- Close Stage + Events + Button --}}
    <div class="col-xl-3">

        {{-- Button --}}        
        <div class="button-render">
            @include("$themeId::parts.button")
        </div>

        {{-- Admin Only --}}
        {{-- <div class="row">
            <div class="col-6">
                <div class="card mb-3">
                    <div class="card-body p-2">
                        <h2>當前地圖Player</h2>
                        <div class="highlight p-1 my-1">
                            <ul class="ms-0 mb-0 py-2 text-white box-game-logs">
                                @foreach($game->players()->where('location_x',$player->get_current_game_location()->x)->where('location_y',$player->get_current_game_location()->y)->get() as $game_player)
                                <li>{{ $game_player->nickname }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-3">
                    <div class="card-body p-2">
                        <h2>items</h2>
                        <div class="highlight p-1 my-1">
                            <ul class="ms-0 mb-0 py-2 text-white box-game-logs">
                                @foreach($player->get_current_game_location()->get_item_list() as $game_item)
                                <li>{{ $game_item->item->name }} ({{ $game_item->item_count }})</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- Action --}}        
        <div class="action-render">
            @include("$themeId::parts.action")
        </div>

    </div>

</div>

@push('foot_js')
{{-- <script src="{{ asset(" custom/js/equip.js?v="). $wn->getVersion('js') }}"></script> --}}

<script>

    reloadButton();

    function updateMap(response) {

        if(response.mapView){
            $('.map-render').html(response.mapView);
            console.log('map updated');
        }
        
        if(response.eventView){
            $('.event-render').html(response.eventView);
            console.log('event updated');
        }
        
        
        if(response.inventoryView){
            $('.inventory-render').html(response.inventoryView);
            console.log('inventory updated');
        }
        

        $('.action-render').html(response.actionView);
        console.log('action updated');


        reloadButton();
    }

    function reloadButton(){
        $('.btn-move').off().on('click', function(){
            var button = $(this);
            button.prop('disabled', true);
            console.log('clicked move');

            var direction = button.data('direction')

            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{ route('frontend.players.move') }}",
                data:{
                    'gameId':{{ $game->id }},
                    'direction': direction,
                },
                type:"POST",
                success:function(response){
                    // console.log(response)

                    //chamge the map value, keep character at center
                    // updateMap(response.locationX, response.locationY);
                    updateMap(response)

                    button.prop('disabled', false);
                }
            });
        })

        $('.btn-confirm-action').off().on('click', function(){
            console.log('btn action confrim clicked');
            var button = $(this);
            button.prop('disabled', true);
            console.log('clicked action confirm');

            var actionId = button.data('action-id');
            var decision = button.data('decision');
            console.log(actionId);
            console.log(decision);
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{ route('frontend.players.action') }}",
                data:{
                    actionId:actionId,
                    decision:decision,
                    gameId:"{{ $game->id }}",
                },
                type:"POST",
                success:function(response){
                    // console.log(response)
                    updateMap(response)
                }
            });
        })

        $('.btn-equip-item').off().on('click', function(){
            var itemId = $(this).data('item-id');
            var gameId = "{{ $game->id }}";
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{ route('frontend.players.equip') }}",
                data:{
                    itemId:itemId,
                    gameId:gameId,
                },
                type:"POST",
                success:function(response){
                    console.log(response)
                    if(response.status == 'success'){
                        updateMap(response);
                        reloadButton();
                    }
                }
            });
        });

        $('.btn-unequip-item').off().on('click', function(){
            var itemId = $(this).data('item-id');
            var gameId = "{{ $game->id }}";
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{ route('frontend.players.unequip') }}",
                data:{
                    itemId:itemId,
                    gameId:gameId,
                },
                type:"POST",
                success:function(response){
                    console.log(response)
                    if(response.status == 'success'){
                        updateMap(response);
                        reloadButton();
                    }
                }
            });
        });

        $('.btn-eat-item').off().on('click', function(){

            var game_item_id = $(this).attr('data-game-item-id')
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"/game/player/eat",
                data:{
                    game_item_id:game_item_id
                },
                type:"POST",
                success:function(data){
                    if(data.status == 'success'){
                        location.reload();
                    }
                }
            });
        });

        $('.btn-upgrade-item').off().on('click', function(){

            var game_item_id = $(this).attr('data-game-item-id')
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"/game/player/upgrade",
                data:{
                    game_item_id:game_item_id
                },
                type:"POST",
                success:function(data){
                    if(data.status == 'success'){
                        location.reload();
                    }
                }
            });
        });
    }



</script>
@endpush
@endsection