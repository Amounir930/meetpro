<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ getSelectedLanguage()->direction }}"
    data-bs-theme-base="neutral" data-bs-theme="{{ getThemeFromSession() }}">

<head>
    @include('include.layouts.common.head')

    <link href="{{ asset('/css/auth.css?version=') . getVersion() }}" rel="stylesheet" />

    @yield('styles')

    <style>
        {!! getSetting('CUSTOM_CSS') !!}
    </style>
    {!! getSetting('CUSTOM_JS') !!}

</head>

<body>
    @yield('content')

    @include('include.layouts.common.body')

    <script>
        const cookieConsent = "{{ getSetting('COOKIE_CONSENT') }}";
        const googleAnalyticsTrackingId = "{{ getSetting('GOOGLE_ANALYTICS_ID') }}";
        const socialInvitation = `{{ getSetting('SOCIAL_INVITATION') }}`;
        const authUser = "{{ auth()->user() ? true : false }}";
    </script>

    <script src="{{ asset('/js/main.js?version=') . getVersion() }}"></script>
    @yield('script')
</body>

</html>
