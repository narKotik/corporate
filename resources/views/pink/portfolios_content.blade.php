<div id="content-page" class="content group">
    <div class="hentry group">
@if($portfolios)
        <div id="portfolio" class="portfolio-big-image">

    @foreach($portfolios as $portfolio)

            <div class="hentry work group">
                <div class="work-thumbnail">
                    <div class="nozoom">
                        <img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->images->max }}">
                        <div class="overlay">
                            <a class="overlay_img" href="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->images->path }}" rel="lightbox" title="{{ $portfolio->title }}"></a>
                            <a class="overlay_project" href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}"></a>
                            <span class="overlay_title">{{ $portfolio->title }}</span>
                        </div>
                    </div>
                </div>
                <div class="work-description">
                    <h3>{{ $portfolio->title }}</h3>
                    <p>{{ str_limit($portfolio->text, 250) }}</p>
                    <div class="clear"></div>
                    <div class="work-skillsdate">
                        <p class="skills"><span class="label">{{ Lang::get('ru.filter') }}:</span> {{ $portfolio->filter->title }}</p>
                        <p class="customer"><span class="label">{{ Lang::get('ru.customer') }}:</span> {{ $portfolio->customer }}</p>
                        <p class="workdate"><span class="label">{{ Lang::get('ru.date') }}:</span> {{ $portfolio->created_at->format('Y-M-d') }}</p>
                    </div>
                    <a class="read-more" href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}">{{ Lang::get('ru.view_project') }}</a>
                </div>
                <div class="clear"></div>
            </div>

    @endforeach
        </div>
            <div class="general-pagination group">
                @if ($portfolios->lastPage() > 1)
                    <ul class="pagination">

                        @if ($portfolios->currentPage() !== 1)
                            <a  href="{{ $portfolios->url(($portfolios->currentPage()-1)) }}">{{ Lang::get('pagination.previous')}}</a>
                        @endif
                        @for ($i = 1; $i <= $portfolios->lastPage(); $i++)

                            @if ($portfolios->currentPage() == $i)
                                <a class="selected disabled">{{ $i }}</a>
                            @else
                                <a href="{{ $portfolios->url($i) }}">{{ $i }}</a>
                            @endif


                        @endfor

                        @if ($portfolios->currentPage() !== $portfolios->lastPage())

                            <a href="{{ $portfolios->url($portfolios->currentPage()+1) }}" >{{ Lang::get('pagination.next')}}</a>
                        @endif
                    </ul>
                @endif
            </div>
@endif
        <div class="clear"></div>
    </div>
</div>