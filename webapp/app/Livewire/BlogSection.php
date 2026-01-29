<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\BlogPost;
use Livewire\Component;

final class BlogSection extends Component
{
    public function render()
    {
        $blogPosts = BlogPost::with('category')
            ->latest()
            ->limit(4)
            ->get();

        return view('livewire.blog-section', [
            'blogPosts' => $blogPosts
        ]);
    }
}
