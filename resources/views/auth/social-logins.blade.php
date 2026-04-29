@if (getSetting('GOOGLE_SOCIAL_LOGIN') == 'enabled' ||
        getSetting('FACEBOOK_SOCIAL_LOGIN') == 'enabled' ||
        getSetting('LINKEDIN_SOCIAL_LOGIN') == 'enabled' ||
        getSetting('TWITTER_SOCIAL_LOGIN') == 'enabled')
    <div class="hr-text">{{ __('or') }}</div>
    <div class="card-body">
        <div class="row">
            @if (getSetting('GOOGLE_SOCIAL_LOGIN') == 'enabled')
                <div class="col">
                    <a href="{{ route('login.google') }}" class="btn btn-4 w-100 google">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-google me-0">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M20.945 11a9 9 0 1 1 -3.284 -5.997l-2.655 2.392a5.5 5.5 0 1 0 2.119 6.605h-4.125v-3h7.945z" />
                        </svg>
                    </a>
                </div>
            @endif
            @if (getSetting('FACEBOOK_SOCIAL_LOGIN') == 'enabled')
                <div class="col">
                    <a href="{{ route('login.facebook') }}" class="btn btn-4 w-100 fb">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook me-0">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                        </svg>
                    </a>
                </div>
            @endif
            @if (getSetting('LINKEDIN_SOCIAL_LOGIN') == 'enabled')
                <div class="col">
                    <a href="{{ route('login.linkedin') }}" class="btn btn-4 w-100 linkedin">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-linkedin me-0">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 11v5" />
                            <path d="M8 8v.01" />
                            <path d="M12 16v-5" />
                            <path d="M16 16v-3a2 2 0 1 0 -4 0" />
                            <path d="M3 7a4 4 0 0 1 4 -4h10a4 4 0 0 1 4 4v10a4 4 0 0 1 -4 4h-10a4 4 0 0 1 -4 -4z" />
                        </svg>
                    </a>
                </div>
            @endif
            @if (getSetting('TWITTER_SOCIAL_LOGIN') == 'enabled')
                <div class="col">
                    <a href="{{ route('login.twitter') }}" class="btn btn-4 w-100 twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-x me-0">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                            <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif
