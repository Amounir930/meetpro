@extends('user.profile.index')

@section('profile-content')
    <form class="col-12 col-md-9 d-flex flex-column" action="{{ route('user.profile.basic.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <h2 class="mb-4">{{ __(key: 'Basic Information') }}</h2>
            @include('include.user.message')
            <div class="row showToastAbove">
                <div class="col-sm-12">
                    <input type="hidden" name="userid" id="userid" value="{{ getAuthUserInfo('id') }}" />
                    <div class="row align-items-center mb-3">
                        @if (getAuthUserInfo('avatar') && file_exists(public_path('storage/avatars/' . getAuthUserInfo('avatar'))))
                            @php
                                $avatar = getAuthUserInfo('avatar');
                            @endphp
                            <div class="col-auto">
                                <span class="avatar avatar-xl" id="avatar-preview"
                                    style="background-image: url('{{ asset('storage/avatars/' . $avatar) }}')"></span>
                            </div>
                        @else
                            <div class="col-auto">
                                <span class="avatar avatar-xl" id="avatar-preview"
                                    style="background-image: url('{{ asset('/images/blank.jpeg') }}')"></span>
                            </div>
                        @endif
                        <div class="col-auto">
                            <button id="change-avatar" type="button" class="btn">{{ __('Change avatar') }}</button>
                            <input type="file" id="avatarchange" name="avatar" accept="image/*" style="display: none;">
                        </div>
                        @if (getAuthUserInfo('avatar') && file_exists(public_path('storage/avatars/' . getAuthUserInfo('avatar'))))
                            <div class="col-auto">
                                <button id="removeAvatar" class="btn btn-ghost-danger">{{ __('Delete avatar') }}</button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class="form-label" for="i-name">{{ __('First Name') }}</label>
                            <input type="text" name="first_name"
                                class="form-control @error('first_name') is-invalid @enderror }}"
                                value="{{ old('first_name') ?? $user->first_name }}" minlength="3" maxlength="25" required
                                placeholder="{{ __('First Name') }}">
                            @error('first_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class="form-label">{{ __('Last Name') }}</label>
                            <input type="text" name="last_name"
                                class="form-control @error('last_name') is-invalid @enderror"
                                value="{{ old('last_name') ?? $user->last_name }}" required minlength="3" maxlength="25"
                                placeholder="{{ __('Last Name') }}">
                            @error('last_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class="form-label" for="i-name">{{ __('Username') }}</label>
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror }}"
                                value="{{ old('username') ?? $user->username }}" minlength="3" maxlength="20" required
                                placeholder="{{ __('Username') }}">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class="form-label" for="i-email">{{ __('Email') }}</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') ?? $user->email }}" required minlength="3" maxlength="50"
                                placeholder="{{ __('Email') }}" disabled>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent mt-auto">
            <div class="btn-list justify-content-end">
                <div class="row mt-3">
                    <div class="col">
                        <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
