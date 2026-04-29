@extends('admin.setting.index')

@section('setting-styles')
    <link rel="stylesheet" href="{{ asset('css/tom-select.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/tabler-vendors.min.css') }}">
@endsection

@section('setting-content')
    <form class="col-12 col-md-9 d-flex flex-column" action="{{ route('admin.setting.update-application') }}" method="post">
        @csrf
        <div class="card-body">
            <h2 class="mb-4">{{ __(key: 'Application') }}</h2>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Auth Mode') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('This mode will turn on the register, dashboard, profile, etc modules. If this mode is off use the \'login\' URL manually to log in.') }}"></i>
                        </label>
                        <select name="AUTH_MODE" class="form-control @error('AUTH_MODE') is-invalid @enderror">
                            <option value="enabled" @selected(old('AUTH_MODE') ? old('AUTH_MODE') == 'enabled' : getSetting('AUTH_MODE') == 'enabled')>
                                {{ __('On') }}
                            </option>
                            <option value="disabled" @selected(old('AUTH_MODE') ? old('AUTH_MODE') == 'disabled' : getSetting('AUTH_MODE') == 'disabled')>
                                {{ __('Off') }}
                            </option>
                        </select>
                        @error('AUTH_MODE')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Payment Mode') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('This mode will turn on the payment module. An extended license is required.') }}"></i>
                        </label>
                        <select name="PAYMENT_MODE" class="form-control @error('PAYMENT_MODE') is-invalid @enderror">
                            <option value="enabled" @selected(old('PAYMENT_MODE') ? old('PAYMENT_MODE') == 'enabled' : getSetting('PAYMENT_MODE') == 'enabled')>
                                {{ __('On') }}
                            </option>
                            <option value="disabled" @selected(old('PAYMENT_MODE') ? old('PAYMENT_MODE') == 'disabled' : getSetting('PAYMENT_MODE') == 'disabled')>
                                {{ __('Off') }}
                            </option>
                        </select>
                        @error('PAYMENT_MODE')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Landing page') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Set landing page on or off.') }}"></i>
                        </label>
                        <select name="LANDING_PAGE" class="form-control @error('LANDING_PAGE') is-invalid @enderror">
                            <option value="enabled" @selected(old('LANDING_PAGE') ? old('LANDING_PAGE') == 'enabled' : getSetting('LANDING_PAGE') == 'enabled')>
                                {{ __('On') }}
                            </option>
                            <option value="disabled" @selected(old('LANDING_PAGE') ? old('LANDING_PAGE') == 'disabled' : getSetting('LANDING_PAGE') == 'disabled')>
                                {{ __('Off') }}
                            </option>
                        </select>
                        @error('LANDING_PAGE')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Cookie Consent') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('If on, the system will display a cookie consent popup to the visitors.') }}"></i>
                        </label>
                        <select name="COOKIE_CONSENT" class="form-control @error('COOKIE_CONSENT') is-invalid @enderror">
                            <option value="enabled" @selected(old('COOKIE_CONSENT') ? old('COOKIE_CONSENT') == 'enabled' : getSetting('COOKIE_CONSENT') == 'enabled')>
                                {{ __('On') }}
                            </option>
                            <option value="disabled" @selected(old('COOKIE_CONSENT') ? old('COOKIE_CONSENT') == 'disabled' : getSetting('COOKIE_CONSENT') == 'disabled')>
                                {{ __('Off') }}
                            </option>
                        </select>
                        @error('COOKIE_CONSENT')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Registration') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('If off, the system will disable the registration option for guests') }}"></i>
                        </label>
                        <select name="REGISTRATION" class="form-control @error('REGISTRATION') is-invalid @enderror">
                            <option value="enabled" @selected(old('REGISTRATION') ? old('REGISTRATION') == 'enabled' : getSetting('REGISTRATION') == 'enabled')>
                                {{ __('On') }}
                            </option>
                            <option value="disabled" @selected(old('REGISTRATION') ? old('REGISTRATION') == 'disabled' : getSetting('REGISTRATION') == 'disabled')>
                                {{ __('Off') }}
                            </option>
                        </select>
                        @error('REGISTRATION')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Verify Users') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('If on, the system will send an email to the newly registered user. He must verify it before logging in') }}"></i>
                        </label>
                        <select name="VERIFY_USERS" class="form-control @error('VERIFY_USERS') is-invalid @enderror">
                            <option value="enabled" @selected(old('VERIFY_USERS') ? old('VERIFY_USERS') == 'enabled' : getSetting('VERIFY_USERS') == 'enabled')>
                                {{ __('On') }}
                            </option>
                            <option value="disabled" @selected(old('VERIFY_USERS') ? old('VERIFY_USERS') == 'disabled' : getSetting('VERIFY_USERS') == 'disabled')>
                                {{ __('Off') }}
                            </option>
                        </select>
                        @error('VERIFY_USERS')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('PWA') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('If on, the system will allow users to use the application as PWA') }}"></i>
                        </label>
                        <select name="PWA" class="form-control @error('PWA') is-invalid @enderror">
                            <option value="enabled" @selected(old('PWA') ? old('PWA') == 'enabled' : getSetting('PWA') == 'enabled')>
                                {{ __('On') }}
                            </option>
                            <option value="disabled" @selected(old('PWA') ? old('PWA') == 'disabled' : getSetting('PWA') == 'disabled')>
                                {{ __('Off') }}
                            </option>
                        </select>
                        @error('PWA')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Google analytics ID') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Google Analytics tracking ID. Set null to turn it off. It uses the format G-XXXXXXX.') }}"></i>
                        </label>
                        <input type="text" name="GOOGLE_ANALYTICS_ID"
                            class="form-control @error('GOOGLE_ANALYTICS_ID') is-invalid @enderror"
                            value="{{ old('GOOGLE_ANALYTICS_ID') ?? getSetting('GOOGLE_ANALYTICS_ID') }}"
                            placeholder="{{ __('Google analytics ID') }}">
                        @error('GOOGLE_ANALYTICS_ID')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Default Theme') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Apply a theme to your whole application.') }}"></i>
                        </label>
                        <select name="DEFAULT_THEME" class="form-control @error('DEFAULT_THEME') is-invalid @enderror">
                            <option value="light" @selected(old('DEFAULT_THEME') ? old('DEFAULT_THEME') == 'light' : getSetting('DEFAULT_THEME') == 'light')>
                                {{ __('Light') }}
                            </option>
                            <option value="dark" @selected(old('DEFAULT_THEME') ? old('DEFAULT_THEME') == 'dark' : getSetting('DEFAULT_THEME') == 'dark')>
                                {{ __('Dark') }}
                            </option>
                        </select>
                        @error('DEFAULT_THEME')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <label class="form-label">{{ __('Timezone') }} <i class="bi bi-info-circle-fill"
                            data-bs-toggle="tooltip" data-bs-placement="right"
                            title="{{ __('Set the default timezone for the admin panel.') }}"></i> </label>
                    <select name="ADMIN_TIMEZONE" class="form-control @error('ADMIN_TIMEZONE') is-invalid @enderror"
                        id="select-users" autocomplete="off">
                        @foreach (config('timezones') as $timezone)
                            <option value="{{ $timezone }}" @selected(old('ADMIN_TIMEZONE') ? old('ADMIN_TIMEZONE') == $timezone : getSetting('ADMIN_TIMEZONE') == $timezone)>
                                {{ $timezone }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Social Invitation') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Social invitation link message.') }}"></i>
                        </label>
                        <textarea class="form-control @error('SOCIAL_INVITATION') is-invalid @enderror" name="SOCIAL_INVITATION"
                            placeholder="{{ __('Social Invitation') }}" maxlength="255" rows="3">{{ old('SOCIAL_INVITATION') ?? getSetting('SOCIAL_INVITATION') }}</textarea>
                        @error('SOCIAL_INVITATION')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="btn-list justify-content-end">
                <button type="submit" name="submit" class="btn btn-primary mt-3">{{ __('Save') }}</button>
            </div>
        </div>
    </form>
@endsection

@section('setting-script')
    <script src="{{ asset('js/tom-select.base.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new TomSelect("#select-users", {
                multiple: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        });
    </script>
@endsection
