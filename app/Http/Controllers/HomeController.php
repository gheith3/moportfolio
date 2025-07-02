<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

final class HomeController extends Controller
{
    /**
     * Display the home page with portfolio sections.
     */
    public function index(): View
    {
        return view('pages.home');
    }
}
