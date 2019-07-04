<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body  ">
                <h5 class="card-title m-b-0 float-left ">Menu</h5>
                <a href="{{ route('menu.create') }}" class="btn btn-success  float-right"><i class="mdi mdi-plus"></i>Add</a>
            </div>

            <table class="table">
                <thead>
                <tr class="bg-light">
                    <th scope="col">Name</th>
                    <th scope="col">Link</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                    @if($menu)

                        @include(config('settings.theme').'.admin.custom-menu-items', ['items'=>$menu->roots(), 'paddingLeft'=>"<span class='text-cyan'><i class='mdi mdi-view-list'></i></span>"])

                    @endif

                </tbody>
            </table>

        </div>
    </div>
</div>






