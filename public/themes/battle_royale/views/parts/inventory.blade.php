{{-- 合成 --}}
<button class="btn btn-sm btn-info w-100 mb-1 fw-bold" data-bs-toggle="modal" data-bs-target="#modal_combine_items">合成物品</button>
<div id="modal_combine_items" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('frontend.items.combine') }}" method="POST" id="game_items_combine">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title">請選擇需要合成的物品</h3>
                </div>
    
                <div class="modal-body">
                    <div class="row">
                        @foreach($player->getItems(null,'all')->sortBy('item.type') as $item)
                            @if(!$item->is_equipped)
                                <div class="col-3 mb-1">
                                    <input class="form-check-input" type="checkbox" name="ingredients[]" value="{{ $item->id }}">
                                    <label class="form-check-label ms-3 text-nowrap fw-bold text-dark">
                                        <div class="symbol symbol-20px d-flex align-items-center">
                                            <img class="me-1" src="{{ $item->item_template?->thumbnail }}" alt="">
                                            <span title="{{ $item->item_template?->description }}">{{ $item->item_template?->name }}</span>
                                        </div>
                                    </label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
    
                <div class="modal-footer row">
                    <button type="button" class="btn btn-light fw-bold col" data-bs-dismiss="modal">關閉</button>
                    <button type="submit" form-id="game_items_combine" class="btn btn-info fw-bold col">合成</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 研磨 --}}
<button class="btn btn-sm btn-info w-100 mb-1 fw-bold" data-bs-toggle="modal" data-bs-target="#modal_upgrade_items">研磨裝備</button>
<div id="modal_upgrade_items" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('frontend.items.upgrade') }}" method="POST" id="game_items_upgrade">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title">請選擇需要研磨的裝備及材料</h3>
                </div>
    
                <div class="modal-body">
                    <div class="row">
                        @foreach($player->getItems(['weapon','body','head','hand','foot'],'all')->sortBy('item.type') as $item)
                            <div class="col-3 mb-1 text-nowrap">
                                <input class="form-check-input" type="radio" name="game_item_id" value="{{ $item->id }}">
                                <label class="form-check-label text-nowrap fw-bold text-dark">
                                    <div class="symbol symbol-20px d-flex align-items-center">
                                        <img class="me-1" src="{{ $item->item_template?->thumbnail }}" alt="">
                                        <span title="{{ $item->item_template?->description }}">{{ $item->item_template?->name }}</span>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
    
                <div class="modal-footer row">
                    <button type="button" class="btn btn-light fw-bold col" data-bs-dismiss="modal">關閉</button>
                    <button type="submit" form-id="game_items_upgrade" class="btn btn-info fw-bold col">合成</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 物品欄 --}}
<div class="card mb-3">
    <div class="card-header border-0 px-4 py-2">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">@lang('wncms::word.inventory')</span>
            <span class="text-muted mt-1 fw-semibold fs-7">@lang('wncms::word.inventory_description')</span>
        </h3>
    </div>

    <div class="card-body px-4 py-2">
        <ul class="ps-0">
            @foreach($player->getItems()->sortBy('item.type')->sortByDesc('is_equipped') as $item)
                <li class="w-100 d-flex mb-1">
                    <div class="symbol symbol-20px d-flex align-items-center position-relative">
                        <img class="me-1" src="{{ $item->item_template?->thumbnail }}" alt="">
                        <span class="my-tooltip-trigger" title="{{ $item->item_template?->description }}">{{ $item->item_template?->name }} @if($item->level)<span class="text-success fw-bold">+{{ $item->level }}</span> @endif</span>
                    </div>
                    @if($item->item_template?->is_equippable())
                        @if($item->is_equipped)
                        <span class="badge badge-danger ms-auto px-2 py-1 btn-unequip-item" role='button' data-item-id="{{ $item->id }}">@lang('wncms::word.unequip')</span>
                        @else
                        <span class="badge badge-info ms-auto px-2 py-1 btn-equip-item" role='button' data-item-id="{{ $item->id }}">@lang('wncms::word.equip')</span>
                        @endif
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
    
    {{-- 可堆疊 --}}
    <div class="card-body px-4 py-2">
        <ul class="ps-0">
            @foreach($player->getItems(null,true,true) as  $item_name => $grouped_items)
                <li class="w-100 d-flex mb-1">
                    <div class="symbol symbol-20px d-flex align-items-center">
                        <img class="me-1" src="{{ $grouped_items->first()->item->thumbnail }}" alt="">
                        <span>{{ $item_name }} ({{ $grouped_items->count() }})</span>
                    </div>
                    @if($grouped_items->first()->item->type == 'food')
                        <span class="badge badge-info ms-auto px-2 py-1 btn-eat-item" role='button' data-item-id="{{ $grouped_items->first()->id }}">@lang('wncms::word.use')</span>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>