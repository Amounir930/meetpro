@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
    <link href="{{ asset('/css/cropper.min.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/cropper.min.js') }}"></script>
    <div class="page jm-dashboard">
        @include('include.user.header')

        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">{{ __('Profile') }}</h2>
                        </div>
                        <div class="col-12 col-lg-7 col-xl-7">
                            <div
                                class="jm-header-right d-flex align-items-center justify-content-end flex-column flex-md-row">
                                <!-- instant meeting start here-->
                                <div
                                    class="jm-instant-meeting d-flex align-items-center justify-content-between justify-content-md-start">
                                    <h4 class="m-0">{{ __('Personal Meeting') }}</h4>
                                    <span class="jm-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="{{ __('This is your personal instant meeting link. It is uniquely generated based on your username.') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                                        </svg>
                                    </span>
                                    <div class="jm-right d-flex">
                                        <a onclick="location.href='{{ route('meeting', ['id' => getAuthUserInfo('username')]) }}'"
                                            class="btn btn-outline-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-send me-0 me-sm-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 14l11 -11" />
                                                <path
                                                    d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                            </svg>
                                            {{ __('Start') }}
                                        </a>
                                        <a id="copyMeetingLink" class="btn btn-outline-primary"
                                            data-link="{{ route('meeting', ['id' => getAuthUserInfo('username')]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-copy me-0 me-sm-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                <path
                                                    d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                            </svg>
                                            <span class="copy-text">
                                                {{ __('Copy link') }}
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <!-- instant meeting emd here-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="card">
                        {{-- @include('user.profile.header') --}}
                        <div class="row g-0">
                            @include('user.profile.navbar')
                            @yield('profile-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="create-modal-add-services_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold js-edit-title">{{ __('Crop') }}</h2>
                    <!--end::Modal title-->
                </div>
                <!--end::Modal header-->
                <div class="modal-body py-10 px-lg-17 text-center">
                    <div class="crop-img-section">
                        <img id="previewImage" />
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button id="crop_button" type="button" class="btn btn-primary">{{ __('Crop & Save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('/js/profile.js') }}"></script>
@endsection
