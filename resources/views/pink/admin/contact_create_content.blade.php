
<div class="card">
    <form action="{{  isset($contact->id) ? route('contact.update', ['contact'=>$contact->id]) :  route('contact.store') }}" method="post" enctype="multipart/form-data">
        <div class="card-body">

            <div class="row">

                <div class="col-6">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 text-left control-label col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" placeholder="Name Here" name="name" value="{{ isset($contact->name) ? $contact->name : old('name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="icon" class="col-sm-2 text-left control-label col-form-label">Icon</label>
                            <div class="col-sm-10">
                                {{--<input type="text" class="form-control" id="icon" placeholder="Icon Here" name="icon" value="{{ isset($contact->icon) ? $contact->icon : old('icon') }}">--}}
                                @if(isset($fa_icons) && is_array($fa_icons))
                                    <select id="icon" name="icon" class="selectpicker" data-live-search="true">
                                        @foreach($fa_icons as $icon_class => $fa_icon)
                                            <option data-content="<i class='{{ $icon_class }}'></i> {{ $icon_class }}" value="{{ $icon_class }}" {{ (isset($contact->icon) && $contact->icon == $icon_class) ? 'selected="selected"' : '' }} > </option>
                                        @endforeach
                                    </select>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="value" class="col-sm-2 text-left control-label col-form-label">Value</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="value" placeholder="Value Here" name="value" value="{{ isset($contact->value) ? $contact->value : old('value') }}">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        @if(isset($contact->id))
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