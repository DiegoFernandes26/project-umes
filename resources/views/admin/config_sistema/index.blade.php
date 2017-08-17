@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">
        <h3 class="grey-text">Configurações</h3>

        @if($sistema)
            @foreach($sistema as $system)
                <h4>Titulo: {{$system->titulo}}</h4>
                <p>{{$system->descricao}}</p>
                <h4>Valor virgente da carteira: R${{$system->valor}}</h4>
                <h5>Data de expiração das carteiras: {{date('d-m-Y', strtotime($system->dt_expiracao))}}</h5>

                <p>Logo do sistem:</p>
                <div class="card-image">
                    <img src="../../{{$system->logo_sistema}}"/>
                </div>

                <a href="{{route('config.edit',['id'=>$system->id])}}">Editar</a>
            @endforeach
        @else
            <a href="{{route('config.create')}}">Configurar</a>
        @endif
    </div>
@stop