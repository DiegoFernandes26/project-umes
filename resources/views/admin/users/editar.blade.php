@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container" style="margin-top:50px;">
        <div class="chip">Editar</div>


        <h2>{{$user->name}}</h2>


        {{--Estamos utilizando aqui o form model bind--}}
        {!! Form::model($user,['route'=>['usuario.update', $user->id],'method'=>'put']) !!}

        @include('admin.users._form')

        <div class="form-group">
            {!! Form::submit('Salvar Alterações',['class'=>'waves-effect waves-light btn fle-box']) !!}
        </div>



    {!! Form::close() !!}
@stop