@extends('user.profile.index')

@section('profile-content')
    <form class="col-12 col-md-9 d-flex flex-column" action="{{ route('user.profile.api-token.store') }}" method="post">
        @csrf
        <div class="card-body">
            <h2>{{ __('Create API Token') }}</h2>
            <small class="text-secondary mb-4">{{ __('You can create upto 5 API Tokens') }}</small>
            @include('include.user.message')
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row mt-4">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">{{ __('Name') }}</label>
                        <input type="text" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid' @enderror" maxlength="50" autofocus required>
                        @error('name')
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
                <a href="{{ route('user.profile.api-token') }}"><button type="button"
                        class="btn btn-default">{{ __('Back') }}</button></a>
                <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>

            </div>
        </div>
    </form>
@endsection
