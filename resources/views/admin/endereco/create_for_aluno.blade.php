@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container top__cem">
        <h3 class="grey-text">CADASTRAR <strong>ENDEREÇO</strong></h3>
        <div>
            <h5 class="grey-text">Aluno: {{$aluno->name}}</h5>
        </div>

        {!! Form::open(['route'=>'store.endereco.aluno','method'=>'post']) !!}
        @include('admin.endereco._form')

        {!! Form::hidden('aluno_id', $aluno->id) !!}
        <div class="row">
            {!! Form::submit('Cadastrar Endereco',['class'=>'waves-effect waves-light btn']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop