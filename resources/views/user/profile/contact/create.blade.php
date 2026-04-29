@extends('user.profile.index')

@section('profile-content')
    <form class="col-12 col-md-9 d-flex flex-column" action="{{ route('user.profile.contact.store') }}" method="post">
        @csrf
        <div class="card-body">
            <h2 class="mb-4">{{ __('Create Contact') }}</h2>
            @include('include.user.message')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Name') }}</label>
                        <input type="text" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid' @enderror" maxlength="20" autofocus required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Email') }}</label>
                        <input type="email" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid' @enderror" maxlength="50" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="btn-list justify-content-end d-flex">
                <a href="{{ route('user.profile.contacts') }}"><button type="button"
                        class="btn btn-default">{{ __('Back') }}</button></a>
                <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>

            </div>
        </div>
    </form>
@endsection
