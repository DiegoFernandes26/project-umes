@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">

        <div class="row"><b>Histórico de emissões para: </b> {{$carteira->name}}</div>
        @include('admin.solicitacoes.links-head')
        @include('errors.errors_message')

        <table>
            <thead>
            <tr>
                <th>Emitida por</th>
                <th>Data da emissão</th>

            </tr>
            </thead>

            <tbody>
            <tr>

                @foreach($emissoes as $dados)
                    <td>{{$dados->user->name}}</td>
                    <td>{{date_format($dados->created_at,'d-m-Y')}}</td>
                @endforeach
            </tr>
            </tbody>
        </table>

    </div>
@stop