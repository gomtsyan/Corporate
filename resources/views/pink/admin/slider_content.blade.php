@if($slider && count($slider) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body  ">
                    <h5 class="card-title m-b-0 float-left ">Slider</h5>
                    <a href="{{ route('slider.create') }}" class="btn btn-success  float-right"><i class="mdi mdi-plus"></i>Add</a>
                </div>

                <table class="table">
                    <thead>
                    <tr class="bg-light">
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Desc</th>
                        <th scope="col">Image</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($slider as $slider_item)
                        <tr>
                            <th scope="row">{{ $slider_item->id }}</th>
                            <td>{{ $slider_item->title }}</td>
                            <td>{{ $slider_item->desc }}</td>
                            <td>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="mdb-lightbox-ui"></div>
                                        <div class="mdb-lightbox">
                                            <figure class="col-md-11">
                                                <a href="#" data-size="1600x1067">
                                                    <img alt="slide" src="{{ asset(config('settings.theme')) }}/images/slider-cycle/{{ $slider_item->img ? $slider_item->img : 'xx.jpg' }}" class="img-fluid">
                                                </a>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <a href="{{ route('slider.edit', ['slider'=>$slider_item->id]) }}" class="btn btn-cyan btn-sm m-1 btn-block">Edit</a>

                                <form action="{{ route('slider.destroy', ['slider'=>$slider_item->id]) }}" method="post">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <input type="submit" name="delete" value="Delete" class="btn btn-danger btn-sm m-1 btn-block">
                                </form>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <p>{{ Lang::get('ru.no_slider') }}</p>
@endif





