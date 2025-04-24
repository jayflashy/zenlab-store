@php
    $fullStars = floor($rating);
    $halfStar = $rating - $fullStars >= 0.5;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
@endphp

<span class="star-rating d-inline-flex align-items-center gap-1">
    @for ($i = 0; $i < $fullStars; $i++)
        <span class="star-rating__item font-11 text-warning"><i class="fas fa-star"></i></span>
    @endfor

    @if ($halfStar)
        <span class="star-rating__item font-11 text-warning"><i class="fas fa-star-half-alt"></i></span>
    @endif

    @for ($i = 0; $i < $emptyStars; $i++)
        <span class="star-rating__item font-11 text-muted"><i class="far fa-star"></i></span>
    @endfor

    <span class="star-rating__text text-body">{{ number_format($rating, 1) }}</span>
    @if ($count)
        <span class="star-rating__text text-body">({{ $count }})</span>
    @endif
</span>
