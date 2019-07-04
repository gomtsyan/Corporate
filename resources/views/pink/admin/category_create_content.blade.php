
<div class="card">
    <form action="{{  isset($category->id) ? route('category.update', ['category'=>$category->id]) :  route('category.store') }}" method="post" enctype="multipart/form-data">
        <div class="card-body">

            <div class="row">

                <div class="col-6">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="alias" class="col-sm-2 text-left control-label col-form-label">Alias</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alias" placeholder="Alias Here" name="alias" value="{{ isset($category->alias) ? $category->alias : old('alias') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="icon" class="col-sm-2 text-left control-label col-form-label">Parent</label>
                            <div class="col-sm-10">
                                {!! Form::select(
                                                    'parent_id',
                                                    (isset($category_list) && $category_list) ? $category_list : [],
                                                    (isset($category->id) && $category->id != 0) ? $category->parent_id : '0' ,
                                                    [
                                                        'class' => 'select2 form-control custom-select',
                                                    ]
                                ); !!}

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 text-left control-label col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" placeholder="Title Here" name="title" value="{{ isset($category->title) ? $category->title : old('title') }}">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        @if(isset($category->id))
            <input type="hidden" name="_method" value="PUT">
        @endif

        {{ csrf_field() }}

        <div class="border-top">
            <div class="card-body">
                <input type="submit" value="Save" class="btn btn-primary">
            </div>
        </div>

    </form>
</div>