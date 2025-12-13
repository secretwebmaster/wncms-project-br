<div class="card mb-3 @if (!empty($dead)) border border-5 border-danger @endif">
    <div class="card-header border-0 px-4 py-2">
        <h3 class="card-title align-items-start d-flex">
            <div class="d-flex flex-column justify-content-center h-100 cursor-pointer symbol symbol-35px symbol-md-40px me-2"
                data-kt-menu-trigger="click"
                data-kt-menu-attach="parent"
                data-kt-menu-placement="bottom-end">
                <img src="{{ $player->thumbnail ?: asset('wncms/media/avatars/blank.png') }}" alt="player">
            </div>

            <div class="d-flex flex-column justify-content-center h-100">
                <a href="{{ route('frontend.players.profile', ['id' => $player->id]) }}" class="fw-bold text-danger text-hover-primary">
                    {{ $player->name }}
                    @role('admin')
                        (#{{ $player->id }})
                    @endrole
                </a>

                <span class="mt-1 fw-semibold fs-7 @if (!empty($dead)) text-danger @else text-muted @endif">
                    @lang('wncms::word.player_stats')
                    @if (!empty($dead))
                        <span> (@lang('wncms::word.player_is_dead'))</span>
                    @endif
                </span>
            </div>
        </h3>

        {{-- 
        <div class="card-toolbar">
            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                data-kt-menu-trigger="click"
                data-kt-menu-placement="bottom-end">
                <span class="svg-icon svg-icon-2">
                    ...
                </span>
            </button>

            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800
                        menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                ...
            </div>
        </div>
        --}}
    </div>

    <div class="card-body px-4 py-2">

        {{-- level --}}
        <div class="d-flex align-items-sm-center mb-1">
            <div class="flex-grow-1">
                <i class="fa-solid fa-star me-2"></i>@lang('wncms::word.player_level')
            </div>
            <span class="badge badge-light fw-bold text-info">{{ $player->level }}</span>
        </div>

        {{-- EXP --}}
        <div class="d-flex align-items-sm-center mb-1">
            <div class="me-10 w-25">
                <i class="fa-solid fa-bolt me-2"></i>@lang('wncms::word.player_exp')
            </div>
            <div class="flex-grow-1">
                <div class="progress h-12px w-100 bg-light-warning position-relative border border-1 border-dark">
                    <span class="status-value text-dark fw-bold value-in-progress-bar me-2">
                        {{ $player->exp }} / {{ $player->exp_next }}
                    </span>
                    <div class="progress-bar bg-warning"
                        style="width: {{ ($player->exp / max(1, $player->exp_next)) * 100 }}%">
                    </div>
                </div>
            </div>
        </div>

        {{-- HP --}}
        <div class="d-flex align-items-sm-center mb-1">
            <div class="me-10 w-25">
                <i class="fa-solid fa-heart me-2"></i>HP
            </div>
            <div class="flex-grow-1">
                @php $hpPercent = $player->hp / max(1, $player->max_hp) * 100; @endphp
                <div class="progress h-12px w-100 position-relative border border-1 border-dark
                    @if ($hpPercent > 50) bg-light-success
                    @elseif($hpPercent > 20) bg-light-warning
                    @else bg-light-danger @endif">
                    <span class="status-value text-dark fw-bold value-in-progress-bar me-2">
                        {{ $player->hp }} / {{ $player->max_hp }}
                    </span>
                    <div class="progress-bar
                        @if ($hpPercent > 50) bg-success
                        @elseif($hpPercent > 20) bg-warning
                        @else bg-danger @endif"
                        style="width: {{ $hpPercent }}%">
                    </div>
                </div>
            </div>
        </div>

        {{-- MP --}}
        <div class="d-flex align-items-sm-center mb-1">
            <div class="me-10 w-25">
                <i class="fa-solid fa-droplet me-2"></i>MP
            </div>
            <div class="flex-grow-1">
                <div class="progress h-12px w-100 bg-light-primary position-relative border border-1 border-dark">
                    <span class="status-value text-dark fw-bold value-in-progress-bar me-2">
                        {{ $player->mp }} / {{ $player->max_mp }}
                    </span>
                    <div class="progress-bar bg-primary"
                        style="width: {{ ($player->mp / max(1, $player->max_mp)) * 100 }}%">
                    </div>
                </div>
            </div>
        </div>

        {{-- ATK --}}
        @php
            // 攻擊能力（用於 battle damage roll，不代表固定傷害）
            $atkPower = (int) $player->final_str + (int) $player->final_atk;
        @endphp

        <div class="d-flex align-items-sm-center mb-1">
            <div class="flex-grow-1">
                <i class="fa-solid fa-gavel me-2"></i>@lang('wncms::word.player_atk')
            </div>

            <span class="badge badge-light fw-bold">
                {{ $atkPower }}

                {{-- 裝備帶來的平面攻擊加成 --}}
                @if ($player->final_atk !== 0)
                    <span class="ms-1
                @if ($player->final_atk > 0) text-success
                @else text-danger @endif">
                        ({{ $player->final_atk > 0 ? '+' : '' }}{{ $player->final_atk }})
                    </span>
                @endif
            </span>
        </div>

        {{-- DEF --}}
        @php
            // 現有系統計算後的防禦值（不動）
            $baseDef = (int) $player->def;

            // 裝備帶來的防禦加成
            $defAddon = (int) $player->final_def;
        @endphp

        <div class="d-flex align-items-sm-center mb-1">
            <div class="flex-grow-1">
                <i class="fa-solid fa-shield me-2"></i>@lang('wncms::word.player_def')
            </div>

            <span class="badge badge-light fw-bold">
                {{ $baseDef }}

                @if ($defAddon !== 0)
                    <span class="ms-1
                @if ($defAddon > 0) text-success
                @else text-danger @endif">
                        ({{ $defAddon > 0 ? '+' : '' }}{{ $defAddon }})
                    </span>
                @endif
            </span>
        </div>

        {{-- base stats --}}
        @foreach (['vit', 'str', 'int', 'dex', 'luc'] as $stat)
            @php
                $base = (int) $player->{$stat};
                $final = (int) data_get($player, 'final_' . $stat);
                $addon = $final - $base;
            @endphp

            <div class="d-flex align-items-sm-center mb-1">
                <div class="flex-grow-1">
                    <i class="fa-solid fa-chart-simple me-2"></i>
                    @lang('wncms::word.player_' . $stat)
                </div>

                <span class="badge badge-light fw-bold">
                    {{ $base }}

                    @if ($addon !== 0)
                        <span class="ms-1
                    @if ($addon > 0) text-success
                    @else text-danger @endif">
                            ({{ $addon > 0 ? '+' : '' }}{{ $addon }})
                        </span>
                    @endif
                </span>
            </div>
        @endforeach

    </div>
</div>
