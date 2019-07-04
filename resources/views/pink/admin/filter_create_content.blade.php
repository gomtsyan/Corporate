
<div class="card">
    <form action="{{  isset($filter->id) ? route('filter.update', ['filter'=>$filter->id]) :  route('filter.store') }}" method="post" enctype="multipart/form-data">
        <div class="card-body">

            <div class="row">

                <div class="col-6">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="alias" class="col-sm-2 text-left control-label col-form-label">Alias</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alias" placeholder="Alias Here" name="alias" value="{{ isset($filter->alias) ? $filter->alias : old('alias') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 text-left control-label col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" placeholder="Title Here" name="title" value="{{ isset($filter->title) ? $filter->title : old('title') }}">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        @if(isset($filter->id))
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