@extends('admin.setting.index')

@section('setting-content')
    <form class="col-12 col-md-9 d-flex flex-column" action="{{ route('admin.setting.update-custom-css') }}" method="post">
        @csrf
        <div class="card-body">
            <h2 class="mb-4">{{ __(key: 'Custom CSS') }}</h2>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form-label">{{ __('Custom CSS') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Add your custom CSS. Do NOT add the style tag.') }}"></i>
                        </label>
                        <textarea class="form-control @error('CUSTOM_CSS') is-invalid @enderror" name="CUSTOM_CSS"
                            placeholder="{{ __('Custom CSS') }}" rows="20">{{ old('CUSTOM_CSS') ?? getSetting('CUSTOM_CSS') }}</textarea>
                        @error('CUSTOM_CSS')
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
