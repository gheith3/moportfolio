<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;

final class ClientsSection extends Component
{
    public $clients;

    public function mount(): void
    {
        $this->clients = Client::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function render()
    {
        return view('livewire.clients-section');
    }
}
