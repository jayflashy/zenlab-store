<div class="comment mb-64">
    <h5 class="mb-32">Product Comments</h5>

    <ul class="comment-list">
        @foreach ($comments as $comment)
            <x-comment-item :comment="$comment" :canReply="true" wire:key="{{ $comment->id }}" />

            @foreach ($comment->replies as $reply)
                <li>
                    <ul class="comment-list comment-list--two mb-3">
                        <x-comment-item :comment="$reply" :canReply="false" wire:key="{{ $reply->id }}" />
                    </ul>
                </li>
            @endforeach
        @endforeach
    </ul>

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
</div>
