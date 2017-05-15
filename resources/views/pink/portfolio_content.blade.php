<div id="content-page" class="content group">
    <div class="clear"></div>
    <div class="posts">
        <div class="group portfolio-post internal-post">
            <div id="portfolio" class="portfolio-full-description">
                @if($portfolio)
                    <div class="fulldescription_title gallery-filters">
                        <h1>{{ $portfolio->title }}</h1>
                    </div>

                    <div class="portfolios hentry work group">
                        <div class="work-thumbnail">
                            <a class="thumb"><img
                                        src="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->images->max }}"></a>
                        </div>
                        <div class="work-description">
                            <p>{{ $portfolio->text }}</p>
                            <div class="clear"></div>
                            <div class="work-skillsdate">
                                <p class="skills"><span class="label">{{ Lang::get('ru.filter') }}
                                        :</span> {{ $portfolio->filter->title }}</p>
                                <p class="customer"><span class="label">{{ Lang::get('ru.customer') }}
                                        :</span> {{ $portfolio->customer }}</p>
                                <p class="workdate"><span class="label">{{ Lang::get('ru.date') }}
                                        :</span> {{ $portfolio->created_at->format('Y-M-d') }}</p>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    @if($portfolios)
                        <h3>{{ Lang::get('ru.other_portfolios') }}</h3>

                        <div class="portfolio-full-description-related-projects">
                        @foreach($portfolios as $portfolio_mini)
                                <div class="related_project">
                                    <a class="related_proj related_img"
                                       href="{{ route('portfolios.show', ['alias'=> $portfolio_mini->alias]) }}"
                                       title="{{ $portfolio_mini->title }}"><img
                                                src="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio_mini->images->mini }}"></a>
                                    <h4>
                                        <a href="{{ route('portfolios.show', ['alias'=> $portfolio_mini->alias]) }}">{{ $portfolio_mini->title }}</a>
                                    </h4>
                                </div>
                        @endforeach
            </div>
            @endif
        </div>
        @endif
        <div class="clear"></div>
    </div>
</div>
</div>