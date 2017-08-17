@extends('layout')
@section('content')
    @include('admin.menu')


    <div class="container top__cem">
        <div class="row">
            <div class="col s12">
                <h3 class="grey-text" style="font-weight: 800">USUÁRIOS</h3>
            </div>
            <div class="row">
                <div class="col s3">
                    <a href="{{route('register')}}" class="waves-effect waves-light btn btn-large cyan __cem"><i
                                class="material-icons left">add_circle</i>Novo usuário</a>
                </div>
                <div class="col s9 right">
                    <input type="text" class="campo-busca" placeholder="Buscar curso" id="busca-campo">
                </div>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            {{--usuários--}}
            <ul class="collection with-header" id="collection-item">
                @foreach($users as $usuario)

                    <li class="collection-item avatar lista-item  grey lighten-5">

                        <div class="dados-edicao-home">
                            <h5 class="texto-list">{{$usuario->name}}</h5>
                        </div>
                        <div class="bt-edicao" style="width: 450px;">
                            @if($usuario->id != auth()->user()->id)
                            <div style="width: 150px;">
                                <div class="switch">
                                    <label>
                                        Inativo
                                        {!! Form::checkbox('ativo', $usuario->id, ($usuario->status == 1 ? true : false),['id' => $usuario->id, 'name'=>'status'] ) !!}
                                        <span class="lever"></span>Ativo
                                    </label>
                                </div>
                            </div>
                            @endif
                            <div>
                            <!-- <p class="chip">{!! ($usuario->status == 1 ? "Ativo" : "Inativo") !!}</p> -->
                            </div>
                            <div>
                                <a href="{{route('usuario.edit', ['id' => $usuario->id])}}"
                                   class="waves-effect waves-light btn-flat">Editar</a>
                            </div>
                            <div>
                                @if($usuario->id == auth()->user()->id)
                                    <a href="#!" class="waves-effect waves-light btn-flat text-darken-1">Você</a>
                                @else
                                    @if($relation->checkRelUser($usuario->id)==null)
                                        <a href="{{route('usuario.delete', ['id' => $usuario->id])}}"
                                           class="waves-effect waves-light btn-flat red-text text-darken-1">Excluir</a>
                                    @else
                                        <a href="{{route('usuario.inativar', ['id' => $usuario->id])}}"
                                           class="waves-effect waves-light btn-flat disabled" title="Este usuário possui ações realizados no sistema!">Excluir</a>
                                    @endif
                                @endif
                            </div>

                        </div>
                    </li>
                @endforeach
            </ul>
            {{--Script para mudar o status do usuário de ativo para inativo e vice-versa --}}
            <script type="text/javascript">
                $("input:checkbox[name='status']").click(function(){
                    var status = $(this).val();
                    $.get('/admin/usuarios/ativa_user/'+status);
                });
            </script>

        </div>
    </div>
@endsection