@extends('admin.setting.index')

@section('setting-content')
    <form class="col-12 col-md-9 d-flex flex-column" action="{{ route('admin.setting.update-meeting') }}" method="post">
        @csrf
        <div class="card-body">
            <h2 class="mb-4">{{ __(key: 'Meeting') }}</h2>

            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Signaling URL') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('Signaling server (NodeJS) URL.') }}"></i>
                        </label>
                        <input type="text" name="SIGNALING_URL"
                            class="form-control @error('SIGNALING_URL') is-invalid @enderror"
                            value="{{ old('SIGNALING_URL') ?? getSetting('SIGNALING_URL') }}"
                            placeholder="{{ __('Signaling URL') }}" maxlength="50">
                        @error('SIGNALING_URL')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Default Username') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('This will be the default username when a guest user joins the meeting without entering his name.') }}"></i>
                        </label>
                        <input type="text" name="DEFAULT_USERNAME"
                            class="form-control @error('DEFAULT_USERNAME') is-invalid @enderror"
                            value="{{ old('DEFAULT_USERNAME') ?? getSetting('DEFAULT_USERNAME') }}"
                            placeholder="{{ __('Default Username') }}" maxlength="15">
                        @error('DEFAULT_USERNAME')
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
                        <label class="form-label">{{ __('Moderator Rights') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('If on, the moderator will be able to accept/reject requests to join the room and can kick the users out of the room.') }}"></i>
                        </label>
                        <select name="MODERATOR_RIGHTS"
                            class="form-control @error('MODERATOR_RIGHTS') is-invalid @enderror">
                            <option value="enabled" @selected(old('MODERATOR_RIGHTS') ? old('MODERATOR_RIGHTS') == 'enabled' : getSetting('MODERATOR_RIGHTS') == 'enabled')>
                                {{ __('On') }}
                            </option>
                            <option value="disabled" @selected(old('MODERATOR_RIGHTS') ? old('MODERATOR_RIGHTS') == 'disabled' : getSetting('MODERATOR_RIGHTS') == 'disabled')>
                                {{ __('Off') }}
                            </option>
                        </select>
                        @error('MODERATOR_RIGHTS')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('End URL') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('A web page to display when the meeting is over. Enter a URL. Leave \'null\' to reload the page. Set custom page like this: /pages/thank-you') }}"></i>
                        </label>
                        <input type="text" name="END_URL" class="form-control @error('END_URL') is-invalid @enderror"
                            value="{{ old('END_URL') ?? getSetting('END_URL') }}" placeholder="{{ __('End URL') }}"
                            maxlength="255">
                        @error('END_URL')
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
                        <label class="form-label">{{ __('Limited Screen Sharing') }}
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right"
                                title="{{ __('If on, the meeting will allow only one screen share at a time') }}"></i>
                        </label>
                        <select name="LIMITED_SCREEN_SHARE"
                            class="form-control @error('LIMITED_SCREEN_SHARE') is-invalid @enderror">
                            <option value="enabled" @selected(old('LIMITED_SCREEN_SHARE') ? old('LIMITED_SCREEN_SHARE') == 'enabled' : getSetting('LIMITED_SCREEN_SHARE') == 'enabled')>
                                {{ __('On') }}
                            </option>
                            <option value="disabled" @selected(old('LIMITED_SCREEN_SHARE') ? old('LIMITED_SCREEN_SHARE') == 'disabled' : getSetting('LIMITED_SCREEN_SHARE') == 'disabled')>
                                {{ __('Off') }}
                            </option>
                        </select>
                        @error('LIMITED_SCREEN_SHARE')
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
