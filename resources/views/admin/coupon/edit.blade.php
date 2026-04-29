@extends('layouts.admin')
@section('title', $pageTitle)

@section('content')
    @include('include.admin.toast')

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    @include('include.admin.breadcrumbs', [
                        'module' => __('coupon'),
                    ])
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="post" id="form-coupon">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Type') }}</label>
                                    <select class="form-select @error('type') is-invalid @enderror" name="type"
                                        id="i-type" value="{{ old('type') }}" disabled>
                                        <option value="0" @selected((old('type') !== null && old('type') == '0') || ($coupon->type == '0' && old('type') == null))>{{ __('Discount') }}</option>
                                        <option value="1" @selected((old('type') !== null && old('type') == '1') || ($coupon->type == '1' && old('type') == null))>{{ __('Reedemable') }}</option>
                                    </select>
                                    @error('type')
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
                                        placeholder="Enter Name" name="name" disabled maxlength='50'
                                        value="{{ old('name') ?? $coupon->name }}">
                                    @error('name')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Code') }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                                            placeholder="Enter Code" name="code" id="couponCode" required minlength="3"
                                            maxlength='10' value="{{ old('code') ?? $coupon->code }}">
                                        <button class="btn btn-secondary" type="button" id="couponCodeCopy">
                                            {{ __('Copy') }}
                                        </button>
                                    </div>
                                    @error('code')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 {{ old('type') == 1 || (old('type') == null && $coupon->type == 1) ? '' : 'd-none' }}"
                                id="form-group-redeemable">
                                <div class="form-group">
                                    <label class="form-label" for="i-days">{{ __('Days') }}</label>
                                    <input type="number" name="days" id="i-days"
                                        class="form-control @error('days') is-invalid @enderror"
                                        value="{{ old('days') ?? $coupon->days }}" placeholder="{{ __('Days') }}">
                                    @error('days')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 {{ (old('type') == 0 && old('type') !== null) || (old('type') == null && $coupon->type == 0) ? '' : 'd-none' }}"
                                id="form-group-discount">
                                <div
                                    class="form-group {{ (old('type') == 0 && old('type') !== null) || (old('type') == null && $coupon->type == 0) ? '' : 'd-none' }}">
                                    <label class="form-label" for="i-percentage">{{ __('Percentage off') }}</label>
                                    <div class="input-group">
                                        <div class="input-group mb-3">
                                            <input type="text" name="percentage" id="i-percentage"
                                                class="form-control @error('percentage') is-invalid @enderror"
                                                value="{{ old('percentage') ?? $coupon->percentage }}" disabled
                                                placeholder="{{ __('Percentage off') }}">
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
                        </div>

                        <div class="col-md-6 mb-3">
                            <div>
                                <label class="form-label">{{ __('Quantity') }}</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                    placeholder="Enter Quantity" name="quantity" required maxlength='50'
                                    value="{{ old('quantity') ?? $coupon->quantity }}">
                                @error('quantity')
                                    <small class="invalid-feedback">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-md-flex align-items-center">
                                <div class="ms-auto mt-3 mt-md-0">
                                    <a href="{{ route('admin.coupon') }}"><button type="button"
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
