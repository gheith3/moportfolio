<section id="portfolio" class="portfolio section-padding pb-70" data-scroll-index="3">
    <div class="container">
        <div class="row">
            <!-- section heading -->
            <div class="section-head">
                <h3>Portfolio.</h3>
            </div>

            <!-- filter links -->
            <div class="filtering text-center mb-50">
                <span wire:click="setFilter('all')" class="{{ $selectedFilter === 'all' ? 'active' : '' }}"
                    style="cursor: pointer;">
                    All
                </span>
                @foreach($categories as $category)
                <span wire:click="setFilter('{{ $category->slug }}')"
                    class="{{ $selectedFilter === $category->slug ? 'active' : '' }}" style="cursor: pointer;">
                    {{ $category->name }}
                </span>
                @endforeach
            </div>

            <!-- gallery -->
            <div class="gallery text-center" wire:loading.class="opacity-50">
                @foreach($this->getFilteredItems() as $project)
                <div class="col-md-4 col-sm-6 items {{ $project->categories->pluck('slug')->implode(' ') }}">
                    <div class="item-img">
                        <img src="{{ \Storage::url($project->image) }}" alt="{{ $project->title }}">
                        <div class="item-img-overlay">
                            <div class="overlay-info v-middle text-center">
                                <h6 class="sm-titl">{{ $project->title }}</h6>
                                <div class="icons">
                                    @if($project->project_url)
                                    <span class="icon">
                                        <a href="{{ $project->project_url }}" target="_blank">
                                            <i class="fa fa-chain-broken" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                    @endif
                                    <span class="icon link">
                                        <a href="{{ \Storage::url($project->image) }}">
                                            <i class="fa fa-search-plus" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div><!-- /row -->
    </div><!-- /container -->
</section>