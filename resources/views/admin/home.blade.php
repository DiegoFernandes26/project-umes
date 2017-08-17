@extends('layout')
@section('content')

    @include('admin/menu')


    <div class="container top__cem">


        {{--blocos--}}
        <div class="row">
            <div class="col s3">
                <div class="card-panel white center-align grey-text text-darken-2">
                    <div class="chip">Geral</div>
                    <h1 class="dado-relatorio-cont dance">{{count($carteira)}}</h1>
                    <span><i class="material-icons left">credit_card</i>Carteiras emitidas </span>
                </div>
            </div>

            <div class="col s3">
                <div class="card-panel white center-align grey-text text-darken-2">
                    <div class="chip">Hoje</div>

                    <h1 class="dado-relatorio-cont dance">{{$hj}}</h1>
                    <span><i class="material-icons left">credit_card</i>Carteiras emitidas</span>
                </div>
            </div>

            <div class="col s3">
                <div class="card-panel white center-align grey-text text-darken-2">
                    <div class="chip">Geral</div>
                    <h1 class="dado-relatorio-cont dance">{{count($escola)}}</h1>
                    <span><i class="material-icons left">domain</i>Escolas</span>
                </div>
            </div>

            <div class="col s3">
                <div class="card-panel white center-align grey-text text-darken-2">
                    <div class="chip">Hoje R$</div>
                    <h1 class="dado-relatorio-cont dance" id="valorhj">{{$valorHj}}</h1>
                    <span><i class="material-icons left">monetization_on</i>Valor apurado</span>
                </div>
            </div>


        </div>
        {{--blocos--}}



        {{--relatorios--}}
        <div class="row">
            <div class="col s12">
                <div class="card-panel white center-align grey-text text-darken-2">
                    <h3 class="grey-text" style="font-weight: 800">RELATÓRIOS</h5>
                    <div class="row">
                        {{--bloco--}}
                        <a href="{{route('index.ganhos.por.inst')}}">
                        <div class="col s2 box-relatorio">
                            <p><i class="material-icons">attach_money</i></p>
                            <h6>Ganhos por instituição</h6>
                        </div>
                        </a>
                        {{--bloco--}}


                        {{--bloco--}}
                        <a href="{{route('index.cart.por.inst')}}">
                        <div class="col s2 box-relatorio">
                            <p><i class="material-icons">credit_card</i></p>
                            <h6>Carteiras por instituição</h6>
                        </div>
                        </a>
                        {{--bloco--}}

                        {{--bloco--}}
                        <a href="{{route('all.inst')}}">
                        <div class="col s2 box-relatorio">
                            <p><i class="material-icons">business</i></p>
                            <h6>Todas as instituições</h6>
                        </div>
                        </a>
                        {{--bloco--}}

 {{--bloco--}}
                        <a href="{{route('all.cursos')}}">
                        <div class="col s2 box-relatorio">
                            <p><i class="material-icons">school</i></p>
                            <h6>Todos os cursos ativos</h6>
                        </div>
                        </a>
                        {{--bloco--}}



                        {{--bloco--}}
                        <a href="{{route('cart.isentas')}}">
                        <div class="col s2 box-relatorio">
                            <p><i class="material-icons">card_giftcard</i></p>
                            <h6>Carteiras emitidas com insenção</h6>
                        </div>
                        </a>
                        {{--bloco--}}

                        {{--bloco--}}
                        <a href="{{route('cart.vencidas')}}">
                        <div class="col s2 box-relatorio">
                            <p><i class="material-icons">history</i></p>
                            <h6>Todas as carteiras vencidas</h6>
                        </div>
                        </a>
                        {{--bloco--}}


                    </div>

                </div>
            </div>
        </div>
        {{--relatorios--}}


    </div>



@stop