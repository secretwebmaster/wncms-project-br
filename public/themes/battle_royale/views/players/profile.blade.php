@extends("$themeId::layouts.app")

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">@lang('wncms::word.player_profile')</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('frontend.players.profile.update', ['id' => $player->id]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- thumbnail --}}
                            <div class="mb-3">
                                <div class="image-input image-input-outline {{ isset($player) && $player->thumbnail ? '' : 'image-input-empty' }}"
                                    data-kt-image-input="true"
                                    style="background-image:url({{ asset('wncms/images/placeholders/upload.png') }});background-position:center;width:100%;aspect-ratio:1/1;">

                                    <div class="image-input-wrapper w-100 h-100"
                                        style="background-image: {{ isset($player) && $player->thumbnail ? 'url(' . asset($player->thumbnail) . ')' : 'none' }};">
                                    </div>

                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change"
                                        data-bs-toggle="tooltip"
                                        title="@lang('wncms::word.change')">
                                        <i class="fa fa-pencil fs-7"></i>
                                        <input type="file" name="thumbnail" accept="image/*">
                                        <input type="hidden" name="thumbnail_remove">
                                    </label>

                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel"
                                        data-bs-toggle="tooltip"
                                        title="@lang('wncms::word.cancel')">
                                        <i class="fa fa-times"></i>
                                    </span>

                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove"
                                        data-bs-toggle="tooltip"
                                        title="@lang('wncms::word.remove')">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </div>

                                {{-- <div class="form-text">
                                    @lang('wncms::word.allow_file_types', ['types' => 'png, jpg, jpeg, gif'])
                                </div> --}}
                            </div>

                            {{-- name --}}
                            <div class="mb-3">
                                <label class="form-label">@lang('wncms::word.name')</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $player->name) }}">
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-dark w-100 fw-bold">
                                    @lang('wncms::word.save')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
