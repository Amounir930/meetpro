<header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav flex-row order-md-last">
            <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        {{ __('Dashboard') }}
                    </span>
                </a>
            </li>
            @if (getLanguages()->count() > 1)
                <div class="nav-item dropdown d-flex align-items-center">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                        data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-world">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                <path d="M3.6 9h16.8" />
                                <path d="M3.6 15h16.8" />
                                <path d="M11.5 3a17 17 0 0 0 0 18" />
                                <path d="M12.5 3a17 17 0 0 1 0 18" />
                            </svg>
                        </span>
                        <span class="d-none d-md-inline">{{ getSelectedLanguage()->name }}</span>
                    </a>

                    <div class="dropdown-menu">
                        @foreach (getLanguages() as $language)
                            <a href="{{ route('language', ['locale' => $language->code]) }}" class="dropdown-item">
                                {{ $language->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="d-md-flex align-items-center flex-nowrap">
                <form method="post" action="{{ route('theme.toggle') }}">
                    @csrf
                    @if (getThemeFromSession() == 'dark')
                        <input type="hidden" name="theme_name" value="light" />
                        <button type="submit" class="nav-link px-0 dark-theme-setting" data-bs-toggle="tooltip"
                            data-bs-placement="bottom">
                            <!-- Moon icon (for light mode) -->
                            <span id="moonIcon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                                </svg>
                            </span>
                        </button>
                    @else
                        <input type="hidden" name="theme_name" value="dark" />
                        <button type="submit" class="nav-link px-0 dark-theme-setting" data-bs-toggle="tooltip"
                            data-bs-placement="bottom">
                            <!-- Sun icon (for dark mode) -->
                            <span id="sunIcon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                    <path
                                        d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                                </svg>
                            </span>
                        </button>
                    @endif
                    </button>
                </form>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    @if (getAuthUserInfo('avatar') && file_exists(public_path('storage/avatars/' . getAuthUserInfo('avatar'))))
                        <div class="col-auto">
                            <span class="avatar avatar-sm"
                                style="background-image: url('{{ asset('storage/avatars/' . getAuthUserInfo('avatar')) }}')"></span>
                        </div>
                    @else
                        <div class="col-auto">
                            <span class="avatar avatar-sm"
                                style="background-image: url('{{ asset('/images/blank.jpeg') }}')"></span>
                        </div>
                    @endif
                    <div class="d-none d-sm-block ps-2">
                        <div>{{ getAuthUserInfo('full_name') }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('user.profile.basic') }}" class="dropdown-item">{{ __('Profile') }}</a>
                    <a href="" class="dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
        </div>
    </div>
</header>
