@extends('layouts.app')

@section('title', getSetting('APPLICATION_NAME') . ' | ' . $page)

@section('content')
    @include('include.user.header')
    <div class="page">
        <div class="page-wrapper">
            <!-- Page header -->
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">
                                {{ __('Invoice') }}
                            </h2>
                        </div>
                        <!-- Page title actions -->
                        <div class="col-auto ms-auto d-print-none">
                            <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                    <path
                                        d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                </svg>
                                {{ __('Print Invoice') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="card card-lg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p class="h3">{{ $commonData['COMPANY_NAME'] }}</p>
                                    <address>
                                        {{ $commonData['COMPANY_ADDRESS'] }}<br>
                                        {{ $commonData['COMPANY_CITY'] }}<br>
                                        {{ $commonData['COMPANY_STATE'] }} {{ $commonData['COMPANY_POSTAL_CODE'] }}<br>
                                        {{ $commonData['COMPANY_EMAIL'] }}
                                    </address>
                                </div>

                                @php
                                    $customerDetails = json_decode($payments->customer, true);
                                    $createdAt = date('M-d-Y', strtotime($payments->created_at));
                                    $createdAt = explode('-', $createdAt);
                                @endphp

                                <div class="col-6 text-end">
                                    <p class="h3">{{ $customerDetails['name'] }}</p>
                                    <address>
                                        {{ $customerDetails['address'] }},<br>
                                        {{ $customerDetails['city'] }},<br>
                                        {{ $customerDetails['state'] }}, {{ $customerDetails['postal_code'] }}<br>
                                        {{ $userEmail }}
                                    </address>
                                </div>
                                <div class="col-12 my-5">
                                    <h1>Invoice : {{ $payments->id }}</h1>
                                </div>
                            </div>
                            <table class="table table-transparent table-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 1%"></th>
                                        <th>{{ __('Product') }}</th>
                                        <th></th>
                                        <th class="text-center" style="width: 10%">{{ __('Date') }}</th>
                                        <th class="text-end" style="width: 1%">{{ __('Amount') }}</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>
                                        <p class="strong mb-1">{{ $payments->product->name }}</p>
                                        <div class="text-secondary">
                                            {{ isset($payments->product->amount_month) ? 'Monthly' : 'Yearly' }}</div>
                                    </td>
                                    <td></td>
                                    <td class="text-end">{{ $createdAt[0] }} {{ $createdAt[1] }}, {{ $createdAt[2] }}
                                    </td>
                                    <td class="text-end">
                                        {{ isset($payments->product->amount_month) ? formatMoney($payments->product->amount_month, $payments->product->currency) : formatMoney($payments->product->amount_year, $payments->product->currency) }}
                                        {{ $payments->product->currency }}</td>
                                </tr>
                                @if ($taxAmount != 0)
                                    <tr>
                                        <td colspan="4" class="strong text-end">{{ $payments->tax_rates[0]->name }}
                                            ({{ $payments->tax_rates[0]->percentage . ' %' }}
                                            {{ $payments->tax_rates[0]->type == 0 ? 'incl.' : 'excl.' }})</td>
                                        <td class="text-end">{{ formatMoney($taxAmount, $payments->product->currency) }}
                                            {{ $payments->product->currency }}</td>
                                    </tr>
                                @endif
                                @if ($payments->coupon)
                                    <tr>
                                        <td colspan="4" class="strong text-end">{{ $payments->coupon->code }}
                                            ({{ $payments->coupon->percentage . '% Discount' }})</td>
                                        <td class="text-end">{{ formatMoney($discountAmt, $payments->product->currency) }}
                                            {{ $payments->product->currency }} </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="4" class="font-weight-bold text-uppercase text-end">{{ __('Total') }}
                                    </td>
                                    <td class="font-weight-bold text-end">
                                        {{ formatMoney($payments->amount, $payments->product->currency) }}
                                        {{ $payments->product->currency }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
