@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container" style="margin-top:50px;" id="container">
        <div class="chip">Editar configurações</div>

        {{--Estamos utilizando aqui o form model bind--}}
        {!! Form::model($config,['route'=>['config.update', $config->id],'method'=>'put', 'files'=>true]) !!}

        @include('admin.config_sistema._form')

        <div class="form-group">
            {!! Form::submit('Salvar Alterações',['class'=>'waves-effect waves-light btn fle-box']) !!}
        </div>
    {!! Form::close() !!}

@stop