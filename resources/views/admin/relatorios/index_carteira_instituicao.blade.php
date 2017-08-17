@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">
    	<h2>Carteiras por Instituição:</h2>
    	<h3>Selecione as datas</h3>
        @if($errors->any())
            <ul class="alert">
                @foreach($errors->all() as $erro)
                    <li>{{$erro}}</li>
                @endforeach
            </ul>
        @endif
    	{!! Form::open(['route'=>'cart.por.inst','method'=>'get'])!!}

    	<div class="row l12">	
    	 <div class="col s4">
            {!! Form::label('dt_inicio','Data de inicío:') !!}
            {!! Form::date('dt_inicio', null, ['placeholder'=>'Data de inicio']) !!}
        </div>

        <div class="col s4">
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