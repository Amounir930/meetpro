@extends('user.profile.index')

@section('profile-content')
    <form class="col-12 col-md-9 d-flex flex-column" id="importContact" action="{{ route('user.profile.contact.import') }}" method="post" enctype='multipart/form-data'>
        <div class="card-body">
            <h2 class="mb-4">{{ __('Import Contact') }}</h2>
            @csrf
            <div class="row mb-5">
                <div class="col-sm-6">
                    <div class="form-group">
                        <a href="{{ route('user.profile.contact.downloadCsvFile') }}">
                            <button type="button" class="btn btn-warning hideLoader">{{ __('Download Sample File') }}</button>
                        </a>
                        <hr>
                        <label class="form-label">{{ __('CSV File') }}</label>
                        <input type='file' name='file' accept=".csv" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="btn-list justify-content-end d-flex">
                <a href="{{ route('user.profile.contacts') }}"><button type="button"
                        class="btn btn-default">{{ __('Back') }}</button></a>
                <button type="submit" id="save" class="btn btn-primary">{{ __('Import') }}</button>
            </div>
        </div>
    </form>
@endsection
