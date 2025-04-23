@props(['comment', 'canReply' => true])

<li class="comment-list__item d-flex align-items-start gap-sm-4 gap-3">
    <div class="comment-list__content w-100">
        <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
                <h6 class="comment-list__name font-18 mb-sm-2 mb-1">{{ $comment->user->name ?? 'User' }}</h6>
                <span class="comment-list__date font-14">{{ show_datetime($comment->created_at, 'M d, Y \a\t h:i a') }}</span>
            </div>
            @if ($canReply)
                <a class="comment-list__reply fw-500 flx-align gap-2 hover-text-decoration-underline"
                    wire:click="replyTo('{{ $comment->id }}')" href="#comment-box">
                    Reply
                    <span class="icon"><img src="{{ static_asset('images/icons/reply-icon.svg') }}" alt=""></span>
                </a>
            @endif
        </div>

        <p class="comment-list__desc mt-3">{!! nl2br($comment->content) !!}</p>
    </div>
</li>
