@extends('layouts.welcome')

@section('title', __('Meta title'))
@section('description', __('Meta description'))

@section('home-content')
    <div class="page jm-homepage">
        @include('include.user.header')
        @include('landing-page.main')

        @if (getSetting('LANDING_PAGE') == 'enabled')
            @include('landing-page.about')
            @include('landing-page.trusted-brand')
            @include('landing-page.feature')
            @include('landing-page.advantage')
            @if (Route::has('pricing') && count(paymentGateways()) != 0 && getSetting('PAYMENT_MODE') == 'enabled')
                <!-- pricing start here -->
                <section class="section jm-pricing">
                    @include('include.user.pricing')
                </section>
                <!-- pricing end here -->
            @endif
            @include('landing-page.review')
            @include('landing-page.stats')
            @include('landing-page.faq')
            @include('landing-page.cta')
        @endif
        @if (getSetting('PWA') == 'enabled')
            @include('include.pwa-installation-modal')

            <script type="text/javascript">
                if ('serviceWorker' in navigator) {
                    navigator.serviceWorker.register('/serviceworker.js', {
                        scope: '.'
                    }).then(function(registration) {}, function(err) {});
                }
            </script>
        @endif
        @include('include.cookie')
        <!-- How To Host Video Meetings end here -->
        <!-- footer start here -->
        @include('include.user.footer')
        <!-- footer end here -->
    </div>
@endsection
