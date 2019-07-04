@if($items)
    @foreach($items as $item)

        <tr>

            <td>{!! $paddingLeft !!}  {{ $item->title }}</td>
            <td>{{ $item->url() }}</td>
            <td>
                <a href="{{ route('menu.edit', ['menu'=>$item->id]) }}" class="btn btn-cyan btn-sm m-1 btn-block">Edit</a>

                <form action="{{ route('menu.destroy', ['menu'=>$item->id]) }}" method="post">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <input type="submit" name="delete" value="Delete" class="btn btn-danger btn-sm m-1 btn-block ">
                </form>
            </td>
        </tr>
        @if($item->hasChildren())
            @include(config('settings.theme').'.admin.custom-menu-items', ['items'=>$item->children(), 'paddingLeft'=>"<span class='text-danger'><i class='mdi mdi-window-minimize'></i></span>"])
        @endif
    @endforeach
@endif