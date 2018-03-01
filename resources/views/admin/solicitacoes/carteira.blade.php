@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">
        <div class="row">
            <h4>Analise de solicitação</h4>
            @include('admin.solicitacoes.links-head')
            @include('errors.errors_message')

            <fieldset>
                <legend>Dados</legend>
                <div class="row col s12">
                    <div class="row">
                        <div class="col s3">
                            <b>Nome: </b>{{$carteira->name}}
                        </div>
                        <div class="col s2">
                            <b> Nome social: </b>{{$carteira->nome_social != null?$carteira->nome_socail: '--'}}
                        </div>
                        <div class="col s2">
                            <b>Sexo: </b>{{$carteira->sexo == 'm'?'Masculino':'Feminino'}}
                        </div>
                        <div class="col s3">
                            <b>Data de Nascimento: </b>{{date('m/d/Y',strtotime($carteira->dt_nascimento))}}
                        </div>
                        <dvi class="col s2">
                            <b>Mãe: </b>{{$carteira->mae}}
                        </dvi>
                    </div>
                    <div class="row">
                        <div class="col s3">
                            <b>E-Mail: </b>{{$carteira->email}}
                        </div>
                        <div class="col s3">
                            <b>Celular: </b>{{$carteira->celular}}
                        </div>
                        <div class="col s3">
                            <b>Tel-Fixo: </b>{{$carteira->tel_fixo?$carteira->tel_fixo:'--'}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s4">
                            <b>Instituição: </b>{{$carteira->escola->nome}}
                        </div>

                        <div class="col s3">
                            <b>Curso: </b>{{$carteira->curso->name}}
                        </div>

                        <div class="col s3">
                            <b>Período: </b>{{$carteira->periodo?$carteira->periodo.'º':'--' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s4">
                            <b>RG: </b>{{$carteira->rg}}
                        </div>

                        <div class="col s4">
                            <b>Órgão Expedidor: </b>{{strtoupper($carteira->org_expedidor)}}
                        </div>

                        <div class="col s4">
                            <b>CPF: </b>{{$carteira->cpf}}
                        </div>
                    </div>
                    <div class="row">
                        <b>Comprovante RG: </b>
                        @if($carteira->rg_frente)
                            <a href="{{URL::to($carteira->rg_frente)}}" target="_blank">Download</a>
                        @endif
                    </div>

                </div>
            </fieldset>
        </div>

        <div class="row">
            <fieldset>
                <legend>Devolver para ajustes</legend>
                {!! Form::open(['route'=>['solicitacoes.mensagem',$carteira->id], 'method'=>'post', 'class'=>'col s12']) !!}


                <div class="row">
                    <div class="input-field col s12">
                        {!! Form::label('conteudo','Mensagem') !!}
                        {!! Form::text('conteudo',null,['id'=>'conteudo','placeholder'=>'Indicar pontos para correção.']) !!}
                        @if ($errors->has('conteudo'))
                            <span class="help-block">
                                        <strong class="red-text">{{ $errors->first('conteudo') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                {!! Form::submit('Enviar Mensagem',['class'=>'btn btn-success']) !!}

                <a href="{{route('solicitacoes.apr',$carteira->id)}}">
                    <button class="btn btn-info">Aprovar</button>
                </a>
                <a href="{{route('solicitacoes.rep',$carteira->id)}}">
                    <button class="btn btn-info red darken-2">Reprovar</button>
                </a>
                <a href="{{route('solicitacoes.des',$carteira->id)}}">
                    <button class="btn btn-info red darken-2">Desaprovar</button>
                </a>
                {!! Form::close() !!}
            </fieldset>

            <br>


        </div>
    </div>
@stop