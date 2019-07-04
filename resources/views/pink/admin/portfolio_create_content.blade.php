
<div class="card">
    <form action="{{  isset($portfolio->id) ? route('portfolio.update', ['portfolio'=>$portfolio->alias]) :  route('portfolio.store') }}" method="post" enctype="multipart/form-data">
        <div class="card-body">

            <div class="row">

                <div class="col-6">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 text-left control-label col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" placeholder="Title Here" name="title" value="{{ isset($portfolio->title) ? $portfolio->title : old('title') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="alias" class="col-sm-2 text-left control-label col-form-label">Alias</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alias" placeholder="Alias Here" name="alias" value="{{ isset($portfolio->alias) ? $portfolio->alias : old('alias') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="keywords" class="col-sm-3 text-right control-label col-form-label">Keywords</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="keywords" placeholder="Keywords Here" name="keywords" value="{{ isset($portfolio->keywords) ? $portfolio->keywords : old('keywords') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="meta_desc" class="col-sm-3 text-right control-label col-form-label">Meta desc</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="meta_desc" placeholder="Meta description Here" name="meta_desc" value="{{ isset($portfolio->meta_desc) ? $portfolio->meta_desc : old('meta_desc') }}">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-12">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="editor" class="col-sm-3 text-left control-label col-form-label">Text</label>
                            <textarea name="text" id="editor" class="col-12">{{ isset($portfolio->text) ? $portfolio->text : old('text') }}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-6">

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 m-t-15">Filter</label>
                            <div class="col-md-9">

                                {!! Form::select(
                                                    'filter_alias',
                                                    $filters,
                                                    isset($portfolio->filter_alias) ? $portfolio->filter_alias : '' ,
                                                    [
                                                        'class' => 'select2 form-control custom-select',
                                                        'placeholder' => 'Select filter'
                                                    ]
                                ); !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="customer" class="col-sm-3 text-left control-label col-form-label">Customer</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="customer" placeholder="Customer Here" name="customer" value="{{ isset($portfolio->customer) ? $portfolio->customer : old('customer') }}">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-6">

                    <div class="card-body">
                        @if(isset($portfolio) && $portfolio->img->path)
                            <div class="form-group row">
                                <label class="col-md-3">Portfolio Images</label>
                                <div class="col-md-9">
                                    <div class="bd-example">
                                        {!! Html::image(asset(config('settings.theme')).'/images/projects/'.$portfolio->img->path, '' ,['class'=>'img-fluid']) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-md-3">Image Upload</label>
                            <div class="col-md-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="validatedCustomFile" name="image">
                                    <label name="image" class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        @if(isset($portfolio->id))
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

<script>
    $( document ).ready(function() {
        CKEDITOR.replace( 'editor' );
    });
</script>