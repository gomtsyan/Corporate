@if($categories && count($categories) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body  ">
                    <h5 class="card-title m-b-0 float-left ">Categories</h5>
                    <a href="{{ route('category.create') }}" class="btn btn-success  float-right"><i class="mdi mdi-plus"></i>Add</a>
                </div>

                <table class="table">
                    <thead>
                    <tr class="bg-light">
                        <th scope="col">#</th>
                        <th scope="col">Alias</th>
                        <th scope="col">Title</th>
                        <th scope="col">Parent</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->id }}</th>
                            <td>{{ $category->alias }}</td>
                            <td>{{ $category->title }}</td>
                            <td>{{ ($category->parent_id != 0 ) ? $categories->find($category->parent_id)->title : 'Parent' }}</td>

                            <td>
                                <a href="{{ route('category.edit', ['category'=>$category->id]) }}" class="btn btn-cyan btn-sm m-1 btn-block">Edit</a>

                                <form action="{{ route('category.destroy', ['category'=>$category->id]) }}" method="post">
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
    <p>{{ Lang::get('ru.no_category') }}</p>
@endif





