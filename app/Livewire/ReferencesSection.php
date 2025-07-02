<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Reference;
use Livewire\Component;

final class ReferencesSection extends Component
{
    public $references;

    public function mount(): void
    {
        $this->references = Reference::where('is_active', true)
            ->orderBy('sort_order', 'desc')
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.references-section');
    }
}
