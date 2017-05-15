@foreach($items as $item)
    <li>
        <a class="{{ (URL::current() == $item->url())? 'active' : '' }}" href="{{ $item->url() }}">{{ $item->title }}</a>
        @if($item->hasChildren())
            <ul class="sub-menu">
                @include( config('settings.theme') . '.customMenuItems', ['items' => $item->children()])
            </ul>
        @endif
    </li>
@endforeach