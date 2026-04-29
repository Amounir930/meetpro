@extends('layouts.admin')

@section('title', $pageTitle)
@section('style')
    <style>
        .card .nav.flex-column>li {
            border-bottom: unset;
        }
    </style>
@endsection

@section('content')
    @include('include.admin.toast')

    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        @include('include.admin.breadcrumbs')
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="row g-0">
                        @include('admin.payment-gateway.navbar')
                        @yield('payment-gateway-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
