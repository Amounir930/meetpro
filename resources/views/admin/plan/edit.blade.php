@extends('layouts.admin')
@section('title', $pageTitle)

@section('content')
    @include('include.admin.toast')

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    @include('include.admin.breadcrumbs', [
                        'module' => __('plan'),
                    ])
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.plan.update', $plan->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter Name" name="name" minlength="3" maxlength='64' required
                                        value="{{ old('name') ?? $plan->name }}">
                                    @error('name')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Currencies') }}</label>
                                    <select name="currency" class="form-select @error('currency') is-invalid @enderror"
                                        required>
                                        <option value="">{{ __('Please Select Option') }}</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->code }}" @selected((old('currency') !== null && old('currency') == $currency->code) || ($plan->currency == $currency->code && old('currency') == null))>
                                                {{ $currency->name }} - {{ $currency->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('currency')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Monthly Amount') }}</label>
                                    <input type="text" class="form-control @error('amount_month') is-invalid @enderror"
                                        placeholder="Enter monthly amount" name="amount_month"
                                        value="{{ old('amount_month') ?? $plan->amount_month }}" required>
                                    @error('amount_month')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Yearly Amount') }}</label>
                                    <input type="text" class="form-control @error('amount_year') is-invalid @enderror"
                                        placeholder="Enter yearly amount" name="amount_year"
                                        value="{{ old('amount_year') ?? $plan->amount_year }}" required>
                                    @error('amount_year')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Tax Rates') }}</label>
                                    <select class="form-select @error('tax_rates') is-invalid @enderror" name="tax_rates[]"
                                        value="{{ old('tax_rates') }}" size="3" multiple>
                                        <option value="">{{ __('None') }}</option>
                                        @foreach ($taxRates as $taxRate)
                                            <option value="{{ $taxRate->id }}" @selected((old('taxRates') !== null && in_array($taxRate->id, old('taxRates'))) || (old('taxRates') == null && is_array($plan->tax_rates) && in_array($taxRate->id, $plan->tax_rates)))>
                                                {{ $taxRate->name }}
                                                ({{ number_format($taxRate->percentage, 2, __('.'), __(',')) }}%
                                                {{ $taxRate->type ? __('Exclusive') : __('Inclusive') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tax_rates')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Coupons') }}</label>
                                    <select class="form-select @error('coupons') is-invalid @enderror" name="coupons[]"
                                        value="{{ old('coupons') }}" size="3" multiple>
                                        <option value="">{{ __('None') }}</option>
                                        @foreach ($coupons as $coupon)
                                            <option value="{{ $coupon->id }}" @selected((old('coupons') !== null && in_array($coupon->id, old('coupons'))) || (old('coupons') == null && is_array($plan->coupons) && in_array($coupon->id, $plan->coupons)))>
                                                {{ $coupon->name }}
                                                ({{ number_format($coupon->percentage, 2, __('.'), __(',')) }}%
                                                {{ $coupon->type ? __('Redeemable') : __('Discount') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('coupons')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label class="form-label">{{ __('Description') }}</label>
                                    <textarea type="text" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description"
                                        name="description" minlength="3" maxlength='256' required>{{ old('description') ?? $plan->description }}</textarea>
                                    @error('description')
                                        <small class="invalid-feedback">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>

                            <hr class="mt-2">
                            <h3 class="mb-3 mt-1"><span>{{ __('Features') }}</span></h3>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div>
                                        <label class="form-label">{{ __('Text Chat') }}</label>
                                        <select class="form-select @error('features.text_chat') is-invalid @enderror"
                                            name="features[text_chat]" required value="{{ old('features.text_chat') }}">
                                            @foreach ([1 => __('On'), 0 => __('Off')] as $key => $value)
                                                <option value="{{ $key }}" @selected((old('features.text_chat') !== null && old('features.text_chat') == $key) || ($plan->features->text_chat == $key && old('features.text_chat') == null))>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('features.text_chat')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div>
                                        <label class="form-label">{{ __('File Sharing') }}</label>
                                        <select class="form-select @error('features.file_share') is-invalid @enderror"
                                            name="features[file_share]" required value="{{ old('features.file_share') }}">
                                            @foreach ([1 => __('On'), 0 => __('Off')] as $key => $value)
                                                <option value="{{ $key }}" @selected((old('features.file_share') !== null && old('features.file_share') == $key) || ($plan->features->file_share == $key && old('features.file_share') == null))>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('features.file_share')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div>
                                        <label class="form-label">{{ __('Screen Sharing') }}</label>
                                        <select class="form-select @error('features.screen_share') is-invalid @enderror"
                                            name="features[screen_share]" required
                                            value="{{ old('features.screen_share') }}">
                                            @foreach ([1 => __('On'), 0 => __('Off')] as $key => $value)
                                                <option value="{{ $key }}" @selected((old('features.screen_share') !== null && old('features.screen_share') == $key) || ($plan->features->screen_share == $key && old('features.screen_share') == null))>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('features.screen_share')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div>
                                        <label class="form-label">{{ __('Whiteboard') }}</label>
                                        <select class="form-select @error('features.whiteboard') is-invalid @enderror"
                                            name="features[whiteboard]" required value="{{ old('features.whiteboard') }}">
                                            @foreach ([1 => __('On'), 0 => __('Off')] as $key => $value)
                                                <option value="{{ $key }}" @selected((old('features.whiteboard') !== null && old('features.whiteboard') == $key) || ($plan->features->whiteboard == $key && old('features.whiteboard') == null))>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('features.whiteboard')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div>
                                        <label class="form-label">{{ __('Hand Raise') }}</label>
                                        <select class="form-select @error('features.hand_raise') is-invalid @enderror"
                                            name="features[hand_raise]" required
                                            value="{{ old('features.hand_raise') }}">
                                            @foreach ([1 => __('On'), 0 => __('Off')] as $key => $value)
                                                <option value="{{ $key }}" @selected((old('features.hand_raise') !== null && old('features.hand_raise') == $key) || ($plan->features->hand_raise == $key && old('features.hand_raise') == null))>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('features.hand_raise')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div>
                                        <label class="form-label">{{ __('Recording') }}</label>
                                        <select class="form-select @error('features.recording') is-invalid @enderror"
                                            name="features[recording]" required value="{{ old('features.recording') }}">
                                            @foreach ([1 => __('On'), 0 => __('Off')] as $key => $value)
                                                <option value="{{ $key }}" @selected((old('features.recording') !== null && old('features.recording') == $key) || ($plan->features->recording == $key && old('features.recording') == null))>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('features.recording')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div>
                                        <label class="form-label">{{ __('Number of Meetings') }}</label>
                                        <input type="number" name="features[meeting_no]"
                                            class="form-control @error('features.meeting_no') is-invalid @enderror"
                                            required
                                            value="{{ old('features.meeting_no') ?? $plan->features->meeting_no }}"
                                            placeholder="{{ __('-1 for Unlimited') }}">
                                        @error('features.meeting_no')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div>
                                        <label class="form-label">{{ __('Time limit') }}</label>
                                        <input type="number" name="features[time_limit]"
                                            class="form-control @error('features.time_limit') is-invalid @enderror"
                                            required
                                            value="{{ old('features.time_limit') ?? $plan->features->time_limit }}"
                                            placeholder="{{ __('-1 for Unlimited') }}">
                                        @error('features.time_limit')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div>
                                        <label class="form-label">{{ __('User limit') }}</label>
                                        <input type="number" name="features[user_limit]"
                                            class="form-control @error('features.user_limit') is-invalid @enderror"
                                            required
                                            value="{{ old('features.user_limit') ?? ($plan->features->user_limit ?? '') }}"
                                            placeholder="{{ __('-1 for Unlimited') }}">
                                        @error('features.user_limit')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div>
                                        <label class="form-label">{{ __('AI Chatbot') }}</label>
                                        <select class="form-select @error('features.chatgpt') is-invalid @enderror"
                                            name="features[chatgpt]" required value="{{ old('features.chatgpt') }}">
                                            @foreach ([1 => __('On'), 0 => __('Off')] as $key => $value)
                                                <option value="{{ $key }}" @selected((old('features.chatgpt') !== null && old('features.chatgpt') == $key) || ($plan->features->chatgpt == $key && old('features.chatgpt') == null))>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('features.chatgpt')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div>
                                        <label class="form-label">{{ __('Video Quality') }}</label>
                                        <select class="form-select @error('features.video_quality') is-invalid @enderror"
                                            name="features[video_quality]" required
                                            value="{{ old('features.video_quality') }}">
                                            <option value="VGA" @if (
                                                (old('features.video_quality') !== null && old('features.video_quality') == 'VGA') ||
                                                    ($plan->features->video_quality == 'VGA' && old('features.video_quality') == null)) selected @endif>
                                                {{ __('VGA') }}</option>
                                            <option value="HD" @if (
                                                (old('features.video_quality') !== null && old('features.video_quality') == 'HD') ||
                                                    ($plan->features->video_quality == 'HD' && old('features.video_quality') == null)) selected @endif>
                                                {{ __('HD') }}</option>
                                            <option value="FHD" @if (
                                                (old('features.video_quality') !== null && old('features.video_quality') == 'FHD') ||
                                                    ($plan->features->video_quality == 'FHD' && old('features.video_quality') == null)) selected @endif>
                                                {{ __('FHD') }}</option>
                                            <option value="4K" @if (
                                                (old('features.video_quality') !== null && old('features.video_quality') == '4K') ||
                                                    ($plan->features->video_quality == '4K' && old('features.video_quality') == null)) selected @endif>
                                                {{ __('4K') }}</option>
                                        </select>
                                        @error('features.video_quality')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div>
                                        <label class="form-label">{{ __('Maximum Filesize (in MB)') }}</label>
                                        <input type="number" name="features[max_filesize]"
                                            class="form-control @error('features.max_filesize') is-invalid @enderror"
                                            required
                                            value="{{ old('features.max_filesize') ?? ($plan->features->max_filesize ?? '') }}"
                                            placeholder="{{ __('-1 for Unlimited') }}">
                                        @error('features.max_filesize')
                                            <small class="invalid-feedback">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-md-flex align-items-center">
                                <div class="ms-auto mt-3 mt-md-0">
                                    <a href="{{ route('admin.plan') }}"><button type="button" class="btn btn-1 gap-6">
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
