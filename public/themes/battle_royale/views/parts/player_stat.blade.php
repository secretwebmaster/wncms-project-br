<div class="card mb-3 @if(!empty($dead))border border-5 border-danger @endif">
    <div class="card-header border-0 px-4 py-2">
        <h3 class="card-title align-items-start">
            <div class="d-flex flex-column justify-content-center h-100 cursor-pointer symbol symbol-35px symbol-md-40px me-2" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                <img src="{{ $player->thumbnail ?: asset('wncms/media/avatars/blank.png') }}" alt="user">
            </div>
            <div class="d-flex flex-column justify-content-center h-100">
                <span class="card-label fw-bold text-danger">{{ $player->name }} @role('admin') (#{{ $player->id }}) @endrole</span>
                <span class="mt-1 fw-semibold fs-7 @if(!empty($dead))text-danger @else text-muted @endif">人物數據@if(!empty($dead)) <span class="死亡">(@lang('wncms::word.player_is_dead'))</span> @endif</span>
            </div>
        </h3>
        {{-- <div class="card-toolbar">
            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="5" y="5" width="5" height="5" rx="1" fill="currentColor"></rect>
                            <rect x="14" y="5" width="5" height="5" rx="1" fill="currentColor" opacity="0.3"></rect>
                            <rect x="5" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3"></rect>
                            <rect x="14" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3"></rect>
                        </g>
                    </svg>
                </span>
            </button>
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                <div class="menu-item px-3">
                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
                </div>
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3">Create Invoice</a>
                </div>
                <div class="menu-item px-3">
                    <a href="#" class="menu-link flex-stack px-3">Create Payment
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" aria-label="Specify a target name for future usage and reference" data-kt-initialized="1"></i></a>
                </div>
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3">Generate Bill</a>
                </div>
                <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                    <a href="#" class="menu-link px-3">
                        <span class="menu-title">Subscription</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Plans</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Billing</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Statements</a>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-3">
                            <div class="menu-content px-3">
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications">
                                    <span class="form-check-label text-muted fs-6">Recuring</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="menu-item px-3 my-1">
                    <a href="#" class="menu-link px-3">Settings</a>
                </div>
            </div>
        </div> --}}
    </div>

    <div class="card-body px-4 py-2">
        {{-- level --}}
        <div class="d-flex align-items-sm-center">
            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                <div class="flex-grow-1 me-2"><i class="fa-solid fa-heart me-2"></i>@lang('wncms::word.player_level')</div>
                <span class="badge badge-light fw-bold"><span class="text-info me-1">{{ $player->level }}</span></span>
            </div>
        </div>

        {{-- Exp --}}
        <div class="d-flex align-items-sm-center">
            <div class="d-flex align-items-center flex-row-fluid flex-wrap justity-content-between">
                <div class="me-10 w-25"><i class="fa-solid fa-heart me-2"></i>EXP</div>

                <div class="d-flex align-items-center flex-grow-1">
                    <div class="progress h-12px w-100 bg-light-warning position-relative border border-1 border-dark">
                        <span class="status-value text-dark fw-bold value-in-progress-bar me-2"><span>{{ $player->exp }}</span> / {{ $player->exp_next }}</span>
                        <div class="status-bar progress-bar bg-warning" role="progressbar" style="width: {{ $player->exp/$player->exp_next * 100 }}%" aria-valuenow="{{ $player->exp/$player->exp_next * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- HP --}}
        <div class="d-flex align-items-sm-center">
            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                <div class="me-10 w-25"><i class="fa-solid fa-heart me-2"></i>HP</div>

                <div class="d-flex align-items-center flex-grow-1">
                    <div class="progress h-12px w-100 @if($player->hp/$player->max_hp * 100 > 50) bg-light-success @elseif($player->hp/$player->max_hp * 100 > 20) bg-light-warning @else bg-light-danger @endif position-relative border border-1 border-dark">
                        <span class="status-value text-dark fw-bold value-in-progress-bar me-2"><span class="current-health">{{ $player->hp }}</span> / {{ $player->max_hp }}</span>
                        <div class="status-bar progress-bar @if($player->hp/$player->max_hp * 100 > 50) bg-success @elseif($player->hp/$player->max_hp * 100 > 20) bg-warning @else bg-danger @endif" role="progressbar" style="width: {{ $player->hp/$player->max_hp * 100 }}%" aria-valuenow="{{ $player->hp/$player->max_hp * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

            </div>
        </div>

        {{-- MP --}}
        <div class="d-flex align-items-sm-center">
            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                <div class="me-10 w-25"><i class="fa-solid fa-heart me-2"></i>MP</div>
                <div class="d-flex align-items-center flex-grow-1">
                    <div class="progress h-12px w-100 bg-light-primary position-relative border border-1 border-dark">
                        <span class="status-value text-dark fw-bold value-in-progress-bar me-2"><span class="current-health">{{ $player->mp }}</span> / {{ $player->max_mp }}</span>
                        <div class="status-bar progress-bar bg-primary" role="progressbar" style="width: {{ $player->mp/$player->max_mp * 100 }}%" aria-valuenow="{{ $player->mp/$player->max_mp * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- atk --}}
        <div class="d-flex align-items-sm-center">
            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                <div class="flex-grow-1 me-2"><i class="fa-solid fa-heart me-2"></i>@lang('wncms::word.player_atk')</div>
                <span class="badge badge-light fw-bold">{{ number_format((float)$player->minAtk, 0, '.', '') }} - {{ number_format((float)$player->maxAtk, 0, '.', '') }}</span>
            </div>
        </div>

        {{-- def --}}
        <div class="d-flex align-items-sm-center">
            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                <div class="flex-grow-1 me-2"><i class="fa-solid fa-heart me-2"></i>@lang('wncms::word.player_def')</div>
                <span class="badge badge-light fw-bold">{{ number_format((float)$player->def, 0, '.', '') }}</span>
            </div>
        </div>

        {{-- def --}}
        @foreach(['vit','str','int','dex','luc'] as $basic_stat)
        <div class="d-flex align-items-sm-center">
            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                <div class="flex-grow-1 me-2"><i class="fa-solid fa-heart me-2"></i>@lang('wncms::word.player_' . $basic_stat)</div>
                <span class="badge badge-light fw-bold">{{ $player->{$basic_stat} }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>