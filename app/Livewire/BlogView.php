<?php

namespace App\Livewire;

use App\Models\Blog;
use App\Traits\LivewireToast;
use Livewire\Component;

class BlogView extends Component
{
    use LivewireToast;

    public Blog $blog;

    public array $tags = [];

    // meta
    public string $metaTitle;

    public string $metaDescription;

    public string $metaKeywords;

    public string $metaImage;

    public function mount(string $slug): void
    {
        $this->blog = Blog::whereSlug($slug)->where('is_active', 1)->firstOrFail();

        $this->tags = array_filter(
            array_map('trim', explode(',', $this->blog->tags)),
            fn ($tag) => ! empty($tag)
        );
        // set meta
        $this->metaTitle = $this->blog->title;
        $this->metaDescription = str()->limit(strip_tags($this->blog->about), 150);
        $this->metaKeywords = implode(',', $this->tags);
        $this->metaImage = $this->blog->image ? my_asset($this->blog->image) : my_asset(get_setting('logo'));
    }

    public function render()
    {
        return view('livewire.blog-view');
    }
}
