@section('title', $metaTitle)
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Contact messages</h1>
            <p class="text-muted small">Manage contact messages</p>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card common-card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-sm-6 col-md-4 col-lg-6">
                    <label for="search" class="form-label">Search</label>
                    <input wire:model.live.debounce.300ms="searchTerm" type="search" id="search"
                        class="common-input border" placeholder="Search by name, email or message content">
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
            </div>
        </div>
    </div>

    <!-- Contact Messages Table -->
    <div class="card common-card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover style-two">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contactmessages as $contactmessage)
                            <tr>
                                <td>{{ $contactmessage->name }}</td>
                                <td>{{ $contactmessage->email }}</td>
                                <td>{{ text_trimer($contactmessage->message, 50) }}</td>
                                <td>{{ $contactmessage->created_at }}</td>
                                <td>
                                    <button wire:click="view('{{ $contactmessage->id }}')"
                                        class="btn btn-primary btn-sm">View</button>
                                    <button wire:click="delete('{{ $contactmessage->id }}')"
                                        class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- View Contact Message -->
    @if ($viewingContactMessage)
        <div class="common-modal modal fade show" tabindex="-1" id="deleteModal" aria-hidden="true"
            style="display:block;background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View Contact Message</h5>
                        <button type="button" class="btn-close" wire:click="closeView"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="card-text">
                                    <strong>Name:</strong> <span
                                        class="text-muted">{{ $viewingContactMessage->name }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card-text">
                                    <strong>Email:</strong> <span
                                        class="text-muted">{{ $viewingContactMessage->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-sm-12">
                                <div class="card-text">
                                    <strong>Message:</strong>
                                    <p class="mt-2">{{ $viewingContactMessage->message }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-sm-12">
                                <div class="card-text">
                                    <strong>Created At:</strong> <span
                                        class="text-muted">{{ $viewingContactMessage->created_at }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@include('layouts.meta')
