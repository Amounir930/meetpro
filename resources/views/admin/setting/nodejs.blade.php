@extends('admin.setting.index')

@section('setting-content')
<form class="col-12 col-md-9 d-flex flex-column" action="{{ route('admin.setting.update-nodejs') }}" method="post">
    @csrf
    <div class="card-body">
        <h2>{{ __(key: 'Signaling') }}</h2>
        <small class="text-muted">
            {{ __('Please restart the signaling server after making any changes to this section.') }}
        </small>

        <div class="row mb-3 mt-3">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">{{ __('SSL Key Path') }}
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="{{ __('Path to your SSL key') }}"></i>
                    </label>
                    <input type="text" name="KEY_PATH" class="form-control @error('KEY_PATH') is-invalid @enderror"
                        maxlength="100" value="{{ old('KEY_PATH') ?? getSetting('KEY_PATH') }}"
                        placeholder="{{ __('Key Path') }}">
                    @error('KEY_PATH')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">{{ __('SSL Certificate Path') }}
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="{{ __('Path to your SSL certificate') }}"></i>
                    </label>
                    <input type="text" name="CERT_PATH" class="form-control @error('CERT_PATH') is-invalid @enderror"
                        value="{{ old('CERT_PATH') ?? getSetting('CERT_PATH') }}" maxlength="100"
                        placeholder="{{ __('SSL Certificate Path') }}">
                    @error('CERT_PATH')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">{{ __('IP Address') }}
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="{{ __('Server IP address') }}"></i>
                    </label>
                    <input type="text" name="IP" class="form-control @error('IP') is-invalid @enderror"
                        maxlength="15" value="{{ old('IP') ?? getSetting('IP') }}"
                        placeholder="{{ __('IP Address') }}">
                    @error('IP')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">{{ __('Announced IP Address') }}
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="{{ __('Useful when running application behind NAT with private IP') }}"></i>
                    </label>
                    <input type="text" name="ANNOUNCED_IP"
                        class="form-control @error('ANNOUNCED_IP') is-invalid @enderror" maxlength="15"
                        value="{{ old('ANNOUNCED_IP') ?? getSetting('ANNOUNCED_IP') }}"
                        placeholder="{{ __('Announced IP Address') }}">
                    @error('ANNOUNCED_IP')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">{{ __('Port') }}
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="{{ __('Port to run NodeJS on') }}"></i>
                    </label>
                    <input type="number" min="10" max="9999" name="PORT" maxlength="4"
                        class="form-control @error('PORT') is-invalid @enderror"
                        value="{{ old('PORT') ?? getSetting('PORT') }}" placeholder="{{ __('Port') }}">
                    @error('PORT')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">{{ __('RTC MIN PORT') }}
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="{{ __('Minimun RTC port') }}"></i>
                    </label>
                    <input type="text" name="RTC_MIN_PORT" maxlength="500"
                        class="form-control @error('RTC_MIN_PORT') is-invalid @enderror"
                        value="{{ old('RTC_MIN_PORT') ?? getSetting('RTC_MIN_PORT') }}"
                        placeholder="{{ __('RTC MIN PORT') }}">
                    @error('RTC_MIN_PORT')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">{{ __('RTC MAX PORT') }}
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="{{ __('Maximum RTC port') }}"></i>
                    </label>
                    <input type="text" name="RTC_MAX_PORT" maxlength="500"
                        class="form-control @error('RTC_MAX_PORT') is-invalid @enderror"
                        value="{{ old('RTC_MAX_PORT') ?? getSetting('RTC_MAX_PORT') }}"
                        placeholder="{{ __('RTC MAX PORT') }}">
                    @error('RTC_MAX_PORT')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">{{ __('AI Chatbot') }}
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="{{ __('Choose the AI chatbot that best suits your needs.') }}"></i>
                    </label>
                    <select name="AI_CHATBOT" class="form-select" placeholder="{{ __('Select Option') }}">
                        <option value="" selected>{{ __('Select Option') }}</option>
                        @foreach (config('ai-chatbots') as $chatbot)
                        <option value="{{ $chatbot }}" @selected(getSetting('AI_CHATBOT')==$chatbot)>
                            {{ __($chatbot) }}
                        </option>
                        @endforeach
                    </select>
                    @error('AI_CHATBOT')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">{{ __('AI Chatbot API Key') }}
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="{{ __('You can find the steps to generate an API key in the documentation.') }}"></i>
                    </label>
                    <div class="input-group input-group-flat">
                        <input type="password" name="AI_CHATBOT_API_KEY" maxlength="200"
                            class="form-control @error('AI_CHATBOT_API_KEY') is-invalid @enderror"
                            value="{{ isDemoMode() ? __('This field is hidden in the demo mode') : old('AI_CHATBOT_API_KEY') ?? getSetting('AI_CHATBOT_API_KEY') }}"
                            placeholder="{{ __('AI Chatbot API Key') }}">
                        @error('AI_CHATBOT_API_KEY')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <span class="input-group-text">
                            <a class="link-secondary jm-toggle-password" data-bs-toggle="tooltip">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path
                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg>
                            </a>
                        </span>
                    </div>
                </div>

            </div>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('AI Chatbot Model') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Refer to the documentation to select the model that best suits your needs.') }}"></i>
                        </label>
                        <input type="text" name="AI_CHATBOT_MODEL" maxlength="100"
                            class="form-control @error('AI_CHATBOT_MODEL') is-invalid @enderror"
                            value="{{ old('AI_CHATBOT_MODEL') ?? getSetting('AI_CHATBOT_MODEL') }}"
                            placeholder="{{ __('AI Chatbot Model') }}">
                        @error('AI_CHATBOT_MODEL')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('AI Chatbot Seconds') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('The number of seconds a user must wait before sending another message.') }}"></i>
                        </label>
                        <input type="number" name="AI_CHATBOT_SECONDS" maxlength="3"
                            class="form-control @error('AI_CHATBOT_SECONDS') is-invalid @enderror"
                            value="{{ old('AI_CHATBOT_SECONDS') ?? getSetting('AI_CHATBOT_SECONDS') }}"
                            placeholder="{{ __('AI Chatbot Seconds') }}">
                        @error('AI_CHATBOT_SECONDS')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('AI Chatbot Message Limit') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('The maximum number of messages a user can send during a meeting.') }}"></i>
                        </label>
                        <input type="number" name="AI_CHATBOT_MESSAGE_LIMIT" maxlength="3"
                            class="form-control @error('AI_CHATBOT_MESSAGE_LIMIT') is-invalid @enderror"
                            value="{{ old('AI_CHATBOT_MESSAGE_LIMIT') ?? getSetting('AI_CHATBOT_MESSAGE_LIMIT') }}"
                            placeholder="{{ __('AI Chatbot Message Limit') }}">
                        @error('AI_CHATBOT_MESSAGE_LIMIT')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('AI Chatbot Maximum Conversation Length') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('The maximum number of recent messages sent to AI Chatbot') }}"></i>
                        </label>
                        <input type="number" name="AI_CHATBOT_MAX_CONVERSATION_LENGTH" maxlength="3"
                            class="form-control @error('AI_CHATBOT_MAX_CONVERSATION_LENGTH') is-invalid @enderror"
                            value="{{ old('AI_CHATBOT_MAX_CONVERSATION_LENGTH') ?? getSetting('AI_CHATBOT_MAX_CONVERSATION_LENGTH') }}"
                            placeholder="{{ __('AI Chatbot Maximum Conversation Length') }}">
                        @error('AI_CHATBOT_MAX_CONVERSATION_LENGTH')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="btn-list justify-content-end">
                <button type="submit" name="submit" class="btn btn-primary mt-3">{{ __('Save') }}</button>
            </div>
        </div>
</form>
@endsection