@if($articles && count($articles) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body  ">
                    <h5 class="card-title m-b-0 float-left ">Articles</h5>
                    <a href="{{ route('article.create') }}" class="btn btn-success  float-right"><i class="mdi mdi-plus"></i>Add</a>
                </div>

                <table class="table">
                    <thead>
                    <tr class="bg-light">
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Text</th>
                        <th scope="col">Img</th>
                        <th scope="col">Category</th>
                        <th scope="col">Alias</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <th scope="row">{{ $article->id }}</th>
                            <td>{{ $article->title }}</td>
                            <td>{{ Str::limit($article->desc, 200) }}</td>
                            <td><img src="{{ asset(config('settings.theme')) }}/images/articles/{{ $article->img->mini }}" ></td>
                            <td>{{ $article->category->title }}</td>
                            <td>{{ $article->alias }}</td>
                            <td>
                                <a href="{{ route('article.edit', ['article'=>$article->alias]) }}" class="btn btn-cyan btn-sm m-1 btn-block">Edit</a>

                                <form action="{{ route('article.destroy', ['article'=>$article->alias]) }}" method="post">
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
    <p>{{ Lang::get('ru.no_articles') }}</p>
@endif





