@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">
        <h5><b>INSTITUIÇÃO</b></h5>
        <div>
            <h4>Instiruição: {{$instituicao->nome}}</h4>
            <ul>
                <li>Cnpj: {{$instituicao->cnpj}}</li>
            </ul>
        </div><br>
        <h5><b>EDITAR ENDEREÇO</b></h5>
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