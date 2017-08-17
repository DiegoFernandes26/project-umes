@extends('layout')
@section('content')
    @include('admin.menu')

    <div class="container top__cem">
        <div class="row">
            <div class="col s9">
                <h3 class="grey-text">NOVA <strong>CARTEIRA</strong></h3>
                <h5 class="grey-text">Escola: {{$escola->nome}}</h5>
            </div>

        @if($errors->any())
            <ul class="">
                @foreach($errors->all() as $erro)
                    <li>{{$erro}}</li>
                @endforeach

            </ul>
        @endif
        </div>
        {!! Form::open(['route'=>'cart.store','method'=>'post', 'files'=>true]) !!}



        @include('admin.carteira._form')

        <div class="row">
            <div class="col s12">
                {!! Form::submit('Gerar carteira',['class'=>'btn btn-large']) !!}
            </div>
        </div>

        {!! Form::close() !!}


    </div>
@stop