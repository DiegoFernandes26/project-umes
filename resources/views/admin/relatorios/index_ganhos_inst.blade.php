@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container top__cem">
        <h3 class="grey-text">Ganhos por <strong>Instituição</strong></h3>
    	<h4 class="grey-text">Selecione as datas</h4>
        @if($errors->any())
            <ul class="alert">
                @foreach($errors->all() as $erro)
                    <li>{{$erro}}</li>
                @endforeach
            </ul>
        @endif
    	{!! Form::open(['route'=>'ganhos.por.inst','method'=>'get'])!!}

    	<div class="row">
    	 <div class="col s6">
            {!! Form::label('dt_inicio','Data de inicío:') !!}
            {!! Form::date('dt_inicio', null, ['placeholder'=>'Data de inicio']) !!}
        </div>

        <div class="col s6">
            {!! Form::label('dt_fim','Data de fim:') !!}
            {!! Form::date('dt_fim', null, ['placeholder'=>'Data de fim']) !!}
        </div>

        </div>
        <div class="modal-footer">
        		{!! Form::submit('ENVIAR',['class'=>'btn waves-effect waves-green btn-flat'])!!}
   		</div>
    	{!! Form::close()!!}

    </div>
    @stop