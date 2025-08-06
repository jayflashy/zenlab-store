@section('title', 'Product Comments')

@include('layouts.meta')
<div class="common-card card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Manage Comments</h5>
        <div>
            <select wire:model.live="status" class="form-select common-input form-select-sm">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>

    <div class="card-body">
        <div class="mb-4">
            <input wire:model.live.300ms="search" type="text" class="form-control common-input"
                placeholder="Search comments, users, or products...">
        </div>

        <!-- Comments Table -->
        <div class="table-responsive">
            <table class="table style-two">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>User</th>
                        <th>Content</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                        <tr>
                            <td>
                                <a href="{{ route('products.view', $comment->product->slug) }}" target="_blank">
                                    {{ Str::limit($comment->product->name, 20) }}
                                </a>
                            </td>
                            <td>
                                @if ($comment->user)
                                    <a href="{{ route('admin.users.show', $comment->user_id) }}"
                                        class="">{{ $comment->user->name }}</a>
                                @else
                                    <div>{{ $comment->user->name ?? 'Guest User' }}</div>
                                @endif
                            </td>
                            <td>{{ text_trimer($comment->content, 50) }}</td>
                            <td>
                                @if ($comment->parent_id)
                                    <span class="badge bg-info">Reply</span>
                                @else
                                    <span class="badge bg-primary">Comment</span>
                                @endif
                            </td>
                            <td>
                                <span
                                    class="badge bg-{{ $comment->status === 'approved' ? 'success' : ($comment->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($comment->status) }}
                                </span>
                            </td>
                            <td>{{ $comment->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton{{ $comment->id }}"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $comment->id }}">
                                        <li>
                                            <button wire:click="showPreview('{{ $comment->id }}')" class="dropdown-item">
                                                <i class="las la-eye me-2"></i> View
                                            </button>
                                        </li>
                                        <li>
                                            <button wire:click="editComment('{{ $comment->id }}')" class="dropdown-item">
                                                <i class="las la-edit me-2"></i> Edit
                                            </button>
                                        </li>
                                        <li>
                                            <button wire:click="approveComment('{{ $comment->id }}')"
                                                class="dropdown-item {{ $comment->status === 'approved' ? 'disabled' : '' }}">
                                                <i class="las la-check me-2"></i> Approve
                                            </button>
                                        </li>
                                        <li>
                                            <button wire:click="rejectComment('{{ $comment->id }}')"
                                                class="dropdown-item {{ $comment->status === 'rejected' ? 'disabled' : '' }}">
                                                <i class="las la-ban me-2"></i> Reject
                                            </button>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <button wire:click="confirmDelete('{{ $comment->id }}')" class="dropdown-item text-danger">
                                                <i class="las la-trash me-2"></i> Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No comments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $comments->links() }}
        </div>
    </div>

    <!-- Edit Comment Modal -->
    @if ($isEditing)
        <div class="common-modal modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Comment</h5>
                        <button wire:click="cancelEdit" type="button" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="updateComment">
                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <textarea wire:model.defer="editContent" class="form-control" rows="5"></textarea>
                                @error('editContent')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" wire:click="cancelEdit">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Preview Comment Modal -->
    @if ($isPreviewingComment && $previewComment)
        <div class="common-modal modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Comment Preview</h5>
                        <button wire:click="closePreview" type="button" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">
                                            <strong>{{ $previewComment->user ? $previewComment->user->name : 'Guest User' }}</strong>
                                            @if ($previewComment->parent_id)
                                                <span class="badge bg-info ms-2">Reply to another comment</span>
                                            @endif
                                        </h6>
                                        <small class="text-muted">{{ $previewComment->created_at->format('M d, Y h:i A') }}</small>
                                    </div>
                                    <span
                                        class="badge bg-{{ $previewComment->status === 'approved' ? 'success' : ($previewComment->status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($previewComment->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{!! nl2br(e($previewComment->content)) !!}</p>

                                <hr>

                                <div class="mb-3">
                                    <strong>Product:</strong>
                                    <a href="{{ route('products.view', $previewComment->product->slug) }}" target="_blank">
                                        {{ $previewComment->product->name }}
                                    </a>
                                </div>

                                @if ($previewComment->parent_id && $previewComment->parent)
                                    <div class="mb-3">
                                        <strong>Replying to:</strong>
                                        <div class="card mt-2">
                                            <div class="card-body bg-light">
                                                <h6>{{ $previewComment->parent->user ? $previewComment->parent->user->name : 'Guest User' }}
                                                </h6>
                                                <p>{{ Str::limit($previewComment->parent->content, 100) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex">
                                    <button wire:click="approveComment('{{ $previewComment->id }}')" class="btn btn-success me-2"
                                        {{ $previewComment->status === 'approved' ? 'disabled' : '' }}>
                                        <i class="las la-check"></i> Approve
                                    </button>
                                    <button wire:click="rejectComment('{{ $previewComment->id }}')" class="btn btn-warning me-2"
                                        {{ $previewComment->status === 'rejected' ? 'disabled' : '' }}>
                                        <i class="las la-ban"></i> Reject
                                    </button>
                                    <button wire:click="editComment('{{ $previewComment->id }}')" class="btn btn-primary me-2">
                                        <i class="las la-edit"></i> Edit
                                    </button>
                                    <button wire:click="confirmDelete('{{ $previewComment->id }}')" class="btn btn-danger">
                                        <i class="las la-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closePreview">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- delete modal --}}
    @if ($showDeleteModal)
        <div class="common-modal modal fade show" tabindex="-1" id="deleteModal" aria-hidden="true"
            style="display:block;background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" wire:click="$set('showDeleteModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this comment?</p>
                        <p class="text-danger">This action cannot be undone and will permanently remove the comment from your store.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showDeleteModal', false)">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="deleteComment('{{$deleteId}}')">
                            <i class="fas fa-trash me-1"></i> Delete Comment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
