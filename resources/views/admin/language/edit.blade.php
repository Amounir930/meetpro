@extends('layouts.admin')
@section('title', $pageTitle)

@section('content')
    @include('include.admin.toast')

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    @include('include.admin.breadcrumbs', [
                        'module' => __('language'),
                    ])
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
                        <div class="d-flex">
                            <label>{{ $language->name . ' (' . $language->code . ')' }}</label>
                        </div>
                        <a href="{{ route('admin.language.downloadFile', $language->code) }}"><button type="button"
                                class="justify-content-center btn btn-rounded d-flex align-items-center ms-2 hideLoader">
                                {{ __('Download File') }}
                            </button></a>
                    </div>
                    <form action="{{ route('admin.language.update', $language->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Direction') }}</label>
                                    <select class="form-select  @error('direction') is-invalid @enderror" name="direction"
                                        value="{{ old('direction') }}" required>
                                        <option value="ltr" @if ($language->direction == 'ltr') selected @endif>
                                            {{ __('LTR (Left to Right)') }}</option>
                                        <option value="rtl" @if ($language->direction == 'rtl') selected @endif>
                                            {{ __('RTL (Right to Left)') }}</option>
                                    </select>
                                    @error('direction')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Default') }}</label>
                                    <select class="form-select @error('default') is-invalid @enderror" name="default"
                                        value="{{ old('default') }}" required>
                                        <option value="no" @if ($language->default == 'no') selected @endif>
                                            {{ __('No') }}</option>
                                        <option value="yes" @if ($language->default == 'yes') selected @endif>
                                            {{ __('Yes') }}</option>
                                    </select>
                                    @error('default')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Status') }}</label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status"
                                        value="{{ old('status') }}" required>
                                        <option value="active" @if ($language->status == 'active') selected @endif>
                                            {{ __('Active') }}</option>
                                        <option value="inactive" @if ($language->status == 'inactive') selected @endif>
                                            {{ __('Inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label for="formFile" class="form-label">{{ __('File') }}</label>
                                    <input class="form-control @error('file') is-invalid @enderror" type="file"
                                        name="file" value="{{ old('file') }}">
                                    @error('file')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-md-flex align-items-center">
                                    <div class="ms-auto mt-3 mt-md-0">
                                        <a href="{{ route('admin.language') }}"><button type="button"
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
