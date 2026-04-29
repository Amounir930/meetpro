@extends('layouts.admin')
@section('title', $pageTitle)

@section('content')
    @include('include.admin.toast')

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    @include('include.admin.breadcrumbs', [
                        'module' => __('taxrate'),
                    ])
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.taxrate.update', $taxrate->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3 mt-2">
                                <div>
                                    <label class="form-label">{{ __('Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter Name" name="name" required maxlength='50'
                                        value="{{ old('name') ?? $taxrate->name }}" disabled>
                                    @error('name')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 mt-2" id="form-group-discount">
                                <div class="form-group">
                                    <label class="form-label" for="i-percentage">{{ __('Percentage') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="percentage" id="i-percentage"
                                            class="form-control @error('percentage') is-invalid @enderror"
                                            value="{{ old('percentage') ?? $taxrate->percentage }}" disabled
                                            placeholder="{{ __('Enter Percentage') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        @error('percentage')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Type') }}</label>
                                    <select class="form-select @error('type') is-invalid @enderror" name="type"
                                        id="i-type" value="{{ old('type') }}" disabled>
                                        <option @selected((old('type') !== null && old('type') == '0') || ($taxrate->type == '0' && old('type') == null)) value="0">{{ __('Inclusive') }}</option>
                                        <option @selected((old('type') !== null && old('type') == '1') || ($taxrate->type == '1' && old('type') == null)) value="1">{{ __('Exclusive') }}</option>
                                    </select>
                                    @error('type')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="i-regions">{{ __('Regions') }}</label>
                                    <select name="regions[]" id="i-regions"
                                        class="form-select @error('regions') is-invalid @enderror" multiple>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->code }}" @selected((old('regions') !== null && in_array($country->code, old('regions'))) || (old('regions') == null && in_array($country->code, $taxrate->regions ? array_map("strtolower", $taxrate->regions) : [] ?? [])))>
                                                {{ __($country->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('regions')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <small id="regionsHelp"
                                        class="form-text text-muted">{{ __('Leave empty to apply the tax rate on all regions') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-md-flex align-items-center">
                                <div class="ms-auto mt-3 mt-md-0">
                                    <a href="{{ route('admin.taxrate') }}"><button type="button"
                                            class="btn btn-1 gap-6">
                                            {{ __('Back') }}
                                        </button></a>
                                </div>
                                <div class="ms-2 mt-3 mt-md-0">
                                    <button type="submit" class="btn btn-primary gap-6">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
