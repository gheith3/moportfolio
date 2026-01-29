<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Profile;
use Livewire\Component;

final class HeroSection extends Component
{
    public Profile $profile;

    public function mount(): void
    {
        $this->profile = Profile::with('user')->first() ?? new Profile();
    }

    public function render()
    {
        return view('livewire.hero-section');
    }
}
