@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">

        <div>
            <h4>{{$aluno->name}}</h4>

        </div>
        <h5>EDITAR ENDEREÇO</h5>
        {{--Estamos utilizando aqui o form model bind--}}
        {!! Form::model($aluno->endereco,['route'=>['atualizar.endereco.aluno', $aluno->endereco->id],'method'=>'put']) !!}
        @include('admin.endereco._form')
        {{--{!! Form::hidden('escola_id', $instituicao->id) !!}--}}
        <div class="form-group">
            {!! Form::submit('Salvar Alterações',['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@stop