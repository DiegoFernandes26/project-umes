@extends('layout')
@section('content')
    @include('admin.menu')
    {{--<link rel="stylesheet" type="text/css" href="../../css/carteira.css">
    </head>
    <body>

    <div class="box_cartao">
        <img src="../../../img/img/cart.jpg">

        <!--código de barras-->
        --}}{{--<div class="qrCode"><img src="../../../img/img/barcode.jpg"></div>--}}{{--

    </div>
--}}

    <div class="container top__cem">


        <h3 class="grey-text">VERSOS <strong>CADASTRADOS</strong></h3>
        {{--Retorna mensagens de erro--}}
        @if($errors->any())
            <ul class="alert-danger">
                @foreach($errors->all() as $erro)
                    <li>{{$erro}}</li>
                @endforeach
            </ul>
        @endif
        @if (session('status'))
            <ul class="alert-danger">
                <li>{{ session('status') }}</li>
            </ul>
        @endif
        {{--Fim de retorno de mensagens de erro--}}


        <div class="row">
            <div class="col s3">
                <a class="waves-effect waves-light btn btn-large cyan __cem left" href="#cad-verso"><i
                            class="material-icons left">add_circle</i>Novo verso</a>
            </div>
            <div class="col s9 ">
                <input type="text" class="campo-busca" placeholder="Buscar verso" id="busca-campo">
            </div>
        </div>

        @if($verso)
            <div class="row" id="cards">
            @foreach($verso as $versos)

                {{--<ul>--}}
                {{--<li>{{$versos->name}}</li>--}}
                {{--<li><img src="../{{$versos->img_verso}}"</li>--}}
                <!-- {{--<li><a href="{{route('cart.verso.excluir', ['id'=>$versos->id])}}">Excluir</a></li>--}} -->
                    {{--<li><a href="#" onclick="deletar_modal({{$versos->id}},'{{$versos->name}}')">Excluir</a></li>--}}
                    {{--</ul>--}}

                    <div class="col s4">
                        <div class="card @if ($versos->status==true)ativo_card @endif">
                            <div class="card-image">
                                <img src="../{{$versos->img_verso}}">
                                <div style="position:absolute;top: 10px;right: 5px; z-index: 999; background: trasparent">
                                    {!! Form::radio('ativo',$versos->id,($versos->status?true:false), ['id'=>$versos->id, 'name'=>'ativo'])!!}
                                    {!! Form::label($versos->id, 'Ativo') !!}
                                </div>
                            </div>
                            <div class="card-content">
                                <h5 class="texto-list truncate"
                                    style="border-bottom: 1px solid #ccc;padding-bottom: 10px; font-weight: 800">
                                    {{$versos->name}}</h5>

                                <a href="{{route('cart.verso.excluir', ['id'=>$versos->id])}}"
                                class="btn __cem btn-flat">Excluir</a>   </li>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        @else
            <h4 class="grey-text">Ainda não existem campanhas criadas, crie a primeira ;).</h4>
        @endif
    </div>

    <div id="cad-verso" class="modal">
        <div class="modal-content">
            <h4>Cadastrar novo verso</h4>

            {!! Form::open(['route'=>'cart.verso.store', 'method'=>'post', 'files'=>true]) !!}
            <div class="row">
                <div class="col s12">

                    {!! Form::label('name', 'Título da campanha') !!}
                    {!! Form::text('name', null, ['placeholder'=>'Título da campanha','name'=>'name']) !!}
                </div>
                <div class="col s12">

                    <div class="file-field input-field">
                        <div class="btn grey">
                            <span><i class="material-icons">crop_original</i>Imagem</span>
                            {!! Form::file('img_verso') !!}
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            {!! Form::submit('Cadastrar',['class'=>'btn btn-flat']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <script type="text/javascript">

        $("input:radio[name='ativo']").click(function () {
            var nivel = $(this).val();
            $.get('/admin/ativa_verso/' + nivel);
            location.reload();
        });
    </script>
@stop