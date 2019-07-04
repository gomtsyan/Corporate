

@if($items)

    @foreach($items as $item)
        <li class="sidebar-item {{ request()->segment(2) ==  $item->data('path_name') ? 'selected' : ''}}">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ $item->url() }}" aria-expanded="false">
                <i class="mdi mdi-{{ $item->data('icon') }}"></i>
                <span class="hide-menu">{{ $item->title }}</span>
            </a>
            @if($item->hasChildren())
                <ul aria-expanded="false" class="collapse  first-level">
                    @include(config('settings.theme').'.admin.customAdminMenuItems', ['items'=>$item->children()])
                </ul>
            @endif
        </li>
    @endforeach
@endif