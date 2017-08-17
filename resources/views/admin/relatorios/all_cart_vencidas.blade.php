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
        <th>Aluno</th>
        <th>Cadastrada em</th>
        <th>Vencida em</th>
        <th>Criada por</th>
    </tr>
    @if($relatorio)
        @foreach ($relatorio as $dados)
            <tr>
                <td>{{$dados->name}}</td>
                <td>{{date('d/m/Y', strtotime($dados->created_at))}}</td> 
                <td>{{date('d/m/Y', strtotime($dados->dt_validade))}}</td>               
                <td>{{$dados->user->name}}</td>                  
            </tr>
        @endforeach
    @endif
</table>

