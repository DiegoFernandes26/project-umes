@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">

        <h4>Carteiras aprovadas</h4>
        @include('admin.solicitacoes.links-head')
        @include('errors.errors_message')

        <table>
            <thead>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Aprovador</th>
                <th>Status</th>
                <th>Ação</th>
                <th>Historico Emissões</th>
            </tr>
            </thead>

            <tbody>
            <tr>

                @foreach($carteiras as $dados)
                    <td>{{$dados->id}}</td>
                    <td>{{$dados->name}}</td>
                    <td>
                        <botton class="">{{\App\User::find($dados->view_by)->name}}</botton>
                    </td>
                    <td>
                        <botton class="btn btn-default">{{$dados->status}}</botton>
                    </td>

                    <td>
                        @if(count($dados->emissoes)==0)
                            <a href="{{route('solicitacoes.emitir',$dados->id)}}" class="btn green accent-4">
                                Emitir</a>
                        @else
                            <a href="{{route('solicitacoes.emitir',$dados->id)}}" class="btn btn-darken-2 red">
                                {{count($dados->emissoes)}} Emissões</a>
                        @endif
                    </td>

                    <td>
                        <a href="{{route('solicitacoes.des',$dados->id)}}" class="btn btn-darken-2 red">Desaprovar</a>
                    </td>

                    @if(count($dados->emissoes)>0)
                        <td><a href="{{route('solicitacoes.historicoEmissoesPorCarteira',$dados->id)}}"
                               class="btn green accent-4">Historico</a></td>
                    @else
                        <td><a href="#" class="btn green accent-4 disabled">S/Historico</a></td>
                    @endif
                @endforeach
            </tr>
            </tbody>
        </table>

    </div>
@stop