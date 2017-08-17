@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container top__cem">
        <h3 class="grey-text">CADASTRAR <strong>ENDEREÇO</strong></h3>
        <div>
            <h5 class="grey-text">Instituição: {{$instituicao->nome}}</h5>
           <h6 class="grey-text">Cnpj: {{$instituicao->cnpj}}</h6>
        </div>

        {!! Form::open(['route'=>'endereco.store','method'=>'post']) !!}
        @include('admin.endereco._form')

        {!! Form::hidden('escola_id', $instituicao->id) !!}
        <div class="row">
            {!! Form::submit('Cadastrar Endereco',['class'=>'waves-effect waves-light btn']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop