@extends("$themeId::layouts.app")

@push('head_css')
<style>
.game-index {
    max-width: 900px;
    margin: 0 auto;
    padding: 32px 16px;
}

.game-index h1 {
    font-size: 28px;
    margin-bottom: 16px;
}

.game-index .desc {
    margin-bottom: 24px;
    opacity: .75;
}

.game-list {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 32px;
}

.game-list ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.game-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 8px;
    border-bottom: 1px solid #eee;
}

.game-list li:last-child {
    border-bottom: none;
}

.game-meta {
    display: flex;
    gap: 12px;
    font-size: 13px;
    opacity: .7;
}

.game-status {
    font-weight: 600;
}

.game-empty {
    padding: 24px;
    text-align: center;
    opacity: .6;
}

.game-actions {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.game-actions button {
    padding: 12px 24px;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
}

.btn-new {
    border: 1px solid #111;
    background: #fff;
    color: #111;
}
</style>
@endpush

@section('content')
<div class="game-index">

    <h1>@lang('wncms::word.game_list')</h1>

    <p class="desc">@lang('wncms::word.choose_game_or_start')</p>

    <div class="game-list">
        @if ($activeGames->isEmpty())
            <div class="game-empty">
                @lang('wncms::word.no_active_games')
            </div>
        @else
            <ul>
                @foreach ($activeGames as $game)
                    <li>
                        <div>
                            <div>
                                @lang('wncms::word.game') #{{ $game->id }}
                            </div>
                            <div class="game-meta">
                                <span class="game-status">{{ ucfirst($game->status) }}</span>
                                <span>{{ $game->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('frontend.games.play', ['game' => $game->id]) }}" class="btn btn-dark fw-bold">
                                @lang('wncms::word.join')
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="game-actions">
        <form action="{{ route('frontend.games.start') }}" method="POST">
            @csrf
            <input type="hidden" name="is_new_game" value="1">
            <button type="submit" class="btn-new">
                @lang('wncms::word.new_game')
            </button>
        </form>
    </div>

</div>
@endsection
