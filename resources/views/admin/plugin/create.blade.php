@extends('layouts.admin')
@section('title', $pageTitle)

@section('content')
    @include('include.admin.toast')

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    @include('include.admin.breadcrumbs', [
                        'module' => __('plugin'),
                    ])
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.plugin.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div>
                                    <label class="form-label">{{ __('Product') }}</label>
                                    <select name="product_id" class="form-select" required>
                                        <option value="">{{ __('Select Plugin') }}</option>

                                        @foreach (config('plugins') as $key => $plugin)
                                            <option value="{{ $key }}" @selected(old('product_id') == $key)>
                                                {{ $plugin }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('product_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Domain') }}</label>
                                    <input type="text" class="form-control @error('domain') is-invalid @enderror"
                                        placeholder="{{ __('Format: domain.com OR subdomain.domain.com') }}" name="domain"
                                        required minlength="3" maxlength="25" value="{{ old('domain') }}">
                                    @error('domain')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div>
                                    <label class="form-label">{{ __('API Token') }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('api_token') is-invalid @enderror"
                                            placeholder="{{ __('Enter your API token') }}" name="api_token" required
                                            minlength="3" maxlength="25" value="{{ $token }}" readonly>

                                        <span class="input-group-text copy-token">
                                            <i class="bi bi-copy"></i>
                                        </span>
                                    </div>
                                    @error('api_token')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{ __('Note : Copy the API Token') }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Purchase Code') }}</label>
                                    <input type="text" class="form-control @error('license_code') is-invalid @enderror"
                                        placeholder="{{ __('Enter your plugin\'s purchase code') }}" name="license_code"
                                        required minlength="3" maxlength="50" value="{{ old('license_code') }}">

                                    @error('license_code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-md-flex align-items-center">
                                <div class="ms-auto mt-3 mt-md-0">
                                    <a href="{{ route('admin.plugin') }}"><button type="button" class="btn btn-1 gap-6">
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
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
