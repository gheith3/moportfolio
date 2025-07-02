<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

final class BlogController extends Controller
{
    /**
     * Display the blog listing page.
     */
    public function index(): View
    {
        // TODO: Load blog posts from database
        return view('pages.blog');
    }

    /**
     * Display a specific blog post.
     */
    public function show(string $slug): View
    {
        // TODO: Load specific blog post by slug
        return view('pages.blog-single', compact('slug'));
    }
}
