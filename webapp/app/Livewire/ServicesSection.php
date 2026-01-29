<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;

final class ServicesSection extends Component
{
    public $services;

    public function mount(): void
    {
        $this->services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function render()
    {
        return view('livewire.services-section');
    }
}
