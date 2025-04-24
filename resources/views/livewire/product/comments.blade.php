<div class="comment mb-64">
    <h5 class="mb-32">Product Comments</h5>

    <ul class="comment-list">
        @foreach ($comments as $comment)
            <x-comment-item :comment="$comment" :canReply="true" wire:key="{{ $comment->id }}" />
            {{-- Inline Reply Form --}}
            @if ($replyingTo == $comment->id)
                <li class="ms-5 mb-4">
                    <div class="comment-form mt-3">
                        <h6 class="mb-2">Reply to {{ $comment->user->name ?? 'User' }}</h6>
                        <form wire:submit.prevent="postComment">
                            <div class="form-group">
                                <textarea wire:model.defer="newComment" class="common-input common-input--grayBg border" placeholder="Type your reply"></textarea>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-2">
                                <button class="btn btn-outline-secondary" type="button" wire:click="cancelReply">
                                    Cancel
                                </button>
                                <button class="btn btn-main pill" type="submit">
                                    Reply
                                    <span class="icon icon-right line-height-1 font-20"><i class="las la-arrow-right"></i></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </li>
            @endif
            @foreach ($comment->replies as $reply)
                <li>
                    <ul class="comment-list comment-list--two mb-3">
                        <x-comment-item :comment="$reply" :canReply="false" wire:key="{{ $reply->id }}" />
                    </ul>
                </li>
            @endforeach
        @endforeach
    </ul>
    {{-- Pagination Controls --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $comments->links('partials.pagination') }}
    </div>

    @if (!$replyingTo)
        @guest
            <div class="comment-form mt-64 mb-64" id="comment-box">
                <h5 class="mb-32">Post a comment</h5>
                <div class="alert alert-danger">
                    <p class="mb-0">You must be logged in to post a comment.</p>
                </div>
            </div>
        @else
            <div class="comment-form mt-64 mb-64" id="comment-box">
                <h5 class="mb-32">Post a comment</h5>
                <form wire:submit.prevent="postComment" autocomplete="off">
                    <div class="form-group">
                        <textarea wire:model.defer="newComment" class="common-input common-input--grayBg border" placeholder="Type your comment"></textarea>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-main btn-lg pill" type="submit">
                            Submit
                            <span class="icon icon-right line-height-1 font-20"><i class="las la-arrow-right"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        @endguest
    @endif
</div>
