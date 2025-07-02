<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Component;

final class ContactSection extends Component
{
    public string $name = '';
    public string $email = '';
    public string $message = '';
    public string $phone = '';
    public string $subject = '';

    public array $contactInfo = [
        [
            'icon' => 'fa-location-arrow',
            'title' => 'Address',
            'content' => 'Your Address Here',
        ],
        [
            'icon' => 'fa-envelope',
            'title' => 'Email',
            'content' => 'your.email@example.com',
        ],
        [
            'icon' => 'fa-phone',
            'title' => 'Phone',
            'content' => '+1 234 567 8900',
        ],
    ];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
            'phone' => 'nullable|string|max:20',
        ];
    }

    public function submit(): void
    {
        $this->validate();

        try {
            Contact::create([
                'name' => $this->name,
                'email' => $this->email,
                'subject' => $this->subject,
                'message' => $this->message,
                'phone' => $this->phone,
            ]);

            // Reset form
            $this->reset(['name', 'email', 'subject', 'message', 'phone']);

            session()->flash('success', 'Thank you for your message! I will get back to you soon.');
        } catch (\Exception $e) {
            session()->flash('error', 'Sorry, there was an error sending your message. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.contact-section');
    }
}
