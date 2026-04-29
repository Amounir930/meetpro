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
                    <form action="{{ route('admin.language.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Code') }}</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                                        placeholder="{{ __('Enter Code') }}" name="code" required maxlength='10'
                                        value="{{ old('code') }}" autofocus>
                                    @error('code')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="{{ __('Enter Name') }}" name="name" required minlength="3"
                                        maxlength='50' value="{{ old('name') }}">
                                    @error('name')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Direction') }}</label>
                                    <select class="form-select @error('direction') is-invalid @enderror" name="direction"
                                        value="{{ old('direction') }}" required>
                                        <option value="ltr">{{ __('LTR (Left to Right)') }}</option>
                                        <option value="rtl">{{ __('RTL (Right to Left)') }}</option>
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
                                        <option value="no">{{ __('No') }}</option>
                                        <option value="yes">{{ __('Yes') }}</option>
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
                                        <option value="active">{{ __('Active') }}</option>
                                        <option value="inactive">{{ __('Inactive') }}</option>
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
                                        name="file" value="{{ old('file') }}" required>
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
