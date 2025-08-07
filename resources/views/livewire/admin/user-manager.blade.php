@section('title', 'Manage Users')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $metaTitle }}</h1>
            <p class="text-muted small">Manage users</p>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card common-card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-sm-6 col-md-4 col-lg-6">
                    <label for="search" class="form-label">Search</label>
                    <input wire:model.live.debounce.300ms="search" type="search" id="search"
                        class="common-input border" placeholder="Search by name, email or phone">
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="statusFilter" class="form-label">Status</label>
                    <div class="select-has-icon">
                        <select wire:model.live="statusFilter" id="statusFilter" class="common-input border">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="perPage" class="form-label">Show</label>
                    <div class="select-has-icon">
                        <select wire:model.live="perPage" id="perPage" class="common-input border">
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4 d-flex justify-content-between items-center">
                    <p class="text-sm ">
                        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }}
                        of {{ $users->total() }} results
                    </p>
                    <div class="my-auto justify-end">
                        <button wire:click="resetFilters" class="btn btn-sm btn-outline-secondary">
                            Reset Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- users table --}}
    <div class="card common-card">
        <div class="card-body table-responsive">
            <table class="table style-two">
                <thead>
                    <tr>
                        <th wire:click="sortBy('name')" class="pointer">
                            Name
                            @if ($sortField === 'name')
                                <span class="text-primary-500 dark:text-primary-400">
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                </span>
                            @endif
                        </th>
                        <th>Contact Info</th>
                        <th wire:click="sortBy('email_verify')" class="pointer">
                            Email Status
                            @if ($sortField === 'email_verify')
                                <span class="text-primary-500 dark:text-primary-400">
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                </span>
                            @endif
                        </th>
                        <th wire:click="sortBy('status')" class="pointer">
                            Status
                            @if ($sortField === 'status')
                                <span class="text-primary-500 dark:text-primary-400">
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                </span>
                            @endif
                        </th>
                        <th wire:click="sortBy('created_at')" class="pointer">
                            Joined
                            @if ($sortField === 'created_at')
                                <span class="text-primary-500 dark:text-primary-400">
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                </span>
                            @endif
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>
                                <p class="mb-0">
                                    {{ $user->email }}
                                </p>
                                <p class="mb-0">
                                    {{ $user->phone }}
                                </p>
                            </td>
                            <td>
                                @if ($user->email_verify)
                                    <i class="fal fa-check-circle text-success"></i>
                                @else
                                    <i class="fal fa-times-circle text-danger "></i>
                                @endif
                            </td>
                            <td>
                                @if ($user->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td> {{ $user->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', $user->id) }}" wire:navigate
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('styles')
    <style>
        .pointer {
            cursor: pointer;
        }
    </style>
@endpush


@include('layouts.meta')
