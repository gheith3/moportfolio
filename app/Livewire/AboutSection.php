<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Profile;
use Livewire\Component;

final class AboutSection extends Component
{
    public Profile $profile;

    public function mount(): void
    {
        $this->profile = Profile::with(['skills' => function ($query) {
            $query->where('is_active', true)->orderBy('sort_order');
        }])->first() ?? new Profile();
    }

    public function render()
    {
        return view('livewire.about-section');
    }
}
