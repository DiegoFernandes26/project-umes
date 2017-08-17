@extends('layout')
@section('content')

    <div class="container-home">
        <div class="login-home z-depth-1 enter-left-bounce">

        <!-- <div class="panel-heading">{{ trans('validation.attributes.login') }}</div> -->

            @if (count($errors) > 0)
                <div class="alert alert-danger deep-orange accent-2">
                    <h3>Ooops! :( </h3>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="{{ route('login') }}" class="form-login">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div>
                    <label class="col-md-4 control-label">{{ trans('validation.attributes.email') }}</label>
                    <div class="col-md-6">
                        {!! Form::text('email', null, ['class' => 'form-control', 'type' => 'email']) !!}
                    </div>
                </div>

                <div>
                    <label class="col-md-4 control-label">{{ trans('validation.attributes.password') }}</label>
                    <div class="col-md-6">
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div style="text-align: center">
                    <button type="submit" class="waves-effect waves-light btn total cyan"
                            style="margin-right: 15px;">{{ trans('validation.attributes.login') }}</button>
                    <br/><br/>
                    <a href="/forgot">{{ trans('validation.attributes.forgotpassword') }}</a>
                </div>

            </form>

        </div>
    </div>
@endsection