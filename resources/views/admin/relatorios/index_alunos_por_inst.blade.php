@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">
        <h2>Todos os Alunos por Instituição:</h2>
        <h3>Selecione a instituição desejada</h3>


        @include('errors.errors_message')



        {!! Form::open(['route'=>'relatorios.alunos.por.instituicao','method'=>'post'])!!}

        <div class="row l12">
            <div class="col s12">
                {!! Form::label('Instituicao','Instituição:') !!}
                {!! Form::select('instituicao', $instituicoes, null, ['placeholder'=>'Escolha uma instituição']) !!}
            </div>


        </div>
        <div class="modal-footer">
            {!! Form::submit('Emitir relário',['class'=>'btn waves-effect '])!!}
        </div>
        {!! Form::close()!!}

    </div>
@stop