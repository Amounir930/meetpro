<div class="col-12 col-md-3 border-end">
    <div class="card-body">
        <div class="list-group list-group-transparent">
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'admin.setting' ? 'active' : '' }}"
                href="{{ route('admin.setting') }}">{{ __('Basic') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'admin.setting.application' ? 'active' : '' }}"
                href="{{ route('admin.setting.application') }}">{{ __('Application') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'admin.setting.meeting' ? 'active' : '' }}"
                href="{{ route('admin.setting.meeting') }}">{{ __('Meeting') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'admin.setting.nodejs' ? 'active' : '' }}"
                href="{{ route('admin.setting.nodejs') }}">{{ __('Signaling') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'admin.setting.custom-js' ? 'active' : '' }}"
                href="{{ route('admin.setting.custom-js') }}">{{ __('Custom JS') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'admin.setting.custom-css' ? 'active' : '' }}"
                href="{{ route('admin.setting.custom-css') }}">{{ __('Custom CSS') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'admin.setting.smtp' ? 'active' : '' }}"
                href="{{ route('admin.setting.smtp') }}">{{ __('SMTP') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'admin.setting.google-recaptcha' ? 'active' : '' }}"
                href="{{ route('admin.setting.google-recaptcha') }}">{{ __('Google reCAPTCHA') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'admin.setting.company-information' ? 'active' : '' }}"
                href="{{ route('admin.setting.company-information') }}">{{ __('Company Information') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'admin.setting.social-login' ? 'active' : '' }}"
                href="{{ route('admin.setting.social-login') }}">{{ __('Social Login') }}</a>
        </div>
    </div>
</div>
