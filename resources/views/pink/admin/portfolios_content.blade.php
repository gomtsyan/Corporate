@if($portfolios && count($portfolios) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body  ">
                    <h5 class="card-title m-b-0 float-left ">Portfolios</h5>
                    <a href="{{ route('portfolio.create') }}" class="btn btn-success  float-right"><i class="mdi mdi-plus"></i>Add</a>
                </div>

                <table class="table">
                    <thead>
                    <tr class="bg-light">
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Text</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Img</th>
                        <th scope="col">Alias</th>
                        <th scope="col">Filter</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($portfolios as $portfolio)
                        <tr>
                            <th scope="row">{{ $portfolio->id }}</th>
                            <td>{{ $portfolio->title }}</td>
                            <td>{{ Str::limit($portfolio->text, 200) }}</td>
                            <td>{{ $portfolio->customer }}</td>
                            <td><img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->img->mini ? $portfolio->img->mini : '009-175x175.jpg' }}" ></td>
                            <td>{{ $portfolio->alias }}</td>
                            <td>{{ $portfolio->filter->title }}</td>
                            <td>
                                <a href="{{ route('portfolio.edit', ['portfolio'=>$portfolio->alias]) }}" class="btn btn-cyan btn-sm m-1 btn-block">Edit</a>

                                <form action="{{ route('portfolio.destroy', ['portfolio'=>$portfolio->alias]) }}" method="post">
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
    <p>{{ Lang::get('ru.no_portfolios') }}</p>
@endif





