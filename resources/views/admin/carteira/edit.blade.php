@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">
        <h3 class="grey-text">Editar carteira:</h3>

        @if($errors->any())
            <ul class="alert">
                @foreach($errors->all() as $erro)
                    <li>{{$erro}}</li>
                @endforeach
            </ul>
        @endif

        {{--Estamos utilizando aqui o form model bind--}}
        {!! Form::model($aluno,['route'=>['cart.update', $aluno->id],'method'=>'put', 'files'=>true]) !!}

        @include('admin.carteira._form')
        <div class="row">
            @if($aluno->dt_validade< date('Y-m-d'))
                <div class="form-group s6">
                    {!! Form::hidden('renovar', true) !!}
                    {!! Form::submit('Salvar e renovar Carteira',['class'=>'btn btn-primary red']) !!}
                </div>
            @else
                <div class="form-group col s6">
                    {!! Form::submit('Salvar Alterações',['class'=>'btn btn-primary']) !!}
                </div>

            @endif
        </div>

        {!! Form::close() !!}
    </div>
    <br><br><br><br><br><br><br>
@stop