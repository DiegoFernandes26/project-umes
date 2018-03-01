@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">

        <div>
            <h4>INSTITUIÇÃO: {{$instituicao->nome}}</h4>
            <ul>
                <li>Cnpj: {{$instituicao->cnpj}}</li>
            </ul>
        </div>
        <h5>EDITAR ENDEREÇO</h5>
        {{--Estamos utilizando aqui o form model bind--}}
        {!! Form::model($endereco,['route'=>['endereco.update', $endereco->id],'method'=>'put']) !!}
         @include('admin.endereco._form')
        {!! Form::hidden('escola_id', $instituicao->id) !!}
        <div class="form-group">
            {!! Form::submit('Salvar Alterações',['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@stop