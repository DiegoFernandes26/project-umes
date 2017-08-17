@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container top__cem">
        {{--FORM - inicio--}}
        <h3 class="grey-text" style="font-weight: 800">CURSOS</h3>
        @include('admin.curso.create')
        <div class="row">
            <div class="col s3">
                <a class="waves-effect waves-light btn btn-large cyan __cem left" href="#cad-curso"><i
                            class="material-icons left">add_circle</i>Novo curso</a>
            </div>
            <div class="col s9 ">
                <input type="text" class="campo-busca" placeholder="Buscar curso" id="busca-campo">
            </div>
        </div>


        {{--FORM - inicio--}}
        @if (session('status'))
            <ul class="alert-danger">
                <h5 class="grey-text">Sucesso :)</h5>
                <li>{{ session('status') }}</li>
            </ul>
        @endif
        <p>{!! count($cursos) !!} Cursos cadastrados</p>
        @if(count($cursos) > 0)
            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header" id="collection-item">
                        @foreach($cursos as $curso)
                            <li class="collection-item avatar lista-item  grey lighten-5">
                                <div class="dados-edicao-home">
                                    <h5 class="texto-list">{{$curso->name}}</h5>
                                </div>

                                <div class="dados-edicao-home">
                                    <button class="btn disabled btn-flat"><i
                                                class="material-icons left">swap_vert</i>Nível: {{($curso->nivel == 1 ? "Fundamental" : ($curso->nivel == 2?"Médio":($curso->nivel == 3 ? "Superior" : "Profissional")))}}
                                    </button>
                                </div>
                                <div class="bt-edicao">
                                    <div>
                                        {{--   <a href="{{route('cursos.edit', ['id' =>$curso->id])}}" --}}
                                        <a href="#" class="waves-effect waves-light btn-flat" onclick="editar_modal({{$curso->id}})">Editar</a>
                                    </div>
                                    <div>
                                        @if($relation->checkRelCursos($curso->id)==null)
                                            {{--<a href="{{route('cursos.destroy', ['id'=>$curso->id])}}"--}}
                                            <a href="#" class="waves-effect waves-light btn-flat red-text text-darken-1"
                                               onclick="deletar_modal({{$curso->id}},'{{$curso->name}}')">Excluir</a>
                                        @else
                                            <a href="{{route('cursos.destroy', ['id'=>$curso->id])}}"
                                               class="waves-effect waves-light btn-flat disabled" title="Não é possível excluir cursos apos a vinculação de alunos">Excluir</a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        @else
                            <div>
                                <h3>Não Existem cursos cadastros ainda!</h3>
                            </div>
                    </ul>
                </div>
                @endif


            </div>
    </div>












@stop