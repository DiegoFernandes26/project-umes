@extends('layout')
@section('content')
    @include('admin.menu')
<div class="container top__cem">

    <h3 class="grey-text">Modelos <strong>CADASTRADOS</strong></h3>


    @include('errors.errors_message')

{{--Chama o Modal para cadastrar no modelo--}}
    <div class="row">
        <div class="col s3">
            <a class="waves-effect waves-light btn btn-large cyan __cem left" href="#cad-verso"><i
                        class="material-icons left">add_circle</i>Novo Modelo</a>
        </div>
        <div class="col s9 ">
            <input type="text" class="campo-busca" placeholder="Buscar Modelo" id="busca-campo">
        </div>

    </div>


{{--Exibe todos os MODELOS de carteiras cadastrados--}}

    @if(isset($modelo)&& $modelo)
        <div class="row" id="cards">
            @foreach($modelo as $modelos)

                <div class="col s4">
                    <div class="card @if ($modelos->status==true)ativo_card @endif">

                        <div class="card-image">
                            <img src="{{asset($modelos->img_frontal)}}">
                            <div style="position:absolute;top: 10px;right: 5px; z-index: 999; background: trasparent">
                                {!! Form::radio('ativo',$modelos->id,($modelos->status?true:false), ['id'=>$modelos->id, 'name'=>'ativo'])!!}
                                {!! Form::label($modelos->id, 'Ativo') !!}
                            </div>
                        </div>
                        <div class="card-content">
                            <h5 class="texto-list truncate"
                                style="border-bottom: 1px solid #ccc;padding-bottom: 10px; font-weight: 800">
                                {{$modelos->name}}</h5>

                            <a href="{{route('cart.models.destroy', ['id'=>$modelos->id])}}"
                               class="btn __cem btn-flat">Excluir</a>   </li>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    @else
        <h4 class="grey-text">Ainda não existem MODELOS cadastrardos, que tal criar o primeiro?</h4>
    @endif





{{--Modal para cadastrar novo modelo--}}
    <div id="cad-verso" class="modal">
        <div class="modal-content">
            <h4>Cadastrar novo Modelo</h4>

            {!! Form::open(['route'=>'cart.models.store', 'method'=>'post', 'files'=>true]) !!}
            <div class="row">
                <div class="col s12">

                    {!! Form::label('name', 'Título do Modelo') !!}
                    {!! Form::text('name', null, ['placeholder'=>'Título do Modelo','name'=>'name']) !!}
                </div>
                <div class="col s12">

                    <div class="file-field input-field">
                        <div class="btn grey">
                            <span><i class="material-icons">crop_original</i>Imagem</span>
                            {!! Form::file('img_frontal') !!}
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
    {!! $modelo->render() !!}
</div>


{{--ativa os MODELOS quando clicado--}}
    <script type="text/javascript">

        $("input:radio[name='ativo']").click(function () {
            var nivel = $(this).val();
            $.get('/admin/ativar/' + nivel);
            location.reload();
        });
    </script>
@stop