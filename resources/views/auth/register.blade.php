@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container" style="margin-top: 100px">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"></div>
                    <div class="panel-body">

                        <h3 class="grey-text" style="font-weight: 800">CADASTRAR USUÁRIO</h3>

                        {!! Form::open(['route'=>'register','method'=>'post']) !!}

                            @include('admin.users._form')

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit('Cadastrar usuário',['class'=>'waves-effect waves-light btn']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection