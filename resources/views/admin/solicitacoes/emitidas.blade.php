@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container">

        <h4>Carteiras aprovadas</h4>
        @include('errors.errors_message')

        <table>
            <thead>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Aprovador</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
            </thead>

            <tbody>
            <tr>

                @foreach($carteiras as $dados)
                    <td>{{$dados->id}}</td>
                    <td>{{$dados->name}}</td>
                    <td><botton class="">{{\App\User::find($dados->view_by)->name}}</botton></td>
                    <td><botton class="btn btn-default">{{$dados->status}}</botton></td>
                    <td><a href="#" class="btn btn-darken-2 red">Emitir</a></td>
                @endforeach
            </tr>
            </tbody>
        </table>

    </div>
@stop