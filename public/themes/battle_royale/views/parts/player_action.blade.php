<form action="{{ route('frontend.players.action') }}" id="player_action" method="POST" class="w-100">
    @csrf
    <input type="hidden" name="player_choice" data-player-option='{{ $player_option->id ?? '' }}' value="">
    <input type="hidden" name="player_option_id" value='{{ $player_option->id ?? '' }}'>
    <div class="row g-1">
        @foreach(json_decode($player_option->options, true) as $index => $option)
            <div class="col-xl-4 col-lg-6 col-md-4">
                <button type="button" 
                    class="btn btn-sm btn-info rounded fw-bold text-nowrap w-100 px-2 @if($option != 'drop_item_to_body') btn-action-submit @endif" 
                    form="player_action" 
                    data-value="{{ $option }}"
                    @if($option == 'drop_item_to_body') data-bs-toggle="modal" data-bs-target="#modal_drop_item_to_body" @endif
                    >@lang('wncms::word.' . $option)</button>
            </div>
            
            @if($option == 'drop_item_to_body')
                <div class="modal fade" tabindex="-1" id="modal_drop_item_to_body">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h3 class="modal-title">遺擇想要棄置的物品</h3>
                
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                    <span class="svg-icon svg-icon-1"></span>
                                </div>
                                <!--end::Close-->
                            </div>
                
                            <div class="modal-body drop-item-list">
                                <ul class="ps-0">
                                    @foreach($player->getItems() as $item)
                                    <li class="w-100 d-flex mb-1">
                                        <input type="checkbox" class="form-check me-1" name="game_item_ids[{{ $item->id }}]">
                                        <span title="{{ $item->item_template?->description }}">{{ $item->item_template?->name }}</span>
                                        @if($item->item_template?->isEquippable())
                                            @if($item->is_equipped)
                                            <span class="badge badge-danger ms-auto px-2 py-1"  data-game-item-id="{{ $item->id }}">@lang('wncms::word.equipped')</span>
                                            @endif
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-primary btn-action-submit" data-value="{{ $option }}">棄置</button>
                            </div>
    
                        </div>
                    </div>
                </div>
            @endif

        @endforeach
    </div>
</form>

<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        $('.btn-action-submit').on('click', function(e){
            e.preventDefault();

            //change action
            var action = $(this).attr('data-value');
            $('#player_action input[name="player_choice"]').val(action);

            //submit form
            $('#player_action').submit();
        })


    })
</script>

