<div class="share-buttons">
    <a href="#" onclick="copyToClipboard('{{ $url }}')" class="share-btn copy" title="Copy link">
        <i class="fas fa-link"></i>
    </a>

    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}&t={{ urlencode($title) }}" class="share-btn facebook"
        target="_blank">
        <i class="fab fa-facebook-f"></i>
    </a>

    <a href="https://api.whatsapp.com/send?text={{ urlencode($title . ' - ' . $url) }}" class="share-btn whatsapp" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <a href="https://t.me/share/url?url={{ urlencode($url) }}&text={{ urlencode($title) }}" class="share-btn telegram" target="_blank">
        <i class="fab fa-telegram-plane"></i>
    </a>

    <a href="https://twitter.com/intent/tweet?text={{ urlencode($title) }}&url={{ urlencode($url) }}" class="share-btn x-twitter"
        target="_blank">
        <i class="fab fa-x-twitter"></i>
    </a>

    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($url) }}&title={{ urlencode($title) }}"
        class="share-btn linkedin" target="_blank">
        <i class="fab fa-linkedin-in"></i>
    </a>
</div>

<script>
    function copyToClipboard(text) {
        const dummy = document.createElement('input');
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        toastr.success('Link copied!');
    }
</script>
