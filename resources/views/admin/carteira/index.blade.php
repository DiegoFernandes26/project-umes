@extends('layout')
@section('content')
    @include('admin.menu')

    <div class="container top__cem">
        <h3 class="grey-text">ESCOLHA UMA INSTITUIÇÃO<strong>DE ENSINO</strong></h3>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        {{--{!! Form::open(['route'=>'cart.create','method'=>'get']) !!}--}}

        {{--<div class="input-field col s6">--}}
        {{--{!! Form::select('escola_id', $escola, null, ['placeholder'=>'Instituição', 'id'=>'escola'])!!}--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
        {{--{!! Form::submit('Selecionar',['class'=>'btn waves-effect wave-li']) !!}--}}
        {{--</div>--}}

        {{--{!! Form::close() !!}--}}


        <div class="col s12 ">
            <input type="text" class="campo-busca" placeholder="Digite o nome da instituição" id="busca-campo">
        </div>
        @if(count($escola) > 0)
            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header" id="collection-item">
                        @foreach($escola as $dados)
                            <li class="collection-item avatar lista-item  grey lighten-5">
                                <a href="{{route('cart.create', ['id'=>$dados->id])}}"><h5 class="texto-list">{{$dados->nome}}</h5></a>
                                <div class="bt-edicao">
                                    <div class="card-vision">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        @else
                            <div>
                                <h3 class="grey-text">Não existem instituições cadastradas ainda!</h3>
                            </div>
                    </ul>
                </div>
                @endif




    </div>

    {{--<script>--}}
        {{--function loadDoc() {--}}
            {{--var xhttp = new XMLHttpRequest();--}}
            {{--xhttp.onreadystatechange = function () {--}}
                {{--if (this.readyState == 4 && this.status == 200) {--}}
                    {{--document.getElementById("demo").innerHTML = this.responseText;--}}
                {{--}--}}
            {{--};--}}
            {{--var conteudo = document.getElementById("teste").value;--}}
            {{--var content = jQuery("#teste").val();--}}
            {{--if (content == '') {--}}
                {{--document.getElementById("teste").placeholder = "Digite a instituição desejada!";--}}
                {{--conteudo = 1;--}}
            {{--}--}}
            {{--xhttp.open("GET", "list/" + conteudo, true);--}}
            {{--xhttp.send();--}}
        {{--}--}}
    {{--</script>--}}


    {{--<div class="container">--}}
        {{--<input type="text" id="teste" onkeyup="loadDoc()" placeholder="Digite a instituição desejada!">--}}
        {{--<div id="demo" class="margin__vinte">--}}

        {{--</div>--}}
    {{--</div>--}}



@stop