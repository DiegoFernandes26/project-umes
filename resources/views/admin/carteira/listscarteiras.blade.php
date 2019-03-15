@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container top__cem">
        {{--FORM - inicio--}}
        <h3 class="grey-text">ALUNOS <strong>CADASTRADOS</strong></h3>


        <div class="row">
            <div class="col s3">
                <a class="waves-effect waves-light btn btn-large cyan __cem left" href="{{route('cart.index')}}"><i
                            class="material-icons left">add_circle</i>Nova carteira</a>
            </div>
            {!! Form::open(['route'=>'buscar.aluno', 'method'=>'post']) !!}
            <div class="col s8 ">
                {!! Form::text('name',null,['class'=>'campo-busca', 'placeholder'=>'Digite o nome ou parte do nome do aluno é tecle enter', 'submit'=>'buscar']) !!}
            </div>
            <div class="col col-sm-2">
                {!! Form::submit('Buscar', ['class' => 'btn blue']) !!}
            </div>
            {!! Form::close() !!}

        </div>


        {{--inicio filtros de busca--}}
        <div class="row">
            {!! Form::open(['route'=>'filtrar.aluno', 'method'=>'post']) !!}

            <div class="col s2">
                {!! Form::text('cpf', null, ['placeholder'=>'CPF do aluno']) !!}
            </div>
            <div class="col s3">
                {!! Form::select('instituicao', $instituicao, null,['placeholder'=>'Alunos por Instituição']) !!}
            </div>
            <div class="col s2">
                {{--                {!! Form::label('data_inicio','Inicio')!!}--}}
                {!! Form::date('data_inicio', null, ['placeholder'=>'Desde']) !!}
            </div>
            <div class="col s2">
                {{--                {!! Form::label('data_fim','Fim')!!}--}}
                {!! Form::date('data_fim', null, ['placeholder'=>'Até']) !!}
            </div>
            <div class="col s2">
                {!! Form::select('status', ['1'=>'Vencidas','2'=>'Não Vencidas'],(isset($paramBusca)? $paramBusca['status']:null), ['placeholder'=>'Status']) !!}
            </div>
            <div class="col s">
                {!! Form::submit('Buscar por parâmetro', ['class'=>'btn']) !!}
            </div>

            {!! Form::close() !!}
        </div>
        {{--fim filtros de busca--}}



        {{--FORM - inicio--}}
        @include('errors.errors_message')

        {{--{!! dd($alunos) !!}--}}

        {{--<p>Total de resultados: {!! $alunos->total() !!} alunos</p>--}}
        @if(count($alunos) > 0)
            {{--{!! dd($alunos) !!}--}}
            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header" id="collection-item">

                        @foreach($alunos as $aluno)
                            <li class="collection-item avatar lista-item grey lighten-5 ">

                                <div class="img-lista">
                                    <img src="{{(file_exists($aluno->foto)?asset($aluno->foto):asset('img/avatar.png'))}}"
                                         class="materialboxed">
                                </div>
                                {{--Imprime versão 2 da carteira--}}
                                <a href="{{route('cart.versao2_individual', ['id'=>$aluno->id])}}">
                                    <h5 class="texto-list">{{$aluno->name}}</h5>
                                </a>

                                {{--Imprime a versão antiga da carteira (Versão 1)--}}
                                <a href="{{route('cart.ver_individual', ['id'=>$aluno->id])}}">
                                    <h5 class="waves-effect waves-light btn-flat right-aline">V_1</h5>
                                </a>
                                <div class="bt-edicao">
                                    @if($aluno->pago == 0)
                                        <div class="chip">free</div>
                                    @else
                                        <div class="chip  blue-text">pago</div>
                                    @endif
                                    @if($aluno->dt_validade< date('Y-m-d'))
                                        <div class="card-vision red-text text-accent-4">
                                            @elseif(date('Y',strtotime($aluno->dt_validade)) == date('Y'))
                                                {{--{{date('Y',strtotime($aluno->dt_validade)). "E" .date('Y')}}--}}
                                                <div class="card-vision orange-text text-accent-4">
                                                    @else
                                                        <div class="card-vision green-text text-accent-4">
                                                            @endif
                                                            <i class="material-icons">credit_card</i>
                                                        </div>
                                                        <div>
                                                            <a href="{{route('cart.edit', ['id'=>$aluno->id])}}"
                                                               class="waves-effect waves-light btn-flat">Editar</a>
                                                        </div>

                                                        @if(Auth()->user()->nivel <= 1 ){{--Se tiver nivel admin, aparece a opção EXCLUIR--}}
                                                        <div>
                                                            {{--<a href="{{route('cart.destroy', ['id'=>$aluno->id])}}"--}}
                                                            <a href="#"
                                                               class="waves-effect waves-light btn-flat red-text text-darken-1"
                                                               onclick="deletar_modal({{$aluno->id}},'{{$aluno->name}}')">Excluir</a>
                                                        </div>
                                                        @endif
                                                </div>
                            </li>
                        @endforeach

                        @if(isset($paramBusca))
                            {!! $alunos->appends($paramBusca)->render() !!}
                        @else
                            {!! $alunos->render() !!}
                        @endif

                        @else
                            <div>
                                <h5 class="grey-text center">Não foram encontradas registros com os parâmetros
                                    informados :/</h5>
                            </div>
                    </ul>
                </div>
                @endif

            </div>
    </div>
@stop