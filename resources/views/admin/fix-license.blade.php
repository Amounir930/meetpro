<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ getSelectedLanguage()->direction }}"
    data-bs-theme-base="neutral" data-bs-theme="{{ getThemeFromSession() }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title translate="no">{{ getSetting('APPLICATION_NAME') . ' - License Fix' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/' . getSetting('FAVICON')) }}">

    <style>
        :root {
            --tblr-primary: {{ getSetting('PRIMARY_COLOR') }} !important;
            --tblr-primary: #7453f0 !important;
            --tblr-primary-rgb: 116, 83, 240 !important;
        }
    </style>

    <link href="{{ asset('/css/tabler.min.css') }}" rel="stylesheet" />

    @if (getSetting('PWA') == 'enabled')
        <link rel="manifest" href="/manifest.json">
    @endif

    <style>
        @import url("https://rsms.me/inter/inter.css");
        <link href="{{ asset('/css/bootstrap-icons.min.css') }}" rel="stylesheet" />
    </style>

</head>

<body>
    @include('include.admin.toast')
    <div class="col col-lg-6 text-center mx-auto mt-3">
        <img src="{{ asset('/storage/images/' . getSetting('PRIMARY_LOGO')) }}" width="175"
            alt="{{ __('Logo') }}" class="logo-image">
        <div class="card card-sm mt-3">
            <div class="card-body ">
                <form action="{{ route('fix-license') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('License Fix') }}</label>
                        <small
                            class="d-block text-start mb-2 mt-3">{{ __('If you are experiencing issues with your license, or if your IP address or domain associated with the license has changed, please revalidate it by entering your license code below.') }}</small>
                        <input type="text" class="form-control @error('license_code') is-invalid @enderror"
                            name="license_code" value="{{ old('license_code') }}"
                            placeholder="{{ __('Enter your license code') }}" required minlength="19" maxlength="36">
                        @error('license_code')
                            <small class="invalid-feedback">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label justify-content-start text-start">{{ __('Admin Password') }}</label>

                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control @error('admin_password') is-invalid @enderror"
                                name="admin_password" value="{{ old('admin_password') }}"
                                placeholder="{{ __('Enter Admin Password') }}" required minlength="6" maxlength="100">
                            @error('admin_password')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror

                            <span class="input-group-text">
                                <a class="link-secondary jm-toggle-password" data-bs-toggle="tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Fix License') }}
                    </button>
                </form>

            </div>
        </div>
    </div>
</body>

<script src="{{ asset('/js/jquery.min.js') }}"></script>

<script>
    $(".jm-toggle-password").on("click", function() {
        const passwordInput = $(this)
            .closest(".input-group")
            .find('input[type="password"], input[type="text"]');

        if (passwordInput.attr("type") === "password") {
            passwordInput.attr("type", "text");
            $(this).html(`
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
  <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
  <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
  <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
</svg>
              `);
        } else {
            passwordInput.attr("type", "password");
            $(this).html(`
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
</svg>
              `);
        }
    });
</script>

</html>
