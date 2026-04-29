@extends('layouts.app')

@section('page', $page)
@section('title', $page)

@section('styles')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/tom-select.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    @include('include.user.toast')
    <div class="page jm-dashboard">
        @include('include.user.header')
        <div class="page-wrapper">
            <!-- Page body -->
            <div class="page-body mb-0">
                <div class="container-xl">
                    <div class="card">
                        <!-- meeting header start here -->
                        <div class="row g-0 jm-meeting-header flex-row-reverse">
                            <!-- instant meeting & join meeting start here -->
                            <div class="col-12 col-lg-7 col-xl-7">
                                <div
                                    class="jm-header-right d-flex align-items-center justify-content-end flex-column flex-md-row">
                                    <!-- instant meeting start here-->
                                    <div
                                        class="jm-instant-meeting d-flex align-items-center justify-content-between justify-content-md-start">
                                        <h4 class="m-0">{{ __('Instant Meeting') }}</h4>
                                        <div class="jm-right d-flex">
                                            <a onclick="location.href='{{ route('meeting', ['id' => getAuthUserInfo('username')]) }}'"
                                                class="btn btn-outline-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
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
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-copy me-0 me-sm-2">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                    <path
                                                        d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                                </svg>
                                                {{ __('Copy link') }}
                                            </a>
                                        </div>
                                    </div>
                                    <!-- instant meeting emd here-->
                                    <!-- join meeting start here-->
                                    <div class="jm-join-meeting d-flex">
                                        <form id="meetingDashboard" class="mb-0 w-100">
                                            <div class="input-icon w-100">
                                                <span class="input-icon-addon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-keyboard">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M2 6m0 2a2 2 0 0 1 2 -2h16a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-16a2 2 0 0 1 -2 -2z" />
                                                        <path d="M6 10l0 .01" />
                                                        <path d="M10 10l0 .01" />
                                                        <path d="M14 10l0 .01" />
                                                        <path d="M18 10l0 .01" />
                                                        <path d="M6 14l0 .01" />
                                                        <path d="M18 14l0 .01" />
                                                        <path d="M10 14l4 .01" />
                                                    </svg>
                                                </span>
                                                <input type="text" class="form-control" maxlength="9" id="conferenceId"
                                                    name="id" placeholder="{{ __('Enter Meeting ID') }}" required>
                                                <button type="submit" href="#"
                                                    class="link jm-join-link">{{ __('JOIN') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- join meeting end here-->
                                </div>
                            </div>
                            <!-- instant meeting & join meeting end here -->
                            <!-- create meeting start here -->
                            <div class="col-12 col-lg-5 col-xl-5">
                                <div class="jm-header-left d-flex justify-content-between align-items-center">
                                    <h2 class="m-0">{{ __('My Meetings') }}</h2>
                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMeetingModal">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 5l0 14"></path>
                                            <path d="M5 12l14 0"></path>
                                        </svg>
                                        {{ __('Create Meeting') }}
                                    </a>
                                </div>
                            </div>
                            <!-- create meeting end here -->
                        </div>
                        <!-- meeting header end here -->
                        <div class="row g-0">
                            <!-- emty meeting start here -->
                            <div class="empty" style="height: 47rem;" @if ($firstMeeting) hidden @endif>
                                <p class="empty-title">{{ __('No meeting found') }}</p>
                                <p class="empty-subtitle text-secondary">
                                    {{ __("Try adjusting your search or filter to find what you're looking for.") }}
                                </p>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-restore me-0 me-sm-2">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3.06 13a9 9 0 1 0 .49 -4.087" />
                                        <path d="M3 4.001v5h5" />
                                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    </svg>
                                    {{ __('Reset') }}
                                </a>
                            </div>
                            <!-- emty meeting end here -->

                            <div class="col-12 col-lg-5 col-xl-5 border-end meetingDetail meeting-search-box"
                                @if (!$firstMeeting) hidden @endif>
                                <div class="card-header jm-meeting-search d-flex w-100">
                                    <div class="input-icon w-100">
                                        <div class="input-group w-100">
                                            <form id="searchMeeting" action="{{ route('dashboard') }}"
                                                class="d-flex w-100 m-0">
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="{{ __('Search meetings') }}" aria-label="Search"
                                                    autocomplete="off" maxlength="50" value="{{ $search }}" />
                                                <a onclick="document.getElementById('searchMeeting').submit();"
                                                    class="input-group-text jm-join-link ms-2" style="cursor: pointer;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                        <path d="M21 21l-6 -6" />
                                                    </svg>
                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0 scrollable" style="max-height: 40rem">
                                    <div class="nav flex-column nav-pills meeting-list" role="tablist">
                                        @foreach ($meetings as $meeting)
                                            <a class="nav-link text-start mw-100 jm-meeting-card" data-bs-toggle="pill"
                                                role="tab" aria-selected="true" data-title="{{ $meeting->title }}"
                                                data-description="{{ $meeting->description }}"
                                                data-id="{{ $meeting->id }}" data-auto="{{ $meeting->meeting_id }}"
                                                data-password="{{ $meeting->password }}"
                                                data-date="{{ formatDate($meeting->date) }}"
                                                data-time="{{ formatTime($meeting->time) }}"
                                                data-timezone="{{ $meeting->timezone }}">
                                                <div class="row align-items-center flex-fill">
                                                    <div class="col text-body">
                                                        <div class="d-flex justify-content-between">
                                                            <h3 class="meeting-title m-0 text-truncate">
                                                                {{ $meeting->title }} </h3>
                                                            <div class="text-secondary created-time text-nowrap"
                                                                title="{{ $meeting->created_at }}">
                                                                {{ $meeting->created_at->diffForHumans() }}</div>
                                                        </div>
                                                        <div class="text-secondary meeting-description text-truncate mb-2">
                                                            {{ $meeting->description }}</div>
                                                        <div class="d-flex justify-content-between">
                                                            <div class="text-secondary text-truncate jm-meeting-id">Meeting
                                                                ID:
                                                                {{ $meeting->meeting_id }}</div>
                                                            <div class="text-secondary d-flex jm-meeting-date justify-content-end">
                                                                @if ($meeting->date || $meeting->time || $meeting->timezone)
                                                                    <span class="icon-tabler">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="1.5"
                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-stats">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none" />
                                                                            <path
                                                                                d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" />
                                                                            <path d="M18 14v4h4" />
                                                                            <path
                                                                                d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                                            <path d="M15 3v4" />
                                                                            <path d="M7 3v4" />
                                                                            <path d="M3 11h16" />
                                                                        </svg>
                                                                    </span>
                                                                    <p class="text-truncate m-0">
                                                                        {{ $meeting->date . ' ' . $meeting->time . ' ' . $meeting->timezone }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                    <div class="mt-2 ms-2">
                                        {{ $meetings->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-7 d-flex flex-column meetingDetail">
                                <div class="card-body scrollable jm-meeting-detail" style="height: 40rem"
                                    @if (!$firstMeeting) hidden @endif>
                                    <!-- meeting details start here-->
                                    <!--mobile header start here -->
                                    <div
                                        class="jm-meeting-heading mb-4 d-flex justify-content-between align-items-center d-block d-md-none">
                                        <a href="#" class="btn btn-outline-primary mobile-back-btn">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left me-0 me-sm-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12l14 0" />
                                                <path d="M5 12l6 6" />
                                                <path d="M5 12l6 -6" />
                                            </svg>
                                            {{ __('Back') }}
                                        </a>
                                        <div class="jm-meeting-actions d-flex">
                                            <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#Invite">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus me-0 me-sm-2">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                    <path d="M16 19h6" />
                                                    <path d="M19 16v6" />
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                                </svg>
                                                {{ __('Invite') }}
                                            </a>
                                            <a class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editMeetingModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit me-0 me-sm-2">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                    <path
                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                    <path d="M16 5l3 3" />
                                                </svg>
                                                {{ __('Edit') }}
                                            </a>
                                            <a class="btn btn-outline-danger delete"
                                                data-id="{{ $firstMeeting ? $firstMeeting->id : '' }}"
                                                data-action="{{ route('deleteMeeting') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash me-0 me-sm-2">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                                {{ __('Delete') }}
                                            </a>
                                        </div>
                                    </div>
                                    <!--mobile header end  here -->
                                    <div class="jm-meeting-heading mb-4 d-flex justify-content-between align-items-start">
                                        <h2 class="m-0" id="meetingTitleDetail">
                                            {{ $firstMeeting ? $firstMeeting->title : '' }}</h2>
                                        <div class="jm-meeting-actions d-flex d-none d-md-block">
                                            <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#Invite">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus me-0 me-sm-2">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                    <path d="M16 19h6" />
                                                    <path d="M19 16v6" />
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                                </svg>
                                                {{ __('Invite') }}
                                            </a>
                                            <a class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editMeetingModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit me-0 me-sm-2">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                    <path
                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                    <path d="M16 5l3 3" />
                                                </svg>
                                                {{ __('Edit') }}
                                            </a>
                                            <a class="btn btn-outline-danger delete"
                                                data-id="{{ $firstMeeting ? $firstMeeting->id : '' }}"
                                                data-action="{{ route('deleteMeeting') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash me-0 me-sm-2">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                                {{ __('Delete') }}
                                            </a>
                                        </div>
                                    </div>
                                    <dl class="row">
                                        <dd class="col-3 mb-4">{{ __('Meeting ID') }}:</dd>
                                        <dt class="col-9 mb-4" id="meetingIdDetail">
                                            {{ $firstMeeting ? $firstMeeting->meeting_id : '' }}</dt>
                                        <dd class="col-3 mb-4">{{ __('Password') }}:</dd>
                                        <dt class="col-9 mb-4" id="meetingPasswordDetail">
                                            {{ $firstMeeting && $firstMeeting->password ? $firstMeeting->password : '-' }}
                                        </dt>
                                        <dd class="col-3 mb-4">{{ __('Date') }}:</dd>
                                        <dt class="col-9 mb-4" id="meetingDateDetail">
                                            {{ $firstMeeting && $firstMeeting->date ? formatDate($firstMeeting->date) : '-' }}
                                        </dt>
                                        <dd class="col-3 mb-4">{{ __('Time') }}:</dd>
                                        <dt class="col-9 mb-4" id="meetingTimeDetail">
                                            {{ $firstMeeting && $firstMeeting->time ? formatTime($firstMeeting->time) : '-' }}
                                        </dt>
                                        <dd class="col-3 mb-4">{{ __('Time zone') }}:</dd>
                                        <dt class="col-9 mb-4" id="meetingTimezoneDetail">
                                            {{ $firstMeeting && $firstMeeting->timezone ? $firstMeeting->timezone : '-' }}
                                        </dt>
                                        <dd class="col-3 mb-4">{{ __('Description') }}:</dd>
                                        <dt class="col-9 mb-4" id="meetingDescriptionDetail">
                                            {{ $firstMeeting && $firstMeeting->description ? $firstMeeting->description : '-' }}
                                        </dt>
                                        <dd class="col-3 mb-4">{{ __('Add to') }}:</dd>
                                        <dt class="col-9 mb-4 mr-3 d-flex jm-addto-btn ">
                                            <a class="jm-btn-google-calender d-flex" id="addToGoogle"><svg width="20"
                                                    height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_53_1907)">
                                                        <path
                                                            d="M15.2631 4.73675L10.5263 4.21045L4.73685 4.73675L4.21045 9.99995L4.73675 15.2631L9.99995 15.921L15.2631 15.2631L15.7894 9.86845L15.2631 4.73675Z"
                                                            fill="white" />
                                                        <path
                                                            d="M6.89604 12.9026C6.50264 12.6368 6.23024 12.2487 6.08154 11.7355L6.99474 11.3592C7.07764 11.675 7.22234 11.9197 7.42894 12.0934C7.63424 12.2671 7.88424 12.3526 8.17634 12.3526C8.47504 12.3526 8.73164 12.2618 8.94604 12.0802C9.16044 11.8986 9.26844 11.667 9.26844 11.3868C9.26844 11.1 9.15524 10.8657 8.92894 10.6842C8.70264 10.5027 8.41844 10.4118 8.07894 10.4118H7.55134V9.50788H8.02494C8.31704 9.50788 8.56314 9.42898 8.76314 9.27108C8.96314 9.11318 9.06314 8.89738 9.06314 8.62238C9.06314 8.37768 8.97364 8.18288 8.79474 8.03688C8.61584 7.89088 8.38944 7.81718 8.11444 7.81718C7.84604 7.81718 7.63284 7.88828 7.47494 8.03168C7.31704 8.17508 7.20254 8.35138 7.13024 8.55928L6.22634 8.18298C6.34604 7.84348 6.56584 7.54348 6.88814 7.28428C7.21054 7.02508 7.62234 6.89478 8.12234 6.89478C8.49204 6.89478 8.82494 6.96588 9.11974 7.10928C9.41444 7.25268 9.64604 7.45138 9.81314 7.70398C9.98024 7.95788 10.0631 8.24218 10.0631 8.55788C10.0631 8.88028 9.98554 9.15258 9.83024 9.37628C9.67494 9.59998 9.48414 9.77098 9.25784 9.89078V9.94468C9.55654 10.0697 9.79994 10.2605 9.99204 10.5171C10.1828 10.7737 10.2788 11.0803 10.2788 11.4382C10.2788 11.7961 10.188 12.1158 10.0064 12.3961C9.82484 12.6764 9.57354 12.8974 9.25514 13.0579C8.93544 13.2184 8.57624 13.3 8.17754 13.3C7.71574 13.3013 7.28944 13.1684 6.89604 12.9026Z"
                                                            fill="#1A73E8" />
                                                        <path
                                                            d="M12.5 8.37099L11.5026 9.09599L11.0013 8.33549L12.8 7.03809H13.4895V13.1578H12.5V8.37099Z"
                                                            fill="#1A73E8" />
                                                        <path
                                                            d="M15.2632 20.0001L20 15.2633L17.6316 14.2107L15.2632 15.2633L14.2106 17.6317L15.2632 20.0001Z"
                                                            fill="#EA4335" />
                                                        <path
                                                            d="M3.6842 17.6316L4.7368 20H15.2631V15.2632H4.7368L3.6842 17.6316Z"
                                                            fill="#34A853" />
                                                        <path
                                                            d="M1.5789 0C0.7066 0 0 0.7066 0 1.5789V15.2631L2.3684 16.3157L4.7368 15.2631V4.7368H15.2631L16.3157 2.3684L15.2632 0H1.5789Z"
                                                            fill="#4285F4" />
                                                        <path
                                                            d="M0 15.2632V18.4211C0 19.2935 0.7066 20 1.5789 20H4.7368V15.2632H0Z"
                                                            fill="#188038" />
                                                        <path
                                                            d="M15.2632 4.73668V15.263H20V4.73668L17.6316 3.68408L15.2632 4.73668Z"
                                                            fill="#FBBC04" />
                                                        <path
                                                            d="M20 4.7368V1.5789C20 0.7065 19.2934 0 18.4211 0H15.2632V4.7368H20Z"
                                                            fill="#1967D2" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_53_1907">
                                                            <rect width="20" height="20" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                {{ __('Google Calendar') }}</a>
                                            <a class="jm-btn-microsoft-outlook d-flex" id="addToOutlook"><svg
                                                    width="22" height="20" viewBox="0 0 22 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_53_1921)">
                                                        <path
                                                            d="M21.4999 10.5C21.5011 10.3319 21.4142 10.1754 21.2709 10.0875H21.2684L21.2594 10.0825L13.8094 5.67251C13.7773 5.65077 13.7439 5.63091 13.7094 5.61301C13.4218 5.46461 13.0801 5.46461 12.7924 5.61301C12.758 5.63092 12.7246 5.65077 12.6924 5.67251L5.24245 10.0825L5.23346 10.0875C5.00576 10.2291 4.93596 10.5285 5.07755 10.7562C5.11927 10.8233 5.17673 10.8792 5.24495 10.919L12.6949 15.329C12.7272 15.3505 12.7606 15.3704 12.795 15.3885C13.0826 15.5369 13.4243 15.5369 13.712 15.3885C13.7463 15.3704 13.7797 15.3506 13.812 15.329L21.262 10.919C21.4108 10.8322 21.5016 10.6723 21.4999 10.5Z"
                                                            fill="#0A2767" />
                                                        <path
                                                            d="M6.111 7.5555H11V12.037H6.111V7.5555ZM20.5 3V0.949995C20.5117 0.437448 20.106 0.0122818 19.5935 0H6.90651C6.39396 0.0122818 5.98826 0.437448 6 0.949995V3L13.5 4.99999L20.5 3Z"
                                                            fill="#0364B8" />
                                                        <path d="M6 3H11V7.5H6V3Z" fill="#0078D4" />
                                                        <path d="M16 3H11V7.5L16 12H20.5V7.5L16 3Z" fill="#28A8EA" />
                                                        <path d="M11 7.5H16V12H11V7.5Z" fill="#0078D4" />
                                                        <path d="M11 12H16V16.5H11V12Z" fill="#0364B8" />
                                                        <path d="M6.11096 12.0369H11V16.1109H6.11096V12.0369Z"
                                                            fill="#14447D" />
                                                        <path d="M16 12H20.5V16.5H16V12Z" fill="#0078D4" />
                                                        <path
                                                            d="M21.271 10.8915L21.2615 10.8965L13.8115 15.0865C13.779 15.1065 13.746 15.1255 13.7115 15.1425C13.5849 15.2028 13.4475 15.2368 13.3075 15.2425L12.9005 15.0045C12.8661 14.9872 12.8327 14.968 12.8005 14.947L5.2505 10.638H5.247L5 10.5V18.982C5.00385 19.5479 5.46559 20.0036 6.03149 20H20.4845C20.493 20 20.5005 19.996 20.5095 19.996C20.629 19.9884 20.7468 19.9638 20.8595 19.923C20.9081 19.9024 20.9551 19.878 21 19.85C21.0335 19.831 21.091 19.7895 21.091 19.7895C21.3471 19.6 21.4987 19.3006 21.5 18.982V10.5C21.4998 10.6622 21.4123 10.8118 21.271 10.8915Z"
                                                            fill="url(#paint0_linear_53_1921)" />
                                                        <path opacity="0.5"
                                                            d="M21.1 10.4665V10.9865L13.31 16.35L5.245 10.6415C5.245 10.6388 5.24275 10.6365 5.24 10.6365L4.5 10.1915V9.81653L4.805 9.81152L5.45 10.1815L5.46499 10.1865L5.51999 10.2215C5.51999 10.2215 13.1 14.5465 13.12 14.5565L13.41 14.7265C13.435 14.7165 13.46 14.7065 13.49 14.6965C13.505 14.6865 21.015 10.4615 21.015 10.4615L21.1 10.4665Z"
                                                            fill="#0A2767" />
                                                        <path
                                                            d="M21.271 10.8915L21.2615 10.897L13.8115 15.087C13.779 15.107 13.746 15.126 13.7115 15.143C13.4221 15.2843 13.0838 15.2843 12.7945 15.143C12.7602 15.126 12.7268 15.1073 12.6945 15.087L5.2445 10.897L5.2355 10.8915C5.09167 10.8135 5.00149 10.6636 5 10.5V18.982C5.00358 19.5478 5.46516 20.0036 6.03095 20C6.03095 20 6.03098 20 6.031 20H20.469C21.0348 20.0036 21.4964 19.5478 21.5 18.982C21.5 18.982 21.5 18.982 21.5 18.982V10.5C21.4998 10.6622 21.4123 10.8118 21.271 10.8915Z"
                                                            fill="#1490DF" />
                                                        <path opacity="0.1"
                                                            d="M13.9199 15.0249L13.8084 15.0874C13.7761 15.108 13.7427 15.1268 13.7084 15.1439C13.5856 15.2042 13.452 15.2396 13.3154 15.2479L16.1499 18.5999L21.0944 19.7914C21.2299 19.6891 21.3377 19.5545 21.4079 19.3999L13.9199 15.0249Z"
                                                            fill="#263B56" />
                                                        <path opacity="0.05"
                                                            d="M14.4249 14.741L13.8084 15.0875C13.7761 15.108 13.7427 15.1269 13.7084 15.144C13.5856 15.2043 13.452 15.2396 13.3154 15.248L14.6434 18.9095L21.0959 19.79C21.3501 19.5991 21.4998 19.2998 21.4999 18.982V18.8725L14.4249 14.741Z"
                                                            fill="#263B56" />
                                                        <path
                                                            d="M6.045 20H20.4675C20.6894 20.0011 20.9059 19.931 21.085 19.8L12.9 15.0055C12.8656 14.9882 12.8322 14.969 12.8 14.948L5.24999 10.639H5.24649L5 10.5V18.953C4.99944 19.5307 5.4673 19.9994 6.045 20Z"
                                                            fill="#28A8EA" />
                                                        <path opacity="0.1"
                                                            d="M12 4.9165V15.5815C11.9991 15.9554 11.7717 16.2915 11.425 16.4315C11.3176 16.4777 11.2019 16.5015 11.085 16.5015H5V4.5H6V4H11.085C11.5901 4.00191 11.9989 4.41137 12 4.9165Z"
                                                            fill="#263B56" />
                                                        <path opacity="0.2"
                                                            d="M11.5 5.41654V16.0815C11.5013 16.2023 11.4756 16.3219 11.425 16.4315C11.2861 16.7738 10.9544 16.9983 10.585 17H5V4.50004H10.585C10.7301 4.49859 10.8731 4.53477 11 4.60505C11.3065 4.75946 11.4999 5.07334 11.5 5.41654Z"
                                                            fill="#263B56" />
                                                        <path opacity="0.2"
                                                            d="M11.5 5.41654V15.0815C11.4976 15.5864 11.0899 15.9957 10.585 16H5V4.50004H10.585C10.7301 4.49859 10.8731 4.53477 11 4.60505C11.3065 4.75946 11.4999 5.07334 11.5 5.41654Z"
                                                            fill="#263B56" />
                                                        <path opacity="0.2"
                                                            d="M11 5.4165V15.0815C10.9995 15.5872 10.5907 15.9975 10.085 16H5V4.5H10.085C10.5906 4.50027 11.0003 4.91038 11 5.416C11 5.41617 11 5.41633 11 5.4165Z"
                                                            fill="#263B56" />
                                                        <path
                                                            d="M0.916496 4.5H10.0835C10.5897 4.5 11 4.91034 11 5.4165V14.5835C11 15.0897 10.5897 15.5 10.0835 15.5H0.916496C0.410324 15.5 0 15.0896 0 14.5835V5.4165C0 4.91034 0.410336 4.5 0.916496 4.5Z"
                                                            fill="url(#paint1_linear_53_1921)" />
                                                        <path
                                                            d="M2.86452 8.34409C3.0904 7.86283 3.455 7.46008 3.91152 7.1876C4.41708 6.89816 4.99271 6.75386 5.57502 6.77059C6.11473 6.75889 6.64728 6.8957 7.11452 7.16609C7.55382 7.42807 7.90763 7.81193 8.13302 8.27109C8.37846 8.77703 8.50079 9.33385 8.49002 9.89609C8.50192 10.4837 8.37606 11.0659 8.12252 11.5961C7.89177 12.0717 7.52673 12.4692 7.07252 12.7396C6.58727 13.0183 6.03494 13.1587 5.47552 13.1456C4.92429 13.1589 4.37999 13.0205 3.90202 12.7456C3.45891 12.4833 3.10066 12.099 2.87002 11.6386C2.62312 11.1399 2.49934 10.5894 2.50903 10.0331C2.49874 9.45049 2.62027 8.87312 2.86452 8.34409ZM3.98052 11.0591C4.10095 11.3633 4.30518 11.6272 4.56951 11.8201C4.83875 12.0083 5.16114 12.1053 5.48951 12.0971C5.83921 12.1109 6.18391 12.0105 6.47151 11.8111C6.73249 11.6188 6.93136 11.3542 7.04351 11.0501C7.16887 10.7104 7.23074 10.3506 7.22601 9.98859C7.22988 9.6231 7.17173 9.25962 7.054 8.91359C6.95003 8.60118 6.75757 8.3257 6.50001 8.12059C6.21962 7.91171 5.87584 7.80576 5.52651 7.82059C5.19102 7.8119 4.86141 7.90975 4.58501 8.10009C4.31621 8.29378 4.1081 8.55999 3.98501 8.86759C3.71196 9.57266 3.71054 10.354 3.98101 11.0601L3.98052 11.0591Z"
                                                            fill="white" />
                                                        <path d="M16 3H20.5V7.5H16V3Z" fill="#50D9FF" />
                                                    </g>
                                                    <defs>
                                                        <linearGradient id="paint0_linear_53_1921" x1="13.25"
                                                            y1="10.5" x2="13.25" y2="20"
                                                            gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="#35B8F1" />
                                                            <stop offset="1" stop-color="#28A8EA" />
                                                        </linearGradient>
                                                        <linearGradient id="paint1_linear_53_1921" x1="1.91092"
                                                            y1="3.78387" x2="9.08907" y2="16.2161"
                                                            gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="#1784D9" />
                                                            <stop offset="0.5" stop-color="#107AD5" />
                                                            <stop offset="1" stop-color="#0A63C9" />
                                                        </linearGradient>
                                                        <clipPath id="clip0_53_1921">
                                                            <rect width="21.5" height="20" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                {{ __('Microsoft Outlook') }}</a>
                                        </dt>
                                    </dl>
                                    <div class="jm-meeting-actions d-flex">
                                        <a href="{{ $firstMeeting ? route('meeting', ['id' => $firstMeeting->meeting_id]) : '' }}"
                                            class="btn btn-primary" id="meetingStart">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-send-2 me-0 me-sm-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M4.698 4.034l16.302 7.966l-16.302 7.966a.503 .503 0 0 1 -.546 -.124a.555 .555 0 0 1 -.12 -.568l2.468 -7.274l-2.468 -7.274a.555 .555 0 0 1 .12 -.568a.503 .503 0 0 1 .546 -.124z" />
                                                <path d="M6.5 12h14.5" />
                                            </svg>
                                            {{ __('Start') }}
                                        </a>
                                        <a id="copyParticularMeeting" class="btn btn-outline-primary"
                                            data-bs-toggle="toast" data-bs-target="#toast-simple">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-copy me-0 me-sm-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                <path
                                                    d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                            </svg>
                                            {{ __('Copy link') }}
                                        </a>
                                        <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#embed">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-code me-0 me-sm-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 8l-4 4l4 4" />
                                                <path d="M17 8l4 4l-4 4" />
                                                <path d="M14 4l-4 16" />
                                            </svg>
                                            {{ __('Embed') }}
                                        </a>
                                    </div>
                                    <!-- meeting details end here-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="meetingTemplate" style="display: none;">
        <a class="nav-link text-start mw-100 jm-meeting-card" data-bs-toggle="pill" role="tab" aria-selected="true"
            data-title="" data-description="" data-id="" data-auto="" data-password="" data-date=""
            data-time="" data-timezone="">
            <div class="row align-items-center flex-fill">
                <div class="col text-body">
                    <div class="d-flex justify-content-between">
                        <h3 class="m-0"></h3>
                        <div class="text-secondary" title="{{ __('Just Now') }}">{{ __('Just Now') }}</div>
                    </div>
                    <div class="text-secondary text-truncate mb-2"></div>
                    <div class="d-flex justify-content-between">
                        <div class="text-secondary">{{ __('Meeting ID') }}: </div>
                        <div class="text-secondary d-flex jm-meeting-date"></div>
                    </div>
                </div>
            </div>
        </a>
    </div>


    <!-- Libs JS -->
    <!-- create meeting modal start here -->
    <div class="modal modal-blur fade" id="createMeetingModal" tabindex="1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="createMeetingsForm" data-action="{{ route('createMeeting') }}" class="mb-0">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Create Meeting') }} | ID: <span id="createMeetingId"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Title') }}*</label>
                            <input id="title" name="title" type="text" class="form-control"
                                placeholder="{{ __('Enter meeting title') }}" minlength="3" maxlength="100" required
                                autofocus>
                            <small class="invalid-feedback"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Description') }}</label>
                            <textarea id="description" name="description" class="form-control" rows="4"
                                placeholder="{{ __('Enter meeting description') }}"></textarea>
                            <small class="invalid-feedback"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Password') }}</label>
                            <input id="password" name="password" type="text" class="form-control"
                                placeholder="{{ __('Enter meeting password') }}" minlength="4" maxlength="8">
                            <small class="invalid-feedback"></small>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Date') }}</label>
                                    <div class="input-group input-group-flat">
                                        <input id="date" name="date" type="date" class="form-control">
                                        <small class="invalid-feedback"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Time') }}</label>
                                    <div class="input-group input-group-flat">
                                        <input id="time" name="time" type="time" class="form-control">
                                        <small class="invalid-feedback"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Time Zone') }}</label>
                            <select id="timezone" name="timezone" type="text" class="form-select" value="">
                                <option value="">{{ __('Select meeting timezone') }}</option>
                                @foreach ($timezones as $timezone)
                                    <option value="{{ $timezone['value'] }}">{{ $timezone['value'] }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="invalid-feedback"></small>
                        </div>

                        <input type="hidden" id="createMeetingsFormId" name="meeting_id" />
                    </div>
                    <div class="modal-footer">
                        <a href="" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </a>
                        <button id="createMeetingButton" class="btn btn-primary ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            {{ __('Create new meeting') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- create meeting modal end here -->

    <!-- edit meeting modal start here -->
    <div class="modal modal-blur fade" id="editMeetingModal" tabindex="1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="editMeetingsForm" data-action="{{ route('editMeeting') }}" class="mb-0">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Edit Meeting') }} | ID: <span id="meetingIdEdit"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Title') }}*</label>
                            <input id="titleEdit" name="title" type="text" class="form-control"
                                placeholder="{{ __('Enter meeting title') }}" minlength="3" maxlength="100" required
                                autofocus>
                            <small class="invalid-feedback"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Description') }}</label>
                            <textarea id="descriptionEdit" name="description" class="form-control" rows="4"
                                placeholder="{{ __('Enter meeting description') }}"></textarea>
                            <small class="invalid-feedback"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Password') }}</label>
                            <input id="passwordEdit" name="password" type="text" class="form-control"
                                placeholder="{{ __('Enter meeting password') }}" minlength="4" maxlength="8">
                            <small class="invalid-feedback"></small>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Date') }}</label>
                                    <div class="input-group input-group-flat">
                                        <input id="dateEdit" name="date" type="date" class="form-control">
                                        <small class="invalid-feedback"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Time') }}</label>
                                    <div class="input-group input-group-flat">
                                        <input id="timeEdit" name="time" type="time" class="form-control">
                                        <small class="invalid-feedback"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Time Zone') }}</label>
                            <select id="timezoneEdit" name="timezone" type="text" class="form-select"
                                value="">
                                <option value="">{{ __('Select meeting timezone') }}</option>
                                @foreach ($timezones as $timezone)
                                    <option value="{{ $timezone['value'] }}">{{ $timezone['value'] }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="invalid-feedback"></small>
                        </div>

                        <input type="hidden" id="meetingsFormIdEdit" name="id" />
                    </div>
                    <div class="modal-footer">
                        <a href="" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </a>
                        <button id="updateMeetingButton" class="btn btn-primary ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit me-0 me-sm-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                            {{ __('Update meeting') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- create meeting modal end here -->

    <!-- invite modal start here -->
    <div class="modal modal-blur fade" id="Invite" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Invite People') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="inviteForm" class="mb-0">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="passwordEdit" class="col-lg-3 col-md-3">{{ __('Email') }}</label>
                            <div class="col-lg-6 col-md-6">
                                <select id="inviteEmail" name="emails[]" multiple>
                                    @foreach ($contacts as $contact)
                                        <option value="{{ $contact->email }}">{{ $contact->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body p-0 jm-invite-list">
                        <div class="list-group list-group-flush"></div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </a>
                        <button class="btn btn-primary ms-auto" data-bs-dismiss="modal" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-send-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M4.698 4.034l16.302 7.966l-16.302 7.966a.503 .503 0 0 1 -.546 -.124a.555 .555 0 0 1 -.12 -.568l2.468 -7.274l-2.468 -7.274a.555 .555 0 0 1 .12 -.568a.503 .503 0 0 1 .546 -.124z">
                                </path>
                                <path d="M6.5 12h14.5"></path>
                            </svg>
                            {{ __('Invite') }}
                        </button>
                        <input type="hidden" id="inviteId" name="id" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- invite modal end here -->
    <!-- embed modal start here -->
    <div class="modal modal-blur fade" id="embed" tabindex="1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Embed') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="form-label">{{ __('Embed a copy of your deck anywhere.') }}</label>
                        <textarea class="form-control border-0 jm-meeting-embed" rows="5" id="embedTextarea" readonly></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </a>
                    <a class="btn btn-primary ms-auto" id="copyEmbedCode">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-copy">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z">
                            </path>
                            <path
                                d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1">
                            </path>
                        </svg>
                        {{ __('Embed Code') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- embed modal end here -->
@endsection

@section('script')
    <script>
        let meetingId;
        let meetingExist = "{{ !$meetings->isEmpty() }}" || null;
        let timeLimit = "{{ $timeLimit }}";


        if (meetingExist) {
            $('.jm-meeting-card:first').addClass('active');
            meetingId = "{{ $firstMeeting ? $firstMeeting->id : '' }}";
        }
    </script>
    <script src="{{ asset('/js/tom-select.complete.min.js') }}"></script>

    <script src="{{ asset('/js/dashboard.js') }}"></script>
@endsection
