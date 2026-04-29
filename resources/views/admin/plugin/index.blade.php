@extends('layouts.admin')
@section('title', $pageTitle)

@section('content')
    @include('include.admin.toast')

    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        @include('include.admin.breadcrumbs')
                    </div>
                    <div class="col-auto ms-auto me-3">
                        <div class="btn-list">
                            {{-- <span class="d-sm-inline">
                                <a href="{{ route('export-user', request()->all()) }}" class="btn hideLoader">
                                    {{ __('Export') }}
                                </a>
                            </span> --}}
                            <span class="d-sm-inline">
                                <a href="{{ route('admin.plugin.create') }}" class="btn btn-primary btn-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-0" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    <span class="d-none d-sm-inline-block">{{ __('Register') }}</span>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('SR No') }}</th>
                                    <th>{{ __('Product Name') }}</th>
                                    <th>{{ __('Domain') }}</th>
                                    <th>{{ __('Token') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($plugins as $plugin)
                                    <tr>
                                        <td>{{ $plugins->firstItem() + $loop->index }}</td>
                                        <td class="text-truncate">
                                            <span title="{{ $plugin->product_name }}" data-bs-toggle="tooltip"
                                                data-bs-placement="right">
                                                {{ $plugin->product_name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-truncate">
                                            <span title="{{ $plugin->domain }}" data-bs-toggle="tooltip"
                                                data-bs-placement="right">
                                                {{ $plugin->domain ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-truncate">
                                            <div class="d-flex align-items-center gap-2">
                                                <span title="{{ $plugin->token }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="right" class="text-truncate">
                                                    {{ $plugin->token ?? '-' }}
                                                </span>

                                                @if ($plugin->token)
                                                    <button type="button" class="btn btn-sm btn-light copy-token"
                                                        data-token="{{ $plugin->token }}" title="Copy token">
                                                        <i class="bi bi-copy"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td scope="col">
                                            <div class="form-switch">
                                                <input class="form-check-input toggle-plugin-status" type="checkbox"
                                                    data-id="{{ $plugin->id }}"
                                                    value="{{ $plugin->status === 'active' ? 'active' : 'inactive' }}"
                                                    {{ $plugin->status === 'active' ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <span title="{{ $plugin->created_at_custom }}" data-bs-toggle="tooltip"
                                                data-bs-placement="right">
                                                {{ $plugin->created_at->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href = "{{ route('admin.plugin.edit', $plugin->id) }}" class="btn">
                                                {{ __('Edit') }}
                                            </a>
                                            <a href = "{{ route('admin.plugin.destroy', $plugin->id) }}" class="btn"
                                                onclick="return confirm('Are you sure you want to delete this Plugin?')">
                                                {{ __('Delete') }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>{{ __('No Records Found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($plugins->hasPages())
                        <div class="mt-2 ms-2 mb-2">
                            {{ $plugins->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
