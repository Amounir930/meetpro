@extends('layouts.app')

@section('title', $page . ' - ' . $meeting->title)

@section('styles')
    <link href="{{ asset('/css/bootstrap-icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/meeting.css?version=') . getVersion() }}" rel="stylesheet" />
@endsection

@section('content')
    @include('include.user.header')

    <canvas id="audioOnly" hidden></canvas>
    <div class="page jm-meeting meeting-details">
        <div class="page-wrapper">
            <!-- Page body -->
            <div class="page-body mb-0 d-flex justify-content-center align-items-center">
                <div class="d-flex justify-content-center align-items-center jm-meeting-center">
                    <div class="container-xl">
                        <div class="jm-meeting-start-space d-flex justify-content-center align-items-center">
                            <!-- Video start here -->
                            <div class="jm-video-part-width">
                                <div class="jm-video-part position-relative d-flex mb-3">
                                    <video id="previewVideo" class="cam" autoplay playsinline muted></video>
                                    <div
                                        class="jm-no-camera-found position-absolute w-100 h-100 top-0 d-flex align-items-center justify-content-center z-1">
                                        <h3>{{ __('Camera is off') }}</h3>
                                    </div>
                                    <div
                                        class="jm-video-action position-absolute w-100 bottom-0 mb-4 d-flex align-items-center justify-content-center z-3">
                                        <a id="toggleMicPreview" class="btn btn-outline-light disabled"
                                            title="{{ __('Mute/Unmute Mic') }}">
                                            <i class="bi bi-mic-mute"></i>
                                        </a>
                                        <a id="toggleCameraPreview" class="btn btn-outline-light disabled"
                                            title="{{ __('On/Off Camera') }}">
                                            <i class="bi bi-camera-video-off"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- video error start here -->
                                <div class="jm-video-error d-flex justify-content-between">
                                    <a id="micError" class="btn btn-outline-danger small p-2">
                                        <i class="bi bi-mic-mute"></i>&nbsp;
                                        <span class="small"></span>
                                    </a>
                                    <a id="camError" class="btn btn-outline-danger small p-2">
                                        <i class="bi bi-camera-video-off"></i>&nbsp;
                                        <span class="small"></span>
                                    </a>
                                </div>
                                <!-- video error end here -->
                            </div>
                            <!-- Video end here -->
                            <!-- meeting details start here -->
                            <div class="jm-meeting-start-details-width">
                                <form id="passwordCheck">
                                    <div class="jm-meeting-start-details d-flex align-items-start flex-column">
                                        <div class="jm-meeting-start-heading">
                                            <span
                                                class="badge @if (isDemoMode()) bg-yellow @else bg-blue @endif text-blue-fg">
                                                @if (isDemoMode())
                                                    <div>{{ __('Meeting duration in demo mode is 10 minutes.') }}</div>
                                                @elseif ($meeting->timeLimit == '-1')
                                                    {{ __('Unlimited Minutes') }}
                                                @else
                                                    {{ $meeting->timeLimit }} {{ __('Minutes') }}
                                                @endif
                                            </span>
                                            <h2 class="mb-1 mt-2">{{ $meeting->title }}</h2>
                                            <p class="m-0">{{ $meeting->description }}</p>
                                        </div>

                                        <div class="jm-meeting-start-body d-flex flex-column">
                                            <div class="d-flex jm-meeting-start-item-list">
                                                <div class="jm-meeting-start-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-video me-1">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M15 10l4.553 -2.276a1 1 0 0 1 1.447 .894v6.764a1 1 0 0 1 -1.447 .894l-4.553 -2.276v-4z" />
                                                        <path
                                                            d="M3 6m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" />
                                                    </svg>
                                                    <strong>{{ $meeting->meeting_id }}</strong>
                                                </div>
                                                <div class="jm-meeting-start-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-calendar me-1">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                        <path d="M16 3v4" />
                                                        <path d="M8 3v4" />
                                                        <path d="M4 11h16" />
                                                        <path d="M11 15h1" />
                                                        <path d="M12 15v3" />
                                                    </svg>
                                                    <strong
                                                        id="date">{{ $meeting->date ? formatDate($meeting->date) : '00-00-0000' }}</strong>
                                                </div>
                                                <div class="jm-meeting-start-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-4 me-1">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                        <path d="M12 12l3 2" />
                                                        <path d="M12 7v5" />
                                                    </svg>
                                                    <strong
                                                        id="time">{{ $meeting->time ? formatTime($meeting->time) : '00:00 00' }}</strong>
                                                </div>
                                            </div>
                                            <div class="jm-meeting-start-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-timezone me-1">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M20.884 10.554a9 9 0 1 0 -10.337 10.328" />
                                                    <path d="M3.6 9h16.8" />
                                                    <path d="M3.6 15h6.9" />
                                                    <path d="M11.5 3a17 17 0 0 0 -1.502 14.954" />
                                                    <path d="M12.5 3a17 17 0 0 1 2.52 7.603" />
                                                    <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                    <path d="M18 16.5v1.5l.5 .5" />
                                                </svg>
                                                <strong
                                                    id="timezone">{{ $meeting->timezone ? $meeting->timezone : '-' }}</strong>
                                            </div>

                                            <div class="form-group" @if (Auth::check()) hidden @endif>
                                                <label class="form-label" for="username">{{ __('Username') }}</label>
                                                <input type="text" class="form-control" id="username"
                                                    placeholder="{{ __('Enter your name') }}"
                                                    value="{{ $meeting->username }}" maxlength="25">
                                            </div>

                                            @if ($meeting->password)
                                                <div class="form-group">
                                                    <label class="form-label" for="password">{{ __('Meeting Password') }} *</label>
                                                    <input type="text" id="password" class="form-control" name="password"
                                                        placeholder="{{ __('Enter meeting password') }}">
                                                </div>
                                                <input type="hidden" name="id" value="{{ $meeting->id }}">
                                            @endif
                                        </div>
                                        <div class="jm-meeting-start-action d-flex">
                                            <button id="joinMeeting" type="submit" class="btn btn-primary" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-send-2">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M4.698 4.034l16.302 7.966l-16.302 7.966a.503 .503 0 0 1 -.546 -.124a.555 .555 0 0 1 -.12 -.568l2.468 -7.274l-2.468 -7.274a.555 .555 0 0 1 .12 -.568a.503 .503 0 0 1 .546 -.124z">
                                                    </path>
                                                    <path d="M6.5 12h14.5"></path>
                                                </svg>
                                                <span>{{ __('Loading') }}</span>
                                            </button>
                                            <a class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#modal-setting">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle m-0">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                    <path d="M12 9h.01" />
                                                    <path d="M11 12h1v4h1" />
                                                </svg>
                                            </a>
                                            <a class="btn btn-outline-primary add">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-share m-0">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                    <path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                    <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                    <path d="M8.7 10.7l6.6 -3.4" />
                                                    <path d="M8.7 13.3l6.6 3.4" />
                                                </svg>
                                            </a>
                                        </div>
                                        @if (getSetting('MODERATOR_RIGHTS') == 'enabled')
                                            @guest
                                                <div class="alert alert-warning " role="alert">
                                                    <div class="alert-icon">
                                                        <!-- Download SVG icon from http://tabler.io/icons/icon/alert-triangle -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon alert-icon icon-2">
                                                            <path d="M12 9v4"></path>
                                                            <path
                                                                d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                                            </path>
                                                            <path d="M12 16h.01"></path>
                                                        </svg>
                                                    </div>
                                                    {{ __('If you are the moderator, please') }}
                                                    <a href="{{ route('login') }}"
                                                        class="alert-action">{{ __('Login') }}</a>
                                                </div>
                                            @endguest
                                        @endif
                                        <div id="error">
                                            <p>{{ __('Could not connect to the server, please try refreshing the page') }}
                                            </p>
                                            @if ($meeting->isAdmin)
                                                <a href="{{ route('admin.signaling-server') }}" target="_blank"><span
                                                        class="badge bg-yellow text-yellow-fg p-2"><i
                                                            class="bi bi-exclamation-triangle"></i>
                                                        {{ __('Troubleshooting steps (Visible to the admin only)') }}</span></a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- meeting details end here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- meetinhg end here  -->
    <!-- start call start here  -->
    <div class="page jm-start-call meeting-section d-none">
        <div class="page-wrapper">
            <!-- mobile header start here -->
            <div class="jm-start-call-mobile-header d-flex d-lg-none justify-content-between">
                <div class="jm-call-start-logo d-flex align-items-center">
                    <img src="{{ asset('/storage/images/' . getSetting('FAVICON')) }}" alt="{{ __('Logo') }}"
                        width="38">
                    <div class="jm-start-call-name">
                        <p class="m-0 meeting-id"></p>
                        <h3 class="m-0 timer">00:00:00</h3>
                    </div>
                </div>
                <div class="dropdown">
                    <a class="btn-action dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" data-bs-theme="dark">
                        <a class="dropdown-item muteAll">{{ __('Mute All') }}</a>
                        <a class="dropdown-item showParticipantList" data-bs-toggle="modal"
                            data-bs-target="#modal-participants">{{ __('Participants') }}</a>
                        <a class="dropdown-item openChat">{{ __('Group Chat') }}</a>
                        <a class="dropdown-item openChatGPT">{{ __('AI Chatbot') }}</a>
                        <a class="dropdown-item recording">{{ __('Start/Stop Recording') }}</a>
                        <a class="dropdown-item openSettings">{{ __('Open Settings') }}</a>
                    </div>
                </div>
            </div>
            <!-- mobile header end here -->
            <!-- Page body -->
            <div class="page-body mb-0 d-flex justify-content-center align-items-center">
                <div class="d-flex justify-content-center align-items-center jm-meeting-center">
                    <div class="container-xl">
                        <div class="jm-meeting-start-space d-flex justify-content-between align-items-center">
                            <!-- start call videos start here -->
                            <div id="videos" class="jm-start-call-uservideo d-flex">
                                <!-- user video item 1 -->
                                <div id="selfContainer" class="videoContainer ot-layout">
                                    <audio id="localAudio" autoplay muted></audio>
                                    <video id="localVideo" class="cam" autoplay playsinline></video>

                                    <div class="jm-call-start-avatar position-absolute top-50 start-50 translate-middle">
                                        @if (getAuthUserInfo('avatar'))
                                            <img src="{{ asset('storage/avatars/' . getAuthUserInfo('avatar')) }}"
                                                class="avatar avatar-xl rounded" />
                                        @else
                                            <span
                                                class="avatar avatar-xl rounded">{{ getAuthUserInfo('username') ? getAuthUserInfo('username')[0] : '' }}</span>
                                        @endif
                                    </div>

                                    <div class="jm-start-call-username position-absolute bottom-0 start-0 m-2">
                                        <span class="tag local-user-name">
                                            {{ __('You') }}
                                            <i class='bi bi-gem moderator-icon' title='{{ __('Moderator') }}'
                                                @if (!$meeting->isModerator) style="display: none" @endif></i>
                                        </span>
                                    </div>
                                </div>

                                <div id="screenContainer" class="videoContainer OT_big screen">
                                    <audio id="localScreenAudio" autoplay muted></audio>
                                    <video id="localScreenVideo" autoplay playsinline></video>
                                    <div class="jm-start-call-username position-absolute bottom-0 start-0 m-2">
                                        <span class="tag">
                                            {{ __('Your screen') }}
                                        </span>
                                    </div>
                                </div>
                                <!-- user video item 1 -->
                                <!-- user video item 1 -->

                                <!-- user video item 1 -->
                            </div>
                            <!-- start call videos end here -->
                            <!-- Chat start here -->
                            <div id="groupChat" data-bs-theme="dark"
                                class="card jm-start-call-sidepanel jm-start-call-chat chat-hide">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('Group Chat') }}</h3>
                                    <div class="card-actions btn-actions">
                                        <a class="btn-action close-panel">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body scrollable jm-card-body">
                                    <div class="chat">
                                        <div class="chat-bubbles">
                                            <div class="empty-chat-body">
                                                <i class="bi bi-chat-left chat-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <form id="chatForm">
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="messageInput" class="form-control"
                                                autocomplete="off" placeholder="{{ __('Type a message') }}"
                                                maxlength="250">
                                            <span class="input-group-text">
                                                <a id="emojiPicker" class="link-secondary" data-bs-toggle="tooltip"
                                                    aria-label="{{ __('Emoji') }}"
                                                    data-bs-original-title="{{ __('Emoji') }}">
                                                    <i class="bi bi-emoji-smile"></i>
                                                </a>
                                                <a id="selectFile" class="link-secondary ms-2" data-bs-toggle="tooltip"
                                                    aria-label="{{ __('Attach File') }}"
                                                    data-bs-original-title="{{ __('Attach File') }}">
                                                    <i class="bi bi-paperclip"></i>
                                                </a>
                                                <a id="sendMessage" class="link-secondary ms-2" data-bs-toggle="tooltip"
                                                    aria-label="{{ __('Send') }}"
                                                    data-bs-original-title="{{ __('Send') }}">
                                                    <i class="bi bi-send"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </form>
                                    <input type="file" name="file" id="file" hidden />
                                </div>
                            </div>
                            <!-- Chat end here -->

                            <!-- ChatGPT start here -->

                            <div id="chatGPTChat" data-bs-theme="dark"
                                class="card jm-start-call-sidepanel jm-start-call-chat chat-hide">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <img src="/images/chatgpt-logo.png" width="30" alt="{{ __('ChatGPT') }}" />
                                        {{ __('ChatGPT') }}
                                    </h3>
                                    <div class="card-actions btn-actions">
                                        <a class="btn-action close-panel-chatgpt">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body scrollable jm-card-body">
                                    <div class="chat">
                                        <div class="chat-bubbles">
                                            <div class="empty-chat-body">
                                                <i class="bi bi-chat-left chat-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <form id="chatGPTchatForm">
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="chatGPTmessageInput" class="form-control"
                                                autocomplete="off" placeholder="{{ __('Message ChatGPT') }}"
                                                maxlength="250">
                                            <span class="input-group-text">
                                                <a id="chatGPTSendMessage" class="link-secondary ms-2"
                                                    data-bs-toggle="tooltip" aria-label="{{ __('Send') }}"
                                                    data-bs-original-title="{{ __('Send') }}">
                                                    <i class="bi bi-send"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Chat end here -->

                            <!-- white board start here -->
                            <div class="card jm-start-call-sidepanel jm-start-call-whiteboard d-none">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('Whiteboard') }}</h3>
                                    <div class="card-actions btn-actions">
                                        <a class="btn-action">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M18 6l-12 12" />
                                                <path d="M6 6l12 12" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body scrollable jm-card-body">
                                    <!-- add here white board iframe-->
                                </div>
                            </div>
                            <!-- white board end here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- call start action button start here -->
            <div class="jm-call-start-actin d-flex justify-content-between">
                <!-- logo and name start here -->
                <div class="jm-call-start-logo d-flex align-items-center d-none d-lg-flex">
                    <img src="{{ asset('/storage/images/' . getSetting('FAVICON')) }}" alt="{{ __('Logo') }}"
                        width="38">
                    <div class="jm-start-call-name">
                        <p class="m-0 meeting-id"></p>
                        <h3 class="m-0 timer">00:00:00</h3>
                    </div>
                </div>
                <!-- logo and name end here -->
                <!-- main action center button start here-->
                <div class="jm-video-action d-flex align-items-center justify-content-center">
                    <a class="btn btn-outline-light" title="{{ __('Mute/Unmute Mic') }}" id="toggleMic">
                        <i class="bi bi-mic"></i>
                    </a>
                    <a class="btn btn-outline-light" title="{{ __('On/Off Camera') }}" id="toggleVideo">
                        <i class="bi bi-camera-video"></i>
                    </a>
                    <a class="btn btn-outline-light d-none d-lg-flex" title="{{ __('Start/Stop ScreenShare') }}"
                        id="screenShare">
                        <i class="bi bi-display"></i>
                    </a>
                    <a class="btn btn-outline-light d-lg-flex" title="{{ __('Whiteboard') }}" id="whiteboard">
                        <i class="bi bi-person-video3"></i>
                    </a>
                    <a class="btn btn-outline-light" title="{{ __('Raise Hand') }}" id="raiseHand">
                        <i class="bi bi-hand-index-thumb"></i>
                    </a>
                    <a class="btn btn-danger" title="{{ __('Leave Meeting') }}" id="leave">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                </div>
                <!-- main action center button end here-->
                <!-- main action right button start here-->
                <div class="jm-video-action d-flex align-items-center justify-content-center d-none d-lg-flex">
                    <a class="btn btn-outline-light muteAll" title="{{ __('Mute/Unmute All') }}">
                        <i class="bi bi-person-check"></i>
                    </a>
                    <a class="btn btn-outline-light showParticipantList" data-bs-toggle="modal"
                        data-bs-target="#modal-participants" title="{{ __('Participants') }}">
                        <i class="bi bi-people"></i>
                    </a>
                    <a class="btn btn-outline-light openChat" title="{{ __('Group Chat') }}">
                        <i class="bi bi-chat-left"></i>
                    </a>
                    <a class="btn btn-outline-light openChatGPT" title="{{ __('AI Chatbot') }}">
                        <i class="bi bi-magic"></i>
                    </a>
                    <a class="btn btn-outline-light recording" title="{{ __('Start/Stop Recording') }}">
                        <i class="bi bi-record-circle"></i>
                    </a>
                    <a class="btn btn-outline-light openSettings" title="{{ __('Open Settings') }}">
                        <i class="bi bi-gear"></i>
                    </a>
                </div>
                <!-- main action right button end here-->
            </div>
            <!-- call start  action button end here -->
        </div>
    </div>
    <!-- start call end here  -->
    <!-- meeting info modal start here -->
    <div class="modal modal-blur fade" id="modal-setting" tabindex="-1" role="dialog" aria-labelledby="modalSettingLabel" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSettingLabel">{{ __('Settings') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body jm-meeting-shortcutkey">
                    <dl class="row m-0">
                        <dt class="col-4 mb-3">{{ __('Shortcut Keys') }}</dt>
                        <dt class="col-8 mb-3">{{ __('Action') }}</dt>
                        <dd class="col-4 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-square-letter-c">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M19 2a3 3 0 0 1 3 3v14a3 3 0 0 1 -3 3h-14a3 3 0 0 1 -3 -3v-14a3 3 0 0 1 3 -3zm-7 5a3 3 0 0 0 -3 3v4a3 3 0 0 0 6 0a1 1 0 0 0 -1.993 -.117l-.007 .117a1 1 0 0 1 -2 0v-4a1 1 0 0 1 1.993 -.117l.007 .117a1 1 0 0 0 2 0a3 3 0 0 0 -3 -3" />
                            </svg>
                        </dd>
                        <dd class="col-8 mb-3">{{ __('Chat') }}</dd>
                        <dd class="col-4 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-square-letter-f">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M19 2a3 3 0 0 1 3 3v14a3 3 0 0 1 -3 3h-14a3 3 0 0 1 -3 -3v-14a3 3 0 0 1 3 -3zm-5 5h-4a1 1 0 0 0 -1 1v8a1 1 0 0 0 1 1l.117 -.007a1 1 0 0 0 .883 -.993v-3h2a1 1 0 0 0 .993 -.883l.007 -.117a1 1 0 0 0 -1 -1h-2v-2h3a1 1 0 0 0 0 -2" />
                            </svg>
                        </dd>
                        <dd class="col-8 mb-3">{{ __('Attach File') }}</dd>
                        <dd class="col-4 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-square-letter-a">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M19 2a3 3 0 0 1 3 3v14a3 3 0 0 1 -3 3h-14a3 3 0 0 1 -3 -3v-14a3 3 0 0 1 3 -3zm-7 5a3 3 0 0 0 -3 3v6a1 1 0 0 0 2 0v-2h2v2a1 1 0 0 0 .883 .993l.117 .007a1 1 0 0 0 1 -1v-6a3 3 0 0 0 -3 -3m0 2a1 1 0 0 1 1 1v2h-2v-2a1 1 0 0 1 .883 -.993z" />
                            </svg>
                        </dd>
                        <dd class="col-8 mb-3">{{ __('Mute/Unmute Audio') }}</dd>
                        <dd class="col-4 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-square-letter-l">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M19 2a3 3 0 0 1 3 3v14a3 3 0 0 1 -3 3h-14a3 3 0 0 1 -3 -3v-14a3 3 0 0 1 3 -3zm-9 5a1 1 0 0 0 -1 1v8a1 1 0 0 0 1 1h4a1 1 0 0 0 1 -1l-.007 -.117a1 1 0 0 0 -.993 -.883h-3v-7a1 1 0 0 0 -1 -1" />
                            </svg>
                        </dd>
                        <dd class="col-8 mb-3">{{ __('Leave Meeting') }}</dd>
                        <dd class="col-4 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-square-letter-v">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M19 2a3 3 0 0 1 3 3v14a3 3 0 0 1 -3 3h-14a3 3 0 0 1 -3 -3v-14a3 3 0 0 1 3 -3zm-4.757 5.03a1 1 0 0 0 -1.213 .727l-1.03 4.118l-1.03 -4.118a1 1 0 1 0 -1.94 .486l2 8c.252 1.01 1.688 1.01 1.94 0l2 -8a1 1 0 0 0 -.727 -1.213" />
                            </svg>
                        </dd>
                        <dd class="col-8 mb-3">{{ __('On/Off Video') }}</dd>
                        <dd class="col-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-square-letter-s">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M19 2a3 3 0 0 1 3 3v14a3 3 0 0 1 -3 3h-14a3 3 0 0 1 -3 -3v-14a3 3 0 0 1 3 -3zm-6 5h-2a2 2 0 0 0 -2 2v2a2 2 0 0 0 2 2h2v2h-2a1 1 0 0 0 -2 0a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-2v-2h2l.007 .117a1 1 0 0 0 1.993 -.117a2 2 0 0 0 -2 -2" />
                            </svg>
                        </dd>
                        <dd class="col-8">{{ __('Screen Share') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <!-- meeting info modal end here -->
    <!-- file preview modal start here -->
    <div class="modal modal-blur fade" id="filePreviewModal" tabindex="-1" role="dialog" aria-labelledby="filePreviewLabel" aria-modal="true"
        data-bs-theme="dark">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filePreviewLabel">{{ __('File Preview') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body jm-meeting-shortcutkey">
                    <div class="jm-chat-file-preview text-center">
                        <img id="previewImage" src="" width="300" height="300">
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </a>
                    <a id="sendFile" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-send-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M4.698 4.034l16.302 7.966l-16.302 7.966a.503 .503 0 0 1 -.546 -.124a.555 .555 0 0 1 -.12 -.568l2.468 -7.274l-2.468 -7.274a.555 .555 0 0 1 .12 -.568a.503 .503 0 0 1 .546 -.124z">
                            </path>
                            <path d="M6.5 12h14.5"></path>
                        </svg>
                        {{ __('Send') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- file preview  modal end here -->

    <div class="modal modal-blur fade" id="displayModal" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="displayModalLabel"
        data-bs-theme="dark">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="displayModalLabel">{{ __('File Display') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="jm-chat-file-preview text-center">
                        <img id="displayImage" src="" />
                        <p id="displayFilename"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </a>
                    <a id="downloadFile" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                            <path d="M7 11l5 5l5 -5" />
                            <path d="M12 4l0 12" />
                        </svg>
                        {{ __('Download') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Participants modal start here -->
    <div class="modal modal-blur fade" id="modal-participants" tabindex="-1" role="dialog" aria-labelledby="participantsLabel" aria-modal="true"
        data-bs-theme="dark">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="participantsLabel">{{ __('Participants') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body jm-invite-list text-center">
                    <dl id="participantListBody" class="row m-0">
                        <dt class="col-4 mb-3">#</dt>
                        <dt class="col-8 mb-3">{{ __('Name') }}</dt>

                        <dd class="col-4 mb-3 participant-list-number">
                            1
                        </dd>
                        <dd class="col-8 mb-3">
                            {{ __('You') }}
                            <i class='bi bi-gem moderator-icon' title='{{ __('Moderator') }}'
                                @if (!$meeting->isModerator) style="display: none" @endif></i>
                        </dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </a>
                    <a class="btn btn-primary ms-auto add" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus me-0 me-lg-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                            <path d="M16 19h6"></path>
                            <path d="M19 16v6"></path>
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                        </svg>
                        {{ __('Invite') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Participants modal end here -->
    <!-- setting modal start here -->
    <div class="modal modal-blur fade" id="settings" tabindex="-1" role="dialog" aria-labelledby="settingsLabel" aria-modal="true" data-bs-theme="dark">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="settingsLabel">{{ __('Setting') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="videoQualitySelect">{{ __('Video Quality') }}</label>
                        <select type="text" class="form-select" id="videoQualitySelect">
                            <option id="QVGA" data-width="320" data-height="240">{{ __('QVGA') }}</option>
                            <option id="VGA" data-width="640" data-height="480" selected>{{ __('VGA') }}
                            </option>
                            <option id="HD" data-width="1280" data-height="720">{{ __('HD') }}</option>
                            <option id="FHD" data-width="1920" data-height="1080">{{ __('FHD') }}</option>
                            <option id="4K" data-width="3840" data-height="2160">{{ __('4K') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="audioSource">{{ __('Audio input source') }}</label>
                        <select type="text" class="form-select" id="audioSource"></select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="videoSource">{{ __('Video source') }}</label>
                        <select type="text" class="form-select" id="videoSource" value=""></select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="videoObjectFit">{{ __('Video object-fit') }}</label>
                        <select id="videoObjectFit" class="form-select">
                            <option value="cover">{{ __('Cover') }}</option>
                            <option value="contain">{{ __('Contain') }}</option>
                            <option value="fill">{{ __('Fill') }}</option>
                            <option value="none">{{ __('None') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </a>
                    <a class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M9 12l2 2l4 -4" />
                        </svg>
                        {{ __('Done') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- setting modal end here -->
    <!-- whiteboard modal start here -->
    <div class="modal modal-blur fade" id="showWhiteboardModal" tabindex="-1" role="dialog" aria-labelledby="whiteboardLabel" aria-modal="true"
        data-bs-theme="dark">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="whiteboardLabel">{{ __('Whiteboard') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="whiteboardSection"></div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M9 12l2 2l4 -4" />
                        </svg>
                        {{ __('Done') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- whiteboard modal end here -->

    <div id="overlay">
        <div class="overlay-wrapper">
            <p id="overlayText"></p>
            <img src="/images/allow.png" alt="{{ __('Allow Camera') }}" />
        </div>
    </div>

    <div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3 z-3"></div>
    <input type="hidden" id="siteName" value="{{ getSetting('APPLICATION_NAME') }}" />
@endsection

@section('script')
    <script type="text/javascript">
        const userInfo = {
            username: htmlEscape(username.value),
            meetingId: "{{ $meeting->meeting_id }}",
            avatar: "{{ getAuthUserInfo('avatar') }}"
        };

        //to prevent XSS vulnerability
        function htmlEscape(input) {
            return input
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }

        const passwordRequired = "{{ !!$meeting->password }}";
        const moderator = "{{ $meeting->isModerator }}";
        const meetingTitle = "{{ $meeting->title }}";
        const timeLimit = "{{ $meeting->timeLimit == -1 ? 9999 : $meeting->timeLimit }}";
        const userLimit = "{{ $meeting->userLimit == -1 ? 9999 : $meeting->userLimit }}";
        const features = JSON.parse("{{ json_encode($meeting->features) }}".replace(/&quot;/g, '"'));
        Object.freeze(features);
    </script>
    <script src="{{ asset('js/socket.io.min.js') }}"></script>
    <script src="{{ asset('js/bundle.min.js') }}"></script>
    <script src="{{ asset('js/easytimer.min.js') }}"></script>
    <script src="{{ asset('js/opentok-layout.min.js') }}"></script>
    <script src="{{ asset('js/canvas-designer-widget.js') }}"></script>
    <script src="{{ asset('js/meeting2.js') }}"></script>
    <script src="{{ asset('js/emoji.js') }}"></script>
    <script src="{{ asset('js/fix-webm-duration.min.js') }}"></script>
    <script src="{{ asset('js/meeting.js?version=') . getVersion('VERSION') }}"></script>
@endsection
