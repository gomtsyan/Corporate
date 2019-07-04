<div class="card">
    <form action="{{  isset($slider->id) ? route('slider.update', ['slider'=>$slider->id]) :  route('slider.store') }}" method="post" enctype="multipart/form-data">
        <div class="card-body">

            <div class="row">

                <div class="col-12">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="editor" class="col-sm-3 text-left control-label col-form-label">Title</label>
                            <textarea name="title" id="editor" class="col-12">{{ isset($slider->title) ? $slider->title : old('title') }}</textarea>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="editor2" class="col-sm-3 text-left control-label col-form-label">Description</label>
                            <textarea name="desc" id="editor2" class="col-12">{{ isset($slider->desc) ? $slider->desc : old('desc') }}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-6">

                    <div class="card-body">
                        @if(isset($slider) && $slider->img)
                            <div class="form-group row">
                                <label class="col-md-3">Slider Image</label>
                                <div class="col-md-9">
                                    <div class="bd-example">
                                        {!! Html::image(asset(config('settings.theme')).'/images/slider-cycle/'.$slider->img, '' ,['class'=>'img-fluid']) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

                <div class="col-6">

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3">Image Upload</label>
                            <div class="col-md-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="validatedCustomFile" name="image" >
                                    <label name="image" class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        @if(isset($slider->id))
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
        CKEDITOR.replace( 'editor2' );
    });
</script>