@extends("$themeId::layouts.app")

@section('content')
<div style="min-height:70vh;display:flex;align-items:center;justify-content:center;">
    <div style="text-align:center;">
        <h1 style="font-size:32px;margin-bottom:16px;">
            @lang('wncms::word.game_title')
        </h1>

        <p style="margin-bottom:24px;opacity:.8;">
            @lang('wncms::word.game_intro')
        </p>

        <a href="{{ route('frontend.games.home') }}"
           style="display:inline-block;padding:14px 32px;border-radius:6px;background:#111;color:#fff;text-decoration:none;font-size:16px;">
            @lang('wncms::word.go_to_game')
        </a>
    </div>
</div>
@endsection
