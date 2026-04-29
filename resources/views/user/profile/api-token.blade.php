@extends('user.profile.index')

@section('profile-content')
    <div class="col-12 col-md-9 d-flex flex-column card-body">
        <h2 class="mb-4">{{ __('API Token') }}</h2>
        <div class="input-group showToastAbove">
            <input type="text" id="apiToken" class="form-control" value="{{ $api_token }}" disabled>
            <button class="btn" type="button" id="copyApiTokenButton">
                {{ __('Copy') }}
            </button>
        </div>
    </div>
@endsection
