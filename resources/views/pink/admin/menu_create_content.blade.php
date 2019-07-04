<div class="card">
    <form action="{{  isset($menu->id) ? route('menu.update', ['menu'=>$menu->id]) :  route('menu.store') }}" method="post" enctype="multipart/form-data">
        <div class="card-body">

            <div class="row">

                <div class="col-6">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 text-left control-label col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" placeholder="Title Here" name="title" value="{{ isset($menu->title) ? $menu->title : old('title') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 m-t-15">Parent type</label>
                            <div class="col-md-9">

                                {!! Form::select(
                                                    'parent_id',
                                                    $menus,
                                                    isset($menu->parent_id) ? $menu->parent_id : null ,
                                                    [
                                                        'class' => 'select2 form-control custom-select'
                                                    ]
                                ); !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="accordion" id="accordionExample">

                        <div class="card m-b-0">
                            <div class="card-header" id="headingOne">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="customControlValidation1" name="type" value="customLink" {{ (isset($type) && $type == 'customLink') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customControlValidation1" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <h5 class="mb-0">Custom link</h5>
                                    </label>
                                </div>
                            </div>
                            <div id="collapseOne" class="collapse {{ (isset($type) && $type == 'customLink') ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordionExample">

                                <div class="row">

                                    <div class="col-6">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="path" class="col-sm-3 text-left control-label col-form-label">Link path</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="path" placeholder="Path Here" name="custom_link" value="{{ (isset($menu->path) && $type == 'customLink') ? $menu->path : old('path') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">

                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="card m-b-0 border-top">
                            <div class="card-header" id="headingTwo">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="customControlValidation2" name="type" value="blogLink" {{ (isset($type) && $type == 'blogLink') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customControlValidation2" class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <h5 class="mb-0">Blog section</h5>
                                    </label>
                                </div>
                            </div>
                            <div id="collapseTwo" class="row collapse {{ (isset($type) && $type == 'blogLink') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionExample">


                                    <div class="col-6">

                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label class="col-md-4 m-t-10">Blog category links</label>
                                                <div class="col-md-8">

                                                    {!! Form::select(
                                                                        'category_alias',
                                                                        $categories,
                                                                        (isset($option) && $option) ? $option : false ,
                                                                        [
                                                                            'class' => 'selectpicker ',
                                                                            'data-live-search' => 'true ',
                                                                            'data-style' => 'btn-outline-info',
                                                                        ]
                                                    ); !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-6">

                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label class="col-md-4 m-t-10">Blog material links</label>
                                                <div class="col-md-8">

                                                    {!! Form::select(
                                                                        'article_alias',
                                                                        $articles,
                                                                        (isset($option) && $option) ? $option : false ,
                                                                        [
                                                                            'class' => 'selectpicker ',
                                                                            'data-live-search' => 'true ',
                                                                            'data-style' => 'btn-outline-info',
                                                                        ]
                                                    ); !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                            </div>
                        </div>

                        <div class="card m-b-0 border-top">
                            <div class="card-header" id="headingThree">

                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customControlValidation3" name="type" value="portfolioLink" {{ (isset($type) && $type == 'portfolioLink') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customControlValidation3" class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <h5 class="mb-0">Portfolio section</h5>
                                        </label>
                                    </div>

                            </div>
                            <div id="collapseThree" class="collapse {{ (isset($type) && $type == 'portfolioLink') ? 'show' : '' }}" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="row">

                                    <div class="col-6">

                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label class="col-md-4 m-t-10">Portfolio entry Links</label>
                                                <div class="col-md-8">

                                                    {!! Form::select(
                                                                        'portfolio_alias',
                                                                        $portfolios,
                                                                        (isset($option) && $option) ? $option : false ,
                                                                        [
                                                                            'class' => 'selectpicker ',
                                                                            'data-live-search' => 'true ',
                                                                            'data-style' => 'btn-outline-info',
                                                                        ]
                                                    ); !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-6">

                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label class="col-md-4 m-t-10">Portfolio</label>
                                                <div class="col-md-8">

                                                    {!! Form::select(
                                                                        'filter_alias',
                                                                        $filers,
                                                                        (isset($option) && $option) ? $option : false,
                                                                        [
                                                                            'class' => 'selectpicker ',
                                                                            'data-live-search' => 'true ',
                                                                            'data-style' => 'btn-outline-info',
                                                                        ]
                                                    ); !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        @if(isset($menu->id))
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






