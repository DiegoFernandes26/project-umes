@extends('layout')
@section('content')
    <nav>
        <div class="nav-wrapper  light-blue darken-4">
            <a href="#!" class="brand-logo"><img src="{{asset('img/logo_moobile.png')}}" width="50px" style="margin-top: 3px;"></a>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

            <ul class="side-nav" id="mobile-demo">
                {{--<li><a href="sass.html">Sass</a></li>--}}
                {{--<li><a href="badges.html">Components</a></li>--}}
            </ul>
        </div>
    </nav>


    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col s12 grey lighten-3 case-perfil-vizualiza" style="padding: 4% 0;">
                <div class="chip">Perfil</div>
                <div class="foto-perfil-vizualizar">
                    <img src="{{asset($busca->foto)}}">
                </div>
                <h4 style="text-transform: uppercase">{{$busca->name}}</h4>
                <h6><strong>CPF: </strong>{{$busca->cpf}}</h6>
            </div>
        </div>
    </div>

    <div class="container">
        <ul class="collapsible" data-collapsible="accordion">
            <li>
                <div class="collapsible-header"><i class="material-icons">face</i>Dados Pessoais</div>
                <div class="collapsible-body">
                    {{--dados--}}
                    <ul class="collection">
                        <li class="collection-item"><strong>RG: </strong>{{$busca->rg}}</li>
                        <li class="collection-item"><strong>CPF: </strong>{{$busca->cpf}}</li>
                        <li class="collection-item">
                            <strong>NASC.: </strong>{{date('d/m/Y',strtotime($busca->dt_nascimento))}}</li>
                    </ul>
                    {{--dados--}}
                </div>
            </li>
            <li>
                <div class="collapsible-header"><i class="material-icons">school</i>Dados acadêmicos</div>
                <div class="collapsible-body">
                    {{--dados--}}
                    <ul class="collection">
                        <li class="collection-item"><strong>Instituição: </strong>{{$busca->escola->nome}}</li>
                        <li class="collection-item"><strong>Curso: </strong>{{$curso->name}}</li>
                        <li class="collection-item"><strong>Nível: </strong>
                            @if($curso->nivel=='1'):
                            Fundamental
                            @elseif($curso->nivel=='2')
                                Médio
                            @elseif($curso->nivel=='3')
                                Superior
                            @elseif($curso->nivel=='4')
                                Profissional
                            @endif
                            {{--                            {{$curso->nivel}}--}}
                        </li>
                    </ul>
                    {{--dados--}}
                </div>
            </li>
            <li>
                <div class="collapsible-header"><i class="material-icons">account_box</i>Documentos</div>


                <div class="collapsible-body">
                    <fieldset>
                        <legend>RG</legend>
                        @if($busca->rg_frente)
                            <img src="{{asset($busca->rg_frente)}}" class="materialboxed">
                        @else
                            <p>Indisponível</p>
                        @endif
                    </fieldset>
                </div>

            </li>
        </ul>
    </div>




    <div class="container">
        <div class="row">
            <div class="col s12">
                <button class="btn btn btn-flat" style="border: 1px solid #aaa; border-radius: 20px; width: 100%; margin-top: 5%;">
                    <i class="material-icons left">info</i>  Certificado digital
                </button>
            </div>
        </div>
    </div>

@stop