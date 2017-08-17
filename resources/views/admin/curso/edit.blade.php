@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container" style="margin-top:50px;" id="container">
        <div class="chip">Editar</div>

{{--        <h2>{{$curso->name}}</h2>--}}

        {{--Estamos utilizando aqui o form model bind--}}
        {!! Form::model($curso,['route'=>['cursos.update', $curso->id],'method'=>'put']) !!}

        @include('admin.curso._form')

        <div class="col s12">
            {!! Form::submit('Salvar Alterações',['class'=>'waves-effect waves-light btn fle-box']) !!}
        </div>
        {!! Form::close() !!}
  @stop