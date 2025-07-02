<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class BlogController extends Controller
{
    /**
     * Display the blog listing page.
     */
    public function index(Request $request): View
    {
        $query = BlogPost::with(['author', 'category'])
            ->where('is_published', true)
            ->orderBy('published_at', 'desc');

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(9);
        $categories = Category::where('type', 'blog')
            ->where('is_active', true)
            ->orderBy('sort_order', 'desc')
            ->orderBy('name')
            ->get();

        $featuredPosts = BlogPost::with(['author', 'category'])
            ->where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('pages.blog', compact('posts', 'categories', 'featuredPosts'));
    }

    /**
     * Display a specific blog post.
     */
    public function show(string $slug): View
    {
        $post = BlogPost::with(['author', 'category'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Get related posts
        $relatedPosts = BlogPost::with(['author', 'category'])
            ->where('is_published', true)
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('pages.blog-single', compact('post', 'relatedPosts'));
    }
}
