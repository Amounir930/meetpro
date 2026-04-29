@extends('admin.setting.index')

@section('setting-content')
    <div class="col-12 col-md-9 d-flex flex-column card-body">
        <h2 class="mb-4">{{ __(key: 'API Token') }}</h2>

        <div class="form-group">
            <label class="form-label" for="api_token">{{ __('API Token') }}
                <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="{{ __('Use this API Token to create users with webhook') }}"></i>
            </label>
            <input type="text" id="api_token" class="form-control" value="{{ getSetting('API_TOKEN') }}" disabled>
        </div>

        <div class="row mt-3">
            <div class="col">
                <button type="button" id="copyApiToken" class="btn btn-primary">{{ __('Copy') }}</button>
            </div>
        </div>
    </div>
@endsection
