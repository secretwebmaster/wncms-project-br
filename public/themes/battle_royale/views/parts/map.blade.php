@include('wncms::backend.parts.message')

@php
    $visibleRadius ??= 5;
    $visibleX ??= 7;
    $visibleY ??= 4;
    $centerX = $player->location_x;
    $centerY = $player->location_y;
    $minX = $centerX - ($visibleX ?? $visibleRadius);
    $minY = $centerY - ($visibleY ?? $visibleRadius);
    $maxX = $centerX + ($visibleX ?? $visibleRadius);
    $maxY = $centerY + ($visibleY ?? $visibleRadius);
@endphp

<div class="card mb-xl-8">
    {{-- <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <div class="d-flex align-items-center mb-3">
                <span class="card-label fw-bold text-dark">地圖</span>
                <span class="badge badge-dark">當前座標為: {{ $player->location_x }} , {{ $player->location_y }}</span>
                <span class="badge badge-dark ms-1">總人數: {{ $game->getPlayerCount() }}</span>
                <span class="badge badge-success ms-1">生存人數: {{ $game->getPlayerCount('alive') }}</span>
                <span class="badge badge-danger ms-1">死亡人數: {{ $game->getPlayerCount('dead') }}</span>
            </div>
            <span class="text-muted mt-1 fw-semibold fs-7">點擊前往地點</span>
        </h3>
    </div> --}}

    <div class="card-body p-0">
        {{-- 格網 --}}
        <div class="map-wrapper">
            @for($y = $minY; $y <= $maxY; $y++)
                @for($x = $minX; $x <= $maxX; $x++)
                    <div class="map-tile-wrapper 
                            @if($player->location_x == $x && $player->location_y == $y) current-location @endif 
                            @if($items->where('x', $x)->where('y', $y)->first()) has-item @endif
                            @if($players->where('location_x', $x)->where('location_y', $y)->first()) has-other-player @endif
                        " 
                        style="width: calc(100% / {{ (($visibleX ?? $visibleRadius) * 2) + 1 }});">
                        <div class="map-tile d-flex justify-content-center align-items-center">
                            <div class="p-2 text-center map-tile-info">
                                <span class="map-tile-coordinate" data-x="{{ $x }}" data-y="{{ $y }}">{{ $x }} , {{ $y }}</span>
                            </div>
                        </div>

                        @if($player->location_x == $x && $player->location_y == $y)
                            <div class="player-avatar-wrapper">
                                <img src="{{ $player->thumbnail ?: asset('wncms/images/logos/favicon.png') }}" alt="">
                            </div>
                        @endif

                        @foreach($players->where('location_x', $x)->where('location_y', $y) as $otherPlayer)
                            <div class="player-avatar-wrapper">
                                <img src="{{ $otherPlayer->thumbnail ?: asset('wncms/images/logos/favicon.png') }}" alt="">
                            </div>
                        @endforeach
                    </div>

                @endfor
            @endfor
        </div>
        
        {{-- <div class="row g-1">
            @foreach($game->game_locations->sortBy('x')->sortBy('y') as $game_location)
                <div class="col-1 @if($player->currentCoordinate == $game_location->coordinate)current-location @endif @if($player->previousCoordinate == $game_location->coordinate)previous-location @endif" style="width:{{ 100 / get_system_setting('map_size_x') }}%">
                    <div class="map-tile square d-flex justify-content-center align-items-center @if($game_location->is_closed) bg-light-danger text-muted @elseif($game_location->location->type == 'building') bg-dark fw-bold text-white rounded select-map-tile @else bg-secondary select-map-tile @endif" data-x="{{ $game_location->x }}" data-y="{{ $game_location->y }}">
                        <div class="p-2 text-center map-tile-info">
                            <span class="map-tile-coordinate">{{ $game_location->x }} , {{ $game_location->y }}</span>
                            <div class="symbol symbol-30px">
                                @if($game_location->is_closed)
                                <img src="{{ asset('custom/images/symbols/delete-sign.png') }}" alt="">
                                @elseif($game_location->location->type != 'land')
                                <img src="{{ $game_location->location->icon }}" alt="">
                                @endif
                                <div class="map-location-name @if($game_location->is_closed) text-gray-300 @elseif($game_location->location->type == 'land') text-muted @endif">{{ $game_location->location->name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> --}}
    </div>
</div>
