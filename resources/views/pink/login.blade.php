@extends(config('settings.theme').'.layouts.site')

@section('content')
    <div id="content-page" class="content group">
        <div class="hentry group">
            <form id="contact-form-contact-us" class="contact-form" method="post" action="{{ url('/login') }}" enctype="multipart/form-data">
                <div class="usermessagea">
                    @if(count($errors) > 0)
                        <p class="error">
                            @foreach($errors->all() as $error)
                                <span>
                                        {{ $error }}
                                    <br/>
                                    </span>
                            @endforeach
                        </p>
                    @endif

                    @if(session('status'))

                        <p class="success">
                            {{ session('status') }}
                        </p>

                    @endif
                </div>
                <fieldset>
                    <ul>
                        <li class="text-field">
                            <label for="login">
                                <span class="label">Login</span>
                                <br />					<span class="sublabel">This is the Login</span><br />
                            </label>
                            <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input type="text" name="login" id="login" class="required" value="{{ old('login') }}" /></div>
                            <div class="msg-error"></div>
                        </li>
                        <li class="text-field">
                            <label for="password">
                                <span class="label">Password</span>
                                <br />					<span class="sublabel">This is a field Password</span><br />
                            </label>
                            <div class="input-prepend"><span class="add-on"><i class="icon-envelope"></i></span><input type="password" name="password" id="password" class="required email-validate" value="{{ old('password') }}" /></div>
                            <div class="msg-error"></div>
                        </li>

                        <li class="submit-button">
                            {{ csrf_field() }}
                            <input type="submit"  value="Send Message" class="sendmail aligncenter" />
                        </li>
                    </ul>
                </fieldset>
            </form>

        </div>

    </div>
@endsection


{{--@section('footer')
    {!! $footer !!}
@endsection--}}
