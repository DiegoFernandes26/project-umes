@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container top__cem">

        <h3 class="grey-text margin__vinte">INSTITUIÇÕES DE <strong>ENSINO</strong></h3>
        <div class="row">
            <div class="col s3">
                <a href="{{route('escola.create')}}" class="waves-effect waves-light btn btn-large cyan __cem"><i
                            class="material-icons left">add_circle</i>Nova escola</a>
            </div>
            <div class="col s9 right">
                <input type="text" class="campo-busca" placeholder="Buscar curso" id="busca-campo">
            </div>
        </div>


        @if (session('status'))
            <ul class="alert-danger">
                <h5 class="grey-text">Sucesso :)</h5>
                <li>{{ session('status') }}</li>
            </ul>
        @endif
        <ul class="collection with-header" id="collection-item">
            @foreach($esc as $escola)
                <li class="collection-item avatar lista-item  grey lighten-5">
                    <div class="dados-edicao-home">
                        <h5 class="texto-list">{{$escola->nome}}</h5>
                    </div>
                    {{--<td>{{$escola->id}}</td>--}}
                    {{--<td>{{$escola->cnpj}}</td>--}}
                    {{--@foreach($escola->cursos as $curso)--}}
                    {{--<td>{{$curso->name}}</td>--}}
                    {{--@endforeach--}}

                    <div class="bt-edicao">
                        <div>
                            <a href="{{route('admin.escola.edit', ['id' =>$escola->id])}}"
                               class="waves-effect waves-light btn-flat">Editar</a>
                        </div>
                        <div>
                            @if($relation->checkRelEscola($escola->id)==null)
                            <a href="{{route('admin.escola.destroy', ['id'=>$escola->id])}}"
                               class="waves-effect waves-light btn-flat red-text text-darken-1">Excluir</a>
                               @else
                            <a href="{{route('admin.escola.destroy', ['id'=>$escola->id])}}" class="waves-effect waves-light btn-flat disabled">Excluir</a>
                               @endif
                        </div>
                    </div>

                </li>
            @endforeach
        </ul>
        {{--paginação--}}
        {!! $esc->render() !!}
    </div>



@stop