@extends('admin.setting.index')

@section('setting-content')
    <form class="col-12 col-md-9 d-flex flex-column" action="{{ route('admin.setting.update-custom-js') }}" method="post">
        @csrf
        <div class="card-body">
            <h2 class="mb-4">{{ __(key: 'Custom JS') }}</h2>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-label">{{ __('Custom JS') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Add your custom JavaScript. Do add the script tag.') }}"></i>
                        </label>
                        <textarea class="form-control @error('CUSTOM_JS') is-invalid @enderror" name="CUSTOM_JS"
                            placeholder="{{ __('Custom JS') }}" rows="20">{{ old('CUSTOM_JS') ?? getSetting('CUSTOM_JS') }}</textarea>
                        @error('CUSTOM_JS')
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
