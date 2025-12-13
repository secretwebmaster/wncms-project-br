@if (!empty($actions))
    @foreach ($actions as $action)
        {{-- @dd($action->options) --}}
        <div class="card">
            <div class="card-body px-4 py-2">
                @if ($action->type == 'item')
                    @php
                        $itemType = $action->options['pick']['item']['item_template']['type'] ?? '未知類型';
                        $translations = collect($itemName = $action->options['pick']['item']['item_template']['translations']);
                        $itemName = __('wncms::word.unknow');
                        if ($translations->isNotEmpty()) {
                            $itemName =
                                $translations
                                    ->where('field', 'name')
                                    ->where('locale', wncms()->getLocale())
                                    ->first()['value'] ?? $itemName;
                        }
                    @endphp

                    <h6>撿起 <span class="item-type">[@lang('wncms::word.' . $itemType)]</span><span class="item-name">[{{ $itemName }}]</span> 嗎?</h6>
                    <div class="action-button d-flex">
                        @foreach ($action->options as $optionKey => $optionData)
                            <button class="btn btn-sm btn-success w-100 m-1 btn-confirm-action" data-action-id="{{ $action->id }}" data-decision="{{ $optionKey }}">@lang('wncms::word.' . $optionKey)</button>
                        @endforeach
                    </div>
                @elseif($action->type == 'battle')
                    @php
                        $targetPlayerName = $action->options['attack']['target']['name'];
                    @endphp
                    <h6>遇到了<span class="target-player-name">[{{ $targetPlayerName }}]</span> ，要攻擊他嗎?</h6>
                    <div class="action-button d-flex">
                        @foreach ($action->options as $optionKey => $optionData)
                            <button class="btn btn-sm btn-success w-100 m-1 btn-confirm-action" data-action-id="{{ $action->id }}" data-decision="{{ $optionKey }}">@lang('wncms::word.' . $optionKey)</button>
                        @endforeach
                    </div>
                @else
                @endif
            </div>
        </div>
    @endforeach
@endif
