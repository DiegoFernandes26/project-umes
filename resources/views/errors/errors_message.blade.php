@if($errors->any())
    <ul class="alert red lighten-1">
        @foreach($errors->all() as $erro)
            <li class="white-text">{{$erro}}</li>
        @endforeach
    </ul>
@endif

@if (session('status'))
    <div class="alert teal accent-3 teal-text">
        {{ session('status') }}
    </div>
@endif