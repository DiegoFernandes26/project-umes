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
        <th>Instituição</th>
        <th>Cadastrada em</th>
        <th>Cadastrada por</th>
        <th>Nível(s)</th>
    </tr>
    
    @if($relatorio)
        @foreach ($relatorio as $dados)
            <tr>
                <td>{{$dados->nome}}</td>
                <td>{{date('d/m/Y', strtotime($dados->created_at))}}</td>
                <td>{{$dados->user->name}}</td>
                <td>
                    {{($dados->fundamental == 1?'F|':'')}}
                    {{($dados->medio == 1?'M|':'')}}
                    {{($dados->superior == 1?'S|':'')}}
                    {{($dados->pre_nem == 1?'PE|':'')}}
                    {{($dados->outros == 1?'O':'')}}
                </td>
            </tr>
        @endforeach
    @endif
</table>

