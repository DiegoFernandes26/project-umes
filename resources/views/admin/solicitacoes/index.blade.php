@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">

        <div class="row inline">
            <h4>CARTEIRAS</h4>
            @include('admin.solicitacoes.links-head')
        </div>
        @include('errors.errors_message')
        <div class="row">
            <div class="col s12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Ação</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($solicitacoes as $dados)
                            <td>{{$dados->id}}</td>
                            <td>{{$dados->name}}</td>
                            <td><a href="{{route('solicitacoes.analisar',$dados->id)}}">Analisar</a></td>
                            <td><a href="#"
                                   class="btn btn-{{$dados->status == 'aprovado'?'default':'darken red'}}">{{$dados->status}}</a>
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop