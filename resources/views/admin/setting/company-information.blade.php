@extends('admin.setting.index')

@section('setting-content')
<form class="col-12 col-md-9 d-flex flex-column" action="{{ route('admin.setting.update-company-information') }}" method="post">
    @csrf
    <div class="card-body">
        <h2 class="mb-4">{{ __(key: 'Company Information') }}</h2>

            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Company Name') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Company Name will be visible in the entire application.') }}"></i>
                        </label>
                        <input type="text" name="COMPANY_NAME" maxlength="50"
                            class="form-control @error('COMPANY_NAME') is-invalid @enderror"
                            value="{{ old('COMPANY_NAME') ?? getSetting('COMPANY_NAME') }}"
                            placeholder="{{ __('Company Name') }}">
                        @error('COMPANY_NAME')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('COMPANY_NAME') }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Address') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Company Address will be visible on invoice.') }}"></i>
                        </label>
                        <input type="text" name="COMPANY_ADDRESS" maxlength="100"
                            class="form-control @error('COMPANY_ADDRESS') is-invalid @enderror"
                            value="{{ old('COMPANY_ADDRESS') ?? getSetting('COMPANY_ADDRESS') }}"
                            placeholder="{{ __('Company Address') }}">
                        @error('COMPANY_ADDRESS')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('COMPANY_ADDRESS') }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('City') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Company City will be visible on invoice.') }}"></i>
                        </label>
                        <input type="text" name="COMPANY_CITY" maxlength="35"
                            class="form-control @error('COMPANY_CITY') is-invalid @enderror"
                            value="{{ old('COMPANY_CITY') ?? getSetting('COMPANY_CITY') }}"
                            placeholder="{{ __('City') }}">
                        @error('COMPANY_CITY')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('State') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Company State will be visible on invoice.') }}"></i>
                        </label>
                        <input type="text" name="COMPANY_STATE" maxlength="25"
                            class="form-control @error('COMPANY_STATE') is-invalid @enderror"
                            value="{{ old('COMPANY_STATE') ?? getSetting('COMPANY_STATE') }}"
                            placeholder="{{ __('State') }}">
                        @error('COMPANY_STATE')
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
                        <label class="form-label">{{ __('Postal Code') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Company Postal code will be visible on invoice.') }}"></i>
                        </label>
                        <input type="text" name="COMPANY_POSTAL_CODE" maxlength="10"
                            class="form-control @error('COMPANY_POSTAL_CODE') is-invalid @enderror"
                            value="{{ old('COMPANY_POSTAL_CODE') ?? getSetting('COMPANY_POSTAL_CODE') }}"
                            placeholder="{{ __('Postal Code') }}">
                        @error('COMPANY_POSTAL_CODE')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label" for="i-country">{{ __('Country') }}</label>
                        <select name="COMPANY_COUNTRY" id="i-country"
                            class="form-control @error('COMPANY_COUNTRY') is-invalid @enderror">
                            @foreach ($countries as $country)
                                <option value="{{ $country->code }}" test="{{ old('COMPANY_COUNTRY') }}"
                                    @selected(strtolower(getSetting('COMPANY_COUNTRY')) == $country->code)>
                                    {{ __($country->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('COMPANY_COUNTRY')
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
                        <label class="form-label">{{ __('Phone') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Company Phone Number will be visible on invoice.') }}"></i>
                        </label>
                        <input type="text" name="COMPANY_PHONE" maxlength="15"
                            class="form-control @error('COMPANY_PHONE') is-invalid @enderror"
                            value="{{ old('COMPANY_PHONE') ?? getSetting('COMPANY_PHONE') }}"
                            placeholder="{{ __('Phone') }}">
                        @error('COMPANY_PHONE')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Email') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Company Email will be visible on invoice.') }}"></i>
                        </label>
                        <input type="text" name="COMPANY_EMAIL" maxlength="62"
                            class="form-control @error('COMPANY_EMAIL') is-invalid @enderror"
                            value="{{ old('COMPANY_EMAIL') ?? getSetting('COMPANY_EMAIL') }}"
                            placeholder="{{ __('Company Email') }}">
                        @error('COMPANY_EMAIL')
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
                        <label class="form-label">{{ __('Tax ID') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Company Tax(HST/GST/VAT) ID will be visible on invoice.') }}"></i>
                        </label>
                        <input type="text" name="COMPANY_TAX_ID" maxlength="25"
                            class="form-control @error('COMPANY_TAX_ID') is-invalid @enderror"
                            value="{{ old('COMPANY_TAX_ID') ?? getSetting('COMPANY_TAX_ID') }}"
                            placeholder="{{ __('Tax ID(HST/GST/VAT)') }}">
                        @error('COMPANY_TAX_ID')
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
