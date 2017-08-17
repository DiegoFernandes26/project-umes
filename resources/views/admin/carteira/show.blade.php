@extends('layout')
@section('content')
    @include('admin.menu')
    <link rel="stylesheet" type="text/css" href="../../css/carteira.css">
    </head>
    <body>

    <div class="box_cartao">
        <img src="../../../{{$config->img_carteira}}">

        <div class="foto-pessoa preview">
            {{--<img src="../../../{{$busca->foto}}" class="draggable">--}}
        </div>

        <!--dados pessoais-->
        <div class="dadosPessoais">
            @if($busca->name_social != null)
                <div class="fieldDado">Nome Social</div>
                <div class="dado">{{$busca->name_social}}</div>
            @else
                <div class="fieldDado">Nome</div>
                <div class="dado">{{$busca->name}}</div>
            @endif

            <div class="fieldDado">Instituição de ensino</div>
            <div class="dado">{{$busca->escola->nome}}</div>

            <div class="fieldDado">Curso</div>
            <div class="dado">{{(isset($curso->name) ? $curso->name : "-------")}}</div>

            <div class="col-2" style="width: 25%;">
                <div class="fieldDado">Nasc.</div>
                <div class="dado">{{date('d/m/y',strtotime($busca->dt_nascimento))}}</div>
            </div>
            <div class="col-2" style="text-align: center">
                <div class="fieldDado">RG</div>
                <div class="dado">{{$busca->rg}}</div>
            </div>
            <div class="col-2" style="width: 41.5%">
                <div class="fieldDado">CPF</div>
                <div class="dado">{{$busca->cpf}}</div>
            </div>


        </div>
        <div class="validade">
            Validade: {{date('m/y',strtotime($busca->dt_validade))}}
        </div>

        <!--código carteira-->
        <div class="codCarteira">
            COD. {{$busca->numero_carteira}}
        </div>


        <div class="anoVigente">{{date('Y', strTotime($busca->created_at))}}</div>
        <!--código de barras-->
        {{--<div class="qrCode"><img src="../../../img/img/barcode.jpg"></div>--}}
        <div class="qrCode">
            {!! QrCode::size(50)->margin(0)->generate(url().'/vercarteira/'.$busca->numero_carteira) !!}
        </div>

    </div>

    {{--CONTEÚDO DO VERSO DA CARTEIRA--}}
    @if($verso)
        <div class="box_cartao verso-print" style="display: none">
            <img src="../../../{{$verso->img_verso}}">
        </div>
    @else:
    <h3 class="grey-text">Não existem campanhas de verso cadastradas.</h3>
    @endif
    {{--FIM CONTEÚDO VERSO DA CARTEIRA--}}

    <div class="painel-edit  grey lighten-2">
        <div class="container">
            <div class="col s12">
                <h4 class="grey-text">Configurações</h4>
            </div>
            <div class="col s12">
                <fieldset>
                    <legend>Cortar imagem do perfil</legend>
                    <img id="image" src="../../../{{$busca->foto}}">
                </fieldset>
            </div>
        </div>

    </div>


@stop