
    <div class="widget-first widget recent-posts">

        @if($articles)
            <h3>{{ Lang::get('ru.from_blod') }}</h3>
                <div class="recent-post group">

                    @foreach($articles as $article)
                        <div class="hentry-post group">
                            <div class="thumb-img"><img src="{{ asset(config('settings.theme')) }}/images/articles/{{ $article->images->mini }}"></div>
                            <div class="text">
                                <a href="{{ route('articles.main.show', ['alias' => $article->alias]) }}" title="{{ $article->title }}" class="title">{{ $article->title }}</a>
                                <p class="post-date">{{ $article->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
        @endif

    </div>

    <div class="widget-last widget text-image">
        <h3>Customer support</h3>
        <div class="text-image" style="text-align:left"><img src="{{ asset(config('settings.theme')) }}/images/callus.gif" alt="Customer support" /></div>
        <p>Proin porttitor dolor eu nibh lacinia at ultrices lorem venenatis. Sed volutpat scelerisque vulputate. </p>
    </div>


