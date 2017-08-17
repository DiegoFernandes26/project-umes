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
        <th>Curso</th>
        <th>Cadastrado em</th>
        <th>Alunos pertecentes</th>
        <th>##</th>
    </tr>
    @if($relatorio)
        @foreach ($relatorio as $dados)
            <tr>
                <td>{{$dados->name}}</td>
                <td>{{date('d/m/Y', strtotime($dados->created_at))}}</td>
                
                <td>{{count($dados->aluno)}}</td>
                                	             
                <td>#</td>
            </tr>
        @endforeach
    @endif
</table>

