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
            <h3>Instituição: {{$instituicao->nome}}</h3>

            <h3>Total de alunos: {!! count($relatorio) !!}</h3>
        </th>

    </tr>

    <tr>
        <th>Nome</th>
        <th>Nº Carteira</th>
        <th>Curso</th>
        <th>Validade</th>
        <th>Carteira criada por:</th>
    </tr>

    @if($relatorio)

        @foreach ($relatorio as $alunos)
            <tr>
                <td>{!! $alunos['name'] !!}</td>
                <td>{!! $alunos['numero_carteira'] !!}</td>
                <td>{!! $alunos->curso->name !!}</td>
                <td>{!! date('d-m-Y', strtotime($alunos['dt_validade'])) !!}</td>
                <td>{!! $alunos->user->name !!}</td>
            </tr>
        @endforeach
    @endif
</table>

