<div class="col-12 col-md-3 border-end profile-tabs">
    <div class="card-body">
        <div class="list-group list-group-transparent">
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'user.profile.basic' ? 'active' : '' }}"
                href="{{ route('user.profile.basic') }}">{{ __('Basic Information') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'user.profile.security' ? 'active' : '' }}"
                href="{{ route('user.profile.security') }}">{{ __('Security') }}</a>
            @if (Route::has('pricing') && count(paymentGateways()) != 0 && getSetting('PAYMENT_MODE') == 'enabled')
                <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'user.profile.plan' ? 'active' : '' }}"
                    href="{{ route('user.profile.plan') }}">{{ __('My Plan') }}</a>
                <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'user.profile.payment' ? 'active' : '' }}"
                    href="{{ route('user.profile.payment') }}">{{ __('Payments') }}</a>
            @endif
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'user.profile.api-token' ? 'active' : '' }}"
                href="{{ route('user.profile.api-token') }}">{{ __('API Tokens') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'user.profile.contacts' || Route::currentRouteName() == 'user.profile.contact.create' || Route::currentRouteName() == 'user.profile.contact.edit' ? 'active' : '' }}"
                href="{{ route('user.profile.contacts') }}">{{ __('Contacts') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'user.profile.tfa' ? 'active' : '' }}"
                href="{{ route('user.profile.tfa') }}">{{ __('Two Factor Authentication') }}</a>
            <a class="list-group-item list-group-item-action d-flex align-items-center {{ Route::currentRouteName() == 'user.profile.delete-account' ? 'active' : '' }}"
                href="{{ route('user.profile.delete-account') }}">{{ __('Delete Account') }}</a>
        </div>
    </div>
</div>
