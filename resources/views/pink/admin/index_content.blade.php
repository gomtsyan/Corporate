
@if(isset($menus) && $menus)
    <div class="row">
        @foreach($menus as $k=>$menu)
            <div class="col-md-6 col-lg-{{ ($k == 1 || $k == 8) ? '4' : '2' }} col-xlg-3">
                <div class="card card-hover">
                    <a href="{{ $menu->url() }}">
                        <div class="box bg-{{ $menu->data('color') }} text-center">
                            <h1 class="font-light text-white"><i class="mdi mdi-{{ $menu->data('icon') }}"></i></h1>
                            <h6 class="text-white">{{ $menu->title }}</h6>
                        </div>
                    </a>
                </div>
            </div>

        @endforeach
    </div>
@endif