<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Project;
use App\Models\Category;
use Livewire\Component;

final class PortfolioSection extends Component
{
    public string $selectedFilter = 'all';
    public $projects;
    public $categories;

    public function mount(): void
    {
        $this->projects = Project::with('categories')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $this->categories = Category::where('type', 'portfolio')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function setFilter(string $filter): void
    {
        $this->selectedFilter = $filter;
    }

    public function getFilteredItems()
    {
        if ($this->selectedFilter === 'all') {
            return $this->projects;
        }

        return $this->projects->filter(function ($project) {
            return $project->categories->contains('slug', $this->selectedFilter);
        });
    }

    public function render()
    {
        return view('livewire.portfolio-section');
    }
}
