<div class="card">
    <form action="{{  isset($user->id) ? route('users.update', ['users'=>$user->id]) :  route('users.store') }}" method="post" enctype="multipart/form-data">
        <div class="card-body">

            <div class="row">

                <div class="col-6">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 text-left control-label col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" placeholder="Name Here" name="name" value="{{ isset($user->name) ? $user->name : old('name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="login" class="col-sm-2 text-left control-label col-form-label">Login</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="login" placeholder="Login Here" name="login" value="{{ isset($user->login) ? $user->login : old('login') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 text-left control-label col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email" placeholder="Email Here" name="email" value="{{ isset($user->email) ? $user->email : old('email') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 m-t-15">Roles</label>
                            <div class="col-md-9">

                                {!! Form::select(
                                                    'role_id',
                                                    $roles,
                                                    isset($user) ? $user->roles()->first()->id : null ,
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

                <div class="col-6">

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 text-left control-label col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password" >
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-6">

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="password_confirm" class="col-sm-3 text-left control-label col-form-label">Password confirm</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password_confirm" placeholder="Password confirm" name="password_confirmation" >
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        @if(isset($user->id))
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