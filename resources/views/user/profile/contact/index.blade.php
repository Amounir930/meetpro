@extends('user.profile.index')

@section('profile-content')
    <div class="col-12 col-md-9 d-flex flex-column card-body">
        <h2 class="mb-4">{{ __('Contacts') }}</h2>
        @include('include.user.message')
        <div class="row mb-3 ">
            <div class="col-sm-12">
                <a href="{{ route('user.profile.contact.create') }}"><button class="btn btn-primary"
                        title="{{ __('Create Contact') }}">{{ __('Create') }}</button></a>
                <a href="{{ route('user.profile.contact.import.form') }}" style="margin-left:5px;"><button
                        class="btn btn-success" title="{{ __('Create Contact') }}">{{ __('Import') }}</button></a>
            </div>
        </div>
        @if (count($contacts))
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>{{ __('SR No') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Created') }}</th>
                        <th>{{ __('Updated') }}</th>
                        <th>{{ __('Edit') }}</th>
                        <th>{{ __('Delete') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contacts->firstItem() + $loop->index }}
                            </td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->created_at->diffForHumans() }}
                            </td>
                            <td>{{ $contact->updated_at->diffForHumans() }}
                            </td>
                            <td>
                                <a href="{{ route('user.profile.contact.edit', $contact->id) }}">
                                    <button class="btn btn-primary edit-contact" title="{{ __('Edit') }}">
                                        {{ __('Edit') }}
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href = "{{ route('user.profile.contact.destroy', $contact->id) }}"
                                    class="btn btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this contact?')">
                                    {{ __('Delete') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($contacts->hasPages())
                <div class="card-footer">
                    <div class="mt-2 ms-2 mb-2">
                        {{ $contacts->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        @else
            <p>{{ __('Your contacts will appear here') }}</p>
        @endif
    </div>
@endsection
