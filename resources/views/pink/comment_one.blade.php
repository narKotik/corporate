<li id="li-comment-{{ $data['id'] }}" class="comment even">
    <div id="comment-{{ $data['id'] }}" class="comment-container">
        <div class="comment-author vcard">
            <img class="avatar" src="{{ $data['hash'] }}">
            <cite class="fn">{{ $data['name'] }}</cite>
        </div>
        <!-- .comment-author .vcard -->
        <div class="comment-meta commentmetadata">
            <div class="intro">
                <div class="commentDate">
                    <a href="#comment-2">
                        {{ $data['created_at']->format('F d, Y в H:i:s') }}</a>
                </div>
                <div class="commentNumber">#&nbsp;</div>
            </div>
            <div class="comment-body">
                <p>{{ $data['text'] }}</p>
            </div>
        </div>
        <!-- .comment-meta .commentmetadata -->
    </div>
</li>