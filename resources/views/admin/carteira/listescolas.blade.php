{{--esta página serve apenas para lista as escolas do campo de busca--}}
<ul class="collection with-header">
    @foreach($escolas as $key => $nome)
        <li class="collection-item avatar lista-item  grey lighten-5">
            <a href="create/{{$key}}"><h5 class="texto-list">{{$nome}}</h5></a>
        </li>
    @endforeach
</ul>