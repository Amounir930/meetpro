@extends('admin.setting.index')

@section('setting-content')
    <form class="col-12 col-md-9 d-flex flex-column" action="{{ route('admin.setting.update-google-recaptcha') }}"
        method="post">
        @csrf
        <div class="card-body">
            <h2 class="mb-4">{{ __(key: 'Google ReCaptcha') }}</h2>


            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Key') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Key') }}"></i>
                        </label>
                        <input type="text" name="GOOGLE_RECAPTCHA_KEY" maxlength="100"
                            class="form-control @error('GOOGLE_RECAPTCHA_KEY') is-invalid @enderror"
                            value="{{ isDemoMode() ? __('This field is hidden in the demo mode') : old('GOOGLE_RECAPTCHA_KEY') ?? getSetting('GOOGLE_RECAPTCHA_KEY') }}"
                            placeholder="{{ __('reCAPTCHA Key') }}">
                        @error('GOOGLE_RECAPTCHA_KEY')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Secret') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Secret') }}"></i>
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" name="GOOGLE_RECAPTCHA_SECRET" maxlength="100"
                                class="form-control @error('GOOGLE_RECAPTCHA_SECRET') is-invalid @enderror"
                                value="{{ isDemoMode() ? __('This field is hidden in the demo mode') : old('GOOGLE_RECAPTCHA_SECRET') ?? getSetting('GOOGLE_RECAPTCHA_SECRET') }}"
                                placeholder="{{ __('reCAPTCHA Secret') }}">
                            @error('GOOGLE_RECAPTCHA_SECRET')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
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
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Login Page') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('This will add a Google reCAPTCHA validation on the login page.') }}"></i>
                        </label>
                        <select name="CAPTCHA_LOGIN_PAGE"
                            class="form-control @error('CAPTCHA_LOGIN_PAGE') is-invalid @enderror">
                            <option value="enabled" @selected(old('CAPTCHA_LOGIN_PAGE') ? old('CAPTCHA_LOGIN_PAGE') == 'enabled' : getSetting('CAPTCHA_LOGIN_PAGE') == 'enabled')>
                                {{ __('On') }}
                            </option>
                            <option value="disabled" @selected(old('CAPTCHA_LOGIN_PAGE') ? old('CAPTCHA_LOGIN_PAGE') == 'disabled' : getSetting('CAPTCHA_LOGIN_PAGE') == 'disabled')>
                                {{ __('Off') }}
                            </option>
                        </select>
                        @error('CAPTCHA_LOGIN_PAGE')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Register Page') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('This will add a Google reCAPTCHA validation on the register page.') }}"></i>
                        </label>
                        <select name="CAPTCHA_REGISTER_PAGE"
                            class="form-control @error('CAPTCHA_REGISTER_PAGE') is-invalid @enderror">
                            <option value="enabled" @selected(old('CAPTCHA_REGISTER_PAGE') ? old('CAPTCHA_REGISTER_PAGE') == 'enabled' : getSetting('CAPTCHA_REGISTER_PAGE') == 'enabled')>
                                {{ __('On') }}
                            </option>
                            <option value="disabled" @selected(old('CAPTCHA_REGISTER_PAGE') ? old('CAPTCHA_REGISTER_PAGE') == 'disabled' : getSetting('CAPTCHA_REGISTER_PAGE') == 'disabled')>
                                {{ __('Off') }}
                            </option>
                        </select>
                        @error('CAPTCHA_REGISTER_PAGE')
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
                        <label class="form-label">{{ __('Checkout Page') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('This will add a Google reCAPTCHA validation on the checkout page.') }}"></i>
                        </label>
                        <select name="GOOGLE_RECAPTCHA"
                            class="form-control @error('GOOGLE_RECAPTCHA') is-invalid @enderror">
                            <option value="enabled" @selected(old('GOOGLE_RECAPTCHA') ? old('GOOGLE_RECAPTCHA') == 'enabled' : getSetting('GOOGLE_RECAPTCHA') == 'enabled')>
                                {{ __('On') }}
                            </option>
                            <option value="disabled" @selected(old('GOOGLE_RECAPTCHA') ? old('GOOGLE_RECAPTCHA') == 'disabled' : getSetting('GOOGLE_RECAPTCHA') == 'disabled')>
                                {{ __('Off') }}
                            </option>
                        </select>
                        @error('GOOGLE_RECAPTCHA')
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
