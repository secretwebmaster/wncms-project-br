<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="UTF-8">
        <title>{{ $page_title ?? $website->site_name }}</title>

        {{-- Meta --}}
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="keywords" content="{{ $website->site_seo_keywords }}">
        <meta name="description" content="{{ $website->site_seo_description }}">
        {!! $website->meta_verification !!}

        {{-- Favicon --}}
        <link rel="shortcut icon" type="image/x-icon" href="{{ $website->site_favicon ?: asset('wncms/images/logos/favicon.png') }}">

        {{-- CSS --}}
        <link rel="stylesheet" href="{{ asset('wncms/plugins/global/plugins.bundle.css') . wncms()->addVersion('css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('wncms/css/style.bundle.css') . wncms()->addVersion('css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('wncms/css/core.css') . $wncms->addVersion('css') }}" type="text/css">
        <link rel="stylesheet" href="{{ wncms()->theme()->asset($themeId, 'css/style.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">

        @stack('head_css')
        <style>
            {!! gto('head_css') !!}
        </style>

        @stack('head_js')
        {!! $website->head_code !!}
    </head>

    <body id="wncms_body"
        data-kt-app-layout="dark-sidebar"
        data-kt-app-header-fixed="true"
        data-kt-app-sidebar-fixed="true"
        data-kt-app-sidebar-hoverable="true"
        data-kt-app-sidebar-push-header="true"
        data-kt-app-sidebar-push-toolbar="true"
        data-kt-app-sidebar-push-footer="true"
        data-kt-app-toolbar-enabled="true"
        class="@stack('body_class') header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed app-default"
        style="--wncms-toolbar-height:55px;--wncms-toolbar-height-tablet-and-mobile:55px"
        data-kt-name="wncms">

        <div class="d-flex flex-column flex-root app-root" id="wncms_app_root">
            <div class="app-page flex-column flex-column-fluid" id="wncms_app_page">

                {{-- Header --}}
                @include(wncms()->theme()->view($themeId, 'parts.header'))

                {{-- Main Content --}}
                <div class="app-wrapper flex-column flex-row-fluid p-1 p-md-0" id="wncms_app_wrapper">

                    {{-- Sidebar --}}
                    @include('wncms::backend.parts.sidebar')

                    <div class="app-main flex-column flex-row-fluid" id="wncms_app_main">

                        <style>
                            .global-notification-message {
                                background-color: var(--wncms-success-light);
                                color: var(--wncms-success);
                                padding: 5px 20px;
                                display: none
                            }

                            .global-notification-message a {
                                display: none;
                                color: var(--wncms-success);
                                font-weight: bold;
                            }

                            .global-notification-message a:hover {
                                color: var(--wncms-success);
                                text-decoration: underline;
                            }

                            .global-notification-message-title {}
                        </style>

                        <div class="global-notification-message">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="global-notification-message-title"></div>
                                <div class="global-notification-message-url"><a href="javascript:;"></a></div>
                            </div>
                        </div>

                        {{-- Sidebar --}}
                        @include(wncms()->theme()->view($themeId, 'parts.sidebar'))

                        <div class="d-flex flex-column flex-column-fluid">

                            {{-- Breadcrum  需要傳參數 --}}
                            {{-- @include('wncms::backend.parts.toolbar') --}}

                            {{-- Content --}}
                            <div id="wncms_app_content" class="app-content flex-column-fluid">
                                <div id="wncms_app_content_container" class="app-container container-fluid h-100">
                                    @yield('content')
                                </div>
                            </div>

                        </div>

                        {{-- Footer --}}
                        @include(wncms()->theme()->view($themeId, 'parts.footer'))

                    </div>

                </div>
            </div>
        </div>

        {{-- JS --}}
        {{-- <script src="{{ asset('wncms/js/jquery.min.js') . wncms()->addVersion('js') }}"></script> --}}
        {{-- <script src="{{ asset('wncms/js/lazysizes.min.js') . wncms()->addVersion('js') }}"></script> --}}

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="{{ asset('wncms/plugins/global/plugins.bundle.js' . $wncms->addVersion('js')) }}"></script>
        <script src="{{ asset('wncms/js/scripts.bundle.js' . $wncms->addVersion('js')) }}"></script>
        <script src="{{ asset('wncms/js/widgets.js' . $wncms->addVersion('js')) }}"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
        <script src="{{ asset('wncms/js/main.js' . $wncms->addVersion('js')) }}"></script>
        <script src="{{ asset('wncms/js/lazysizes.min.js') }}"></script>
        <script src="{{ asset('wncms/js/init.js'). $wncms->addVersion('js') }}"></script>
        <script src="{{ asset('wncms/js/wncms.js'). $wncms->addVersion('js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>

        <script src="{{ wncms()->theme()->asset($themeId, 'js/app.js') }}"></script>

        @stack('foot_js')

        {!! $website->body_code !!}
        {!! $website->analytics !!}

        {{-- CSS --}}
        @stack('foot_css')
        <style>
            {!! gto('custom_css') !!}
        </style>

    </body>

</html>
