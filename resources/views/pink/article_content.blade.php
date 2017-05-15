<div id="content-single" class="content group">
    <div class="hentry hentry-post blog-big group ">
        <!-- post featured & title -->
        @if($article)

            <div class="thumbnail">
                <!-- post title -->
                <h1 class="post-title">{{ $article->title }}</h1>
                <!-- post featured -->
                <div class="image-wrap">
                    <img src="{{ asset(config('settings.theme')) }}/images/articles/{{ $article->images->max }}">
                </div>
                <p class="date">
                    <span class="month">{{ $article->created_at->format('M') }}</span>
                    <span class="day">{{ $article->created_at->format('d') }}</span>
                </p>
            </div>
            <!-- post meta -->
            <div class="meta group">
                <p class="author"><span>by <a id="user" href="#" data-user-id="{{ $article->user->id }}" title="Posts by {{ $article->user->name }}" rel="author">{{ $article->user->name }}</a></span></p>
                <p class="categories"><span>In: <a href="{{ route('articlesCat', ['cat_alias' => $article->category->alias]) }}" title="View all posts in {{ $article->category->title }}" rel="category tag">{{ $article->category->title }}</a></span></p>
                <p class="comments"><span><a href="#comments" title="">{{ count($article->comments) ?: 0 }} {{ Lang::choice('ru.comments', count($article->comments)) }}</a></span></p>
            </div>
            <!-- post content -->
            <div class="the-content single group">
                {!! $article->full_text !!}
                <div class="socials">
                    <h2>love it, share it!</h2>
                    <a href="https://www.facebook.com/sharer.html?u=http%3A%2F%2Fyourinspirationtheme.com%2Fdemo%2Fpinkrio%2F2012%2F09%2F24%2Fthis-is-the-title-of-the-first-article-enjoy-it%2F&amp;t=This+is+the+title+of+the+first+article.+Enjoy+it." class="socials-small facebook-small" title="Facebook">facebook</a>
                    <a href="https://twitter.com/share?url=http%3A%2F%2Fyourinspirationtheme.com%2Fdemo%2Fpinkrio%2F2012%2F09%2F24%2Fthis-is-the-title-of-the-first-article-enjoy-it%2F&amp;text=This+is+the+title+of+the+first+article.+Enjoy+it." class="socials-small twitter-small" title="Twitter">twitter</a>
                    <a href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=http%3A%2F%2Fyourinspirationtheme.com%2Fdemo%2Fpinkrio%2F2012%2F09%2F24%2Fthis-is-the-title-of-the-first-article-enjoy-it%2F&amp;title=This+is+the+title+of+the+first+article.+Enjoy+it." class="socials-small google-small" title="Google">google</a>
                    <a href="http://pinterest.com/pin/create/button/?url=http%3A%2F%2Fyourinspirationtheme.com%2Fdemo%2Fpinkrio%2F2012%2F09%2F24%2Fthis-is-the-title-of-the-first-article-enjoy-it%2F&amp;media=http://yourinspirationtheme.com/demo/pinkrio/files/2012/09/00212.jpg&amp;description=Fusce+nec+accumsan+eros.+Aenean+ac+orci+a+magna+vestibulum+posuere+quis+nec+nisi.+Maecenas+rutrum+vehicula+condimentum.+Donec+volutpat+nisl+ac+mauris+consectetur+gravida.+Lorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Donec+vel+vulputate+nibh.+Pellentesque%5B...%5D" class="socials-small pinterest-small" title="Pinterest">pinterest</a>
                    <a href="http://yourinspirationtheme.com/demo/pinkrio/2012/09/24/this-is-the-title-of-the-first-article-enjoy-it/" class="socials-small bookmark-small" title="This is the title of the first article. Enjoy it.">bookmark</a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <!-- START COMMENTS -->
        <div id="comments">
        <h3 id="comments-title">
            <span>{{ count($article->comments) }}</span> {{ Lang::choice('ru.comments', count($article->comments)) }}
        </h3>

            @if(count($article->comments) > 0)
                <ol class="commentlist group">

                    @foreach($com as $k => $coms)
                        @if ($k != 0)
                            @break
                        @endif
                        @include(config('settings.theme') . '.comment', ['items'=> $coms])
                    @endforeach


                </ol>
            @endif
        <!-- #respond -->
        <div id="respond">
            <h3 id="reply-title">{{ Lang::get('ru.leave_comment') }} <a rel="nofollow" class="fa fa-times" id="cancel-comment-reply-link" title="{{ Lang::get('ru.cancel_reply') }}" href="#respond" style="display:none;"></a></h3>
            <form action="{{ route('comment.store') }}" method="post" id="commentform">
                {{ csrf_field() }}
                <input id="comment_post_ID" type="hidden" name="comment_post_ID" value="{{ $article->id }}" />
                <input id="comment_parent" type="hidden" name="comment_parent" value="0" />

                @if( !Auth::check() )
                    <p class="comment-form-author"><label for="name">{{ Lang::get('ru.name') }}</label> <input id="name" name="name" type="text" required="true" value="" size="30" aria-required="true" /></p>
                    <p class="comment-form-email"><label for="email">{{ Lang::get('ru.email') }}</label> <input id="email" name="email" type="email" required="true" value="" size="30" aria-required="true" /></p>
                @endif
                <p class="comment-form-comment"><label for="text">{{ Lang::get('ru.enter_comment') }}</label><textarea required="true" id="text" name="text" cols="45" rows="8"></textarea></p>
                <div class="clear"></div>
                <p class="form-submit">
                    <input name="submit" type="submit" id="submit" value="{{ Lang::get('ru.post_comment') }}">
                </p>
            </form>
        </div>
        <!-- #respond -->
    </div>

    @endif
    <!-- END COMMENTS -->
</div>