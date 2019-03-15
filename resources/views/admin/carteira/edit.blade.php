@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">
        <h3 class="grey-text">Editar carteira:</h3>
        <h5 class="grey-text">Instituição: {{$aluno->escola->nome}}:</h5>

        @include('errors.errors_message')

        {{--Estamos utilizando aqui o form model bind--}}
        {!! Form::model($aluno,['route'=>['cart.update', $aluno->id],'method'=>'put', 'files'=>true]) !!}

        @include('admin.carteira._form')


        <div class="row">
            @if($aluno->dt_validade< date('Y-m-d'))
                <div class="form-group s6">
                    {!! Form::submit('Salvar e renovar Carteira',['name'=>'renovar','class'=>'btn btn-primary red']) !!}
                </div>
            @elseif(date('Y',strtotime($aluno->dt_validade)) < date('Y',strtotime($config->dt_expiracao)))
                <div class="row">
                    <div class="form-group col s3">
                        {!! Form::submit('Salvar Alterações',['class'=>'btn btn-primary','name'=>'salvar']) !!}
                    </div>
                    <div class="form-group col s3">
                        {!! Form::submit("Atualizar data de validade",['class'=>'btn blue','name'=>'atualizarData']) !!}
                    </div>
                </div>
            @else
                <div class="form-group col s3">
                    {!! Form::submit('Salvar Alterações',['class'=>'btn btn-primary','name'=>'salvar']) !!}
                </div>
            @endif
        </div>

        {!! Form::close() !!}
    </div>
    <br><br><br><br><br><br><br>
@stop