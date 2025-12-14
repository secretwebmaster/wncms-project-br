<div class="card mb-3">
    <div class="card-body p-0">
        <div class="bg-dark p-1 my-1 min-h-100px mh-200px overflow-scroll rounded shadow">
            <ul class="ms-0 mb-0 py-2 text-white box-game-logs">
                @foreach($game_logs as $game_log)
                <li>{!! $game_log->render($player) !!} <span class="small text-muted ms-auto">({{ $game_log->created_at->diffForHumans() }})</span></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>