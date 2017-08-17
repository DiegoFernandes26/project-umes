@extends('layout')
@section('content')
    @include('admin.menu')

    <div class="container top__cem">
        <h3 class="grey-text">Configurações</h3>
        <div class="row">
            {!! Form::open(['route'=>'config.store', 'method'=>'post', 'files'=>true]) !!}

            @include('admin.config_sistema._form')
            <div class="row">
                <div class="col s12">
                    {!! Form::submit('Salvar configurações',['class'=>'btn btn-large']) !!}
                </div>
            </div>

            {!! Form::close() !!}

        </div>
    </div>

@stop