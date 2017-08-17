@extends('template')
@section('content')
    <h1>Carteirinha Admin:</h1>

    <br><br>
    <table class="table">
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Matricula</th>
            <th>EndeID</th>
        </tr>

        @foreach($aluno as $alun)
        <tr>
            <td>{{$alun->id}}</td>
            <td>{{$alun->name}}</td>
            <td>{{$alun->matricula}}</td>
        </tr>
            @foreach($aluno->enderecos as $ende)
                <td>{{$ende->id}}</td>
            @endforeach
        @endforeach
    </table>
@stop