@foreach($items as $k => $item)
    <li id="li-comment-{{ $item->id }}" class="comment even {{ ($article->user_id == $item->user_id) ? ' bypostauthor odd ' : '' }}">
        <div id="comment-{{ $item->id }}" class="comment-container">
            <div class="comment-author vcard">
                <img class="avatar" src="{{  ($item->email) ?
                         Gravatar::get($item->email, ['size' => 75]) :
                         Gravatar::get($item->user->email, ['size' => 75]) }}">
                <cite class="fn">{{ $item->user->name or $item->name }}</cite>
            </div>
            <!-- .comment-author .vcard -->
            <div class="comment-meta commentmetadata">
                <div class="intro">
                    <div class="commentDate">
                        <a href="#comment-2">
                            {{ $item->created_at->format('F d, Y в H:i:s') }}</a>
                    </div>
                    <div class="commentNumber">#&nbsp;</div>
                </div>
                <div class="comment-body">
                    <p>{{ $item->text }}</p>
                </div>
                <div class="reply group">
                    <a class="comment-reply-link" href="#respond" onclick="return addComment.moveForm(&quot;comment-{{$item->id}}&quot;, &quot;{{$item->id}}&quot;, &quot;respond&quot;, &quot;{{$item->article_id}}&quot;)">{{ Lang::get('ru.reply') }}</a>
                </div>
                <!-- .reply -->
            </div>
            <!-- .comment-meta .commentmetadata -->
        </div>
        <!-- #comment-##  -->
        @if(isset($com[$item->id]))
            <ul class="children">
                @include(config('settings.theme') . '.comment', ['items' => $com[$item->id]])
            </ul>
        @endif
    </li>
@endforeach