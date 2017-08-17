<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
<table>
    <tr>
        <th colspan="4">
            <h1>{{$config->titulo}}</h1>
        </th>
    </tr>
    <tr>
        <td>De: {{$dt_inicio}}</td>
        <td>Até: {{$dt_fim}}</td>
    </tr>
    <tr>
        <th>Instituição</th>
        <th>Data Inicial</th>
        <th>Data final</th>
        <th>Total de carteiras</th>
    </tr>
    @if($relatorio)
        @foreach ($relatorio as $dados)
            <tr>
                <td>{{$dados['nome']}}</td>
                <td>{{$dados['created_at']}}</td>
                <td>#</td>
                <td>{{$dados['carteiras']}}</td>
            </tr>
        @endforeach
    @endif
</table>

