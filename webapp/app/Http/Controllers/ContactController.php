<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index(): View
    {
        $profile = Profile::with('user')->first();

        return view('pages.contact', compact('profile'));
    }

    /**
     * Handle contact form submission.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // TODO: Save contact message to database
        // TODO: Send notification email

        return redirect()
            ->route('contact')
            ->with('success', 'Thank you for your message! I will get back to you soon.');
    }
}
