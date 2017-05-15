@if($portfolios && count($portfolios))
    <div id="content-home" class="content group">
        <div class="hentry group">
            <div class="section portfolio">

                <h3 class="title">{{ Lang::get('ru.latest_projects') }}</h3>

                @foreach($portfolios as $k => $portfolio)
                    @if($k == 0)
                        <div class="hentry work group portfolio-sticky portfolio-full-description">
                            <div class="work-thumbnail">
                                <a class="thumb"><img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->images->max }}"></a>
                                <div class="work-overlay">
                                    <h3><a href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}">{{ $portfolio->title }}</a></h3>
                                    <p class="work-overlay-categories"><img src="{{ asset(config('settings.theme')) }}/images/categories.png" alt="Categories" /> in: <a href="#">{{ $portfolio->filter->title }}</a></p>
                                </div>
                            </div>
                            <div class="work-description">
                                <h2><a href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}">{{ $portfolio->title }}</a></h2>
                                <p class="work-categories">in: <a href="#">{{ $portfolio->filter->title }}</a></p>
                                <p>
                                    {{ str_limit($portfolio->text, 200) }} <a href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}" class="read-more">|| Read more</a>
                                </p>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="portfolio-projects">
                    @else
                            <div class="related_project {{ (count($portfolios)-1 == $k ) ? ' related_project_last ' : '' }}">
                                <div class="overlay_a related_img">
                                    <div class="overlay_wrapper">
                                        <img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->images->mini }}" />
                                        <div class="overlay">
                                            <a class="overlay_img" href="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->images->path }}" rel="lightbox" title=""></a>
                                            <a class="overlay_project" href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}"></a>
                                            <span class="overlay_title">{{ $portfolio->title }}</span>
                                        </div>
                                    </div>
                                </div>
                                <h4><a href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}">{{ $portfolio->title }}</a></h4>
                                <p>{{ str_limit($portfolio->text, 100) }}</p>
                            </div>
                    @endif
                @endforeach
                        </div>
            </div>
            <div class="clear"></div>
        </div>
        <!-- START COMMENTS -->
        <div id="comments">
        </div>
        <!-- END COMMENTS -->
    </div>
@endif