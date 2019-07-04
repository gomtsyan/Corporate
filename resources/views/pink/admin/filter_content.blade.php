@if($filters && count($filters) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body  ">
                    <h5 class="card-title m-b-0 float-left ">Filters</h5>
                    <a href="{{ route('filter.create') }}" class="btn btn-success  float-right"><i class="mdi mdi-plus"></i>Add</a>
                </div>

                <table class="table">
                    <thead>
                    <tr class="bg-light">
                        <th scope="col">#</th>
                        <th scope="col">Alias</th>
                        <th scope="col">Title</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($filters as $filter)
                        <tr>
                            <th scope="row">{{ $filter->id }}</th>
                            <td>{{ $filter->alias }}</td>
                            <td>{{ $filter->title }}</td>

                            <td>
                                <a href="{{ route('filter.edit', ['filter'=>$filter->id]) }}" class="btn btn-cyan btn-sm m-1 btn-block">Edit</a>

                                <form action="{{ route('filter.destroy', ['filter'=>$filter->id]) }}" method="post">
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
    <p>{{ Lang::get('ru.no_filter') }}</p>
@endif





