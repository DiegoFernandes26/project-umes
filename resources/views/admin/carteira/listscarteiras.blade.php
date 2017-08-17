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
            <div class="col s9 ">
                <input type="text" class="campo-busca" placeholder="Buscar curso" id="busca-campo">
            </div>
        </div>


        {{--FORM - inicio--}}
        @if (session('status'))
            <ul class="alert-danger">
                <li>{{ session('status') }}</li>
            </ul>
        @endif
        <p>{!! count($alunos) !!} alunos</p>
        @if(count($alunos) > 0)
            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header" id="collection-item">
                        @foreach($alunos as $aluno)
                        <li class="collection-item avatar lista-item grey lighten-5 ">
                        
                                <div class="img-lista"><img src="../../{{$aluno->foto}}" class="materialboxed">
                                </div>
                                <a href="{{route('cart.ver_individual', ['id'=>$aluno->id])}}"><h5
                                            class="texto-list">{{$aluno->name}}</h5></a>
                                <div class="bt-edicao">
                                    @if($aluno->pago == 0)
                                        <div class="chip">free</div>
                                    @else
                                        <div class="chip">pago</div>
                                    @endif
                                    @if($aluno->dt_validade< date('Y-m-d'))
                                        <div class="card-vision red-text text-accent-4">
                                            @else
                                                <div class="card-vision green-text text-accent-4">
                                                    @endif
                                                    <i class="material-icons">credit_card</i>
                                                </div>
                                                <div>
                                                    <a href="{{route('cart.edit', ['id'=>$aluno->id])}}"
                                                       class="waves-effect waves-light btn-flat">Editar</a>
                                                </div>
                                                <div>
                                                    {{--<a href="{{route('cart.destroy', ['id'=>$aluno->id])}}"--}}
                                                    <a href="#"
                                                       class="waves-effect waves-light btn-flat red-text text-darken-1"
                                                       onclick="deletar_modal({{$aluno->id}},'{{$aluno->name}}')">Excluir</a>
                                                </div>
                                        </div>
                            </li>
                        @endforeach
                        @else
                            <div>
                                <h3 class="grey-text">Não existe alunos cadastrados!</h3>
                            </div>
                    </ul>
                </div>
                @endif


            </div>
    </div>



@stop