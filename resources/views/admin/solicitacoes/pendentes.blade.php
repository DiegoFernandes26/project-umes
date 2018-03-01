@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">

        <h4>Carteiras pendentes</h4>
        @include('admin.solicitacoes.links-head')
        @include('errors.errors_message')

        <table>
            <thead>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Status</th>
            </tr>
            </thead>

            <tbody>
            <tr>

                @foreach($carteiras as $dados)
                    <td>{{$dados->id}}</td>
                    <td>{{$dados->name}}</td>
                    <td><botton class="btn btn-darken red">{{$dados->status}}</botton></td>
                @endforeach
            </tr>
            </tbody>
        </table>

    </div>
@stop